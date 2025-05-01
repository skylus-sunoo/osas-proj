<?php

// Database constants
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define('DB_NAME', 'db_osas');

define('TB_ADMISSION_USER', 'tb_admission_user');
define('TB_ADMISSION_INFO', 'tb_admission_info');
define('TB_ADMISSION_PERSONAL', 'tb_admission_personal');
define('TB_ADMISSION_FAMILY', 'tb_admission_family');
define('TB_ADMISSION_EDUCATION', 'tb_admission_education');
define('TB_ADMISSION_MEDICAL', 'tb_admission_medical');
define('TB_EVENT', 'tb_event');
define('TB_STUDENT', 'tb_student');

// Database connection
$connections = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

/**
 * Advanced function to fetch data from a table with support for multiple filters
 * 
 * @param string $tableName The name of the table
 * @param string|array $columns The column(s) to retrieve - string for single column, array for multiple columns, "*" for all
 * @param string|array|null $attributeWhere Column name(s) for filtering
 * @param mixed|array|null $attributeWhereValue Value(s) to filter by
 * @return mixed Single value, array of rows, single row object, or null on error
 */
function fetchData($tableName, $columns = "*", $attributeWhere = null, $attributeWhereValue = null)
{
    global $connections;  // Use the global connection variable

    // Format columns for the query
    if (is_array($columns)) {
        // If columns is an array, join them with backticks for the query
        $columnsStr = "`" . implode("`, `", $columns) . "`";
    } else {
        // If columns is a string, use it directly (could be "*" or a single column name)
        $columnsStr = $columns === "*" ? "*" : "`$columns`";
    }

    // Initialize the query
    $query = "SELECT $columnsStr FROM `$tableName`";

    // Handle the WHERE clause
    $paramTypes = "";
    $bindValues = [];

    // Check if we have filtering conditions
    if ($attributeWhere !== null && $attributeWhereValue !== null) {
        // Convert single values to arrays for consistent handling
        if (!is_array($attributeWhere)) {
            $attributeWhere = [$attributeWhere];
        }

        if (!is_array($attributeWhereValue)) {
            $attributeWhereValue = [$attributeWhereValue];
        }

        // Verify arrays have the same size
        if (count($attributeWhere) !== count($attributeWhereValue)) {
            // Error: Arrays must have the same size
            error_log("fetchData error: attributeWhere and attributeWhereValue arrays must have the same size");
            return null;
        }

        // Build the WHERE clause
        $whereClauses = [];
        for ($i = 0; $i < count($attributeWhere); $i++) {
            $whereClauses[] = "`" . $attributeWhere[$i] . "` = ?";

            // Determine parameter type
            $paramTypes .= is_int($attributeWhereValue[$i]) ? 'i' : 's';

            // Add value to bind
            $bindValues[] = $attributeWhereValue[$i];
        }

        // Add WHERE clause to query
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    }

    // Prepare the statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        // Bind parameters if we have conditions
        if (!empty($bindValues)) {
            // Create array with $paramTypes as first element, followed by references to each value
            $bindParams = [$stmt, $paramTypes];

            foreach ($bindValues as $key => $value) {
                // We need to bind by reference, so create references to each array element
                $bindParams[] = &$bindValues[$key];
            }

            // Call bind_param with the unpacked array of references
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // If we're fetching just a single column
        if ($columns !== "*" && !is_array($columns)) {
            // Single column, single row
            if ($row = mysqli_fetch_assoc($result)) {
                $singleValue = $row[$columns];
                mysqli_stmt_close($stmt);
                return $singleValue;
            } else {
                mysqli_stmt_close($stmt);
                return null;
            }
        } else {
            // For "*" or multiple columns, ALWAYS return an array of rows
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row; // Add each associative array row to the $rows array
            }
            mysqli_stmt_close($stmt);
            return $rows; // Return the array of rows (can be empty if no results)
        }

        mysqli_stmt_close($stmt);
        return $rows;
    } else {
        // Handle the error if the query failed
        showMySQLiAlert($connections);
        return null;
    }
}

/**
 * Enhanced function to check for data in a table with support for multiple filters and advanced conditions.
 *
 * @param string $tableName Table to check.
 * @param array|null $conditions Array of conditions, each item as ['column', 'operator', value (optional)]
 *                               e.g. [['admission_id', '=', 1], ['admission_Branch', 'IS NOT NULL']]
 * @return bool True if at least one row matches, false otherwise or on error.
 */
function checkForData($tableName, $conditions = null)
{
    global $connections;

    $query = "SELECT COUNT(*) FROM `$tableName`";
    $paramTypes = "";
    $bindValues = [];
    $whereClauses = [];

    if (!empty($conditions)) {
        foreach ($conditions as $condition) {
            $column = $condition[0];
            $operator = strtoupper($condition[1]);
            $value = $condition[2] ?? null;

            if (in_array($operator, ['IS NULL', 'IS NOT NULL'])) {
                $whereClauses[] = "`$column` $operator";
            } else {
                $whereClauses[] = "`$column` $operator ?";
                $paramTypes .= is_int($value) ? 'i' : 's';
                $bindValues[] = $value;
            }
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    }

    if ($stmt = mysqli_prepare($connections, $query)) {
        if (!empty($bindValues)) {
            $bindParams = [$stmt, $paramTypes];
            foreach ($bindValues as $key => $value) {
                $bindParams[] = &$bindValues[$key];
            }
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        $exists = false;

        if (mysqli_stmt_fetch($stmt)) {
            $exists = $count > 0;
        }

        mysqli_stmt_close($stmt);
        return $exists;
    } else {
        showMySQLiAlert($connections);
        return false;
    }
}

/**
 * Advanced function to update data in a table with support for multiple columns and filters
 * 
 * @param string $tableName The name of the table
 * @param string|array $attributeToUpdate Column name(s) to update
 * @param mixed|array $attributeToUpdateValue Value(s) to set
 * @param string|array|null $attributeWhere Column name(s) for filtering
 * @param mixed|array|null $attributeWhereValue Value(s) to filter by
 * @return bool True on success, false on failure
 */
function updateData($tableName, $attributeToUpdate, $attributeToUpdateValue, $attributeWhere = null, $attributeWhereValue = null)
{
    global $connections;  // Use the global connection variable

    // Convert single values to arrays for consistent handling
    if (!is_array($attributeToUpdate)) {
        $attributeToUpdate = [$attributeToUpdate];
    }

    if (!is_array($attributeToUpdateValue)) {
        $attributeToUpdateValue = [$attributeToUpdateValue];
    }

    // Verify update arrays have the same size
    if (count($attributeToUpdate) !== count($attributeToUpdateValue)) {
        error_log("updateData error: attributeToUpdate and attributeToUpdateValue arrays must have the same size");
        return false;
    }

    // Build the SET clause
    $setClauses = [];
    for ($i = 0; $i < count($attributeToUpdate); $i++) {
        $setClauses[] = "`" . $attributeToUpdate[$i] . "` = ?";
    }

    // Initialize the query
    $query = "UPDATE `$tableName` SET " . implode(", ", $setClauses);

    // Initialize parameter types and values arrays
    $paramTypes = "";
    $bindValues = [];

    // Add update values to parameter arrays
    foreach ($attributeToUpdateValue as $value) {
        $paramTypes .= is_int($value) ? 'i' : 's';
        $bindValues[] = $value;
    }

    // Handle the WHERE clause
    if ($attributeWhere !== null && $attributeWhereValue !== null) {
        // Convert single values to arrays for consistent handling
        if (!is_array($attributeWhere)) {
            $attributeWhere = [$attributeWhere];
        }

        if (!is_array($attributeWhereValue)) {
            $attributeWhereValue = [$attributeWhereValue];
        }

        // Verify where arrays have the same size
        if (count($attributeWhere) !== count($attributeWhereValue)) {
            error_log("updateData error: attributeWhere and attributeWhereValue arrays must have the same size");
            return false;
        }

        // Build the WHERE clause
        $whereClauses = [];
        for ($i = 0; $i < count($attributeWhere); $i++) {
            $whereClauses[] = "`" . $attributeWhere[$i] . "` = ?";

            // Add to parameter types and values
            $paramTypes .= is_int($attributeWhereValue[$i]) ? 'i' : 's';
            $bindValues[] = $attributeWhereValue[$i];
        }

        // Add WHERE clause to query
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    }

    // Prepare the statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        if (!empty($bindValues)) {
            // Create array with $paramTypes as first element, followed by references to each value
            $bindParams = [$stmt, $paramTypes];

            foreach ($bindValues as $key => $value) {
                // We need to bind by reference, so create references to each array element
                $bindParams[] = &$bindValues[$key];
            }

            // Call bind_param with the unpacked array of references
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the query
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    } else {
        showMySQLiAlert($connections);
        return false;
    }
}

/**
 * Advanced function to insert data into a table with support for multiple columns
 * Can also insert a row with only default values
 * 
 * @param string $tableName The name of the table
 * @param string|array|null $attributeToInsert Column name(s) for insertion (optional)
 * @param mixed|array|null $attributeToInsertValue Value(s) to insert (optional)
 * @return bool True on success, false on failure
 */
function insertData($tableName, $attributeToInsert = null, $attributeToInsertValue = null)
{
    global $connections;  // Use the global connection variable

    // Check if we're inserting a row with only default values
    if ($attributeToInsert === null && $attributeToInsertValue === null) {
        // Simple INSERT with default values only
        $query = "INSERT INTO `$tableName` () VALUES ()";

        if ($stmt = mysqli_prepare($connections, $query)) {
            // Execute the query
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        } else {
            showMySQLiAlert($connections);
            return false;
        }
    }

    // Continue with standard insertion logic when columns and values are provided

    // Convert single values to arrays for consistent handling
    if (!is_array($attributeToInsert)) {
        $attributeToInsert = [$attributeToInsert];
    }

    if (!is_array($attributeToInsertValue)) {
        $attributeToInsertValue = [$attributeToInsertValue];
    }

    // Verify arrays have the same size
    if (count($attributeToInsert) !== count($attributeToInsertValue)) {
        echo ("insertData error: attributeToInsert and attributeToInsertValue arrays must have the same size");
        return false;
    }

    // Build the column names part
    $columns = [];
    foreach ($attributeToInsert as $column) {
        $columns[] = "`" . $column . "`";
    }

    // Build the placeholders for values
    $placeholders = array_fill(0, count($attributeToInsert), "?");

    // Initialize the query
    $query = "INSERT INTO `$tableName` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

    // Initialize parameter types and values arrays
    $paramTypes = "";
    $bindValues = [];

    // Add values to parameter arrays
    foreach ($attributeToInsertValue as $value) {
        $paramTypes .= is_int($value) ? 'i' : 's';
        $bindValues[] = $value;
    }

    // Prepare the statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        if (!empty($bindValues)) {
            // Create array with $paramTypes as first element, followed by references to each value
            $bindParams = [$stmt, $paramTypes];

            foreach ($bindValues as $key => $value) {
                // We need to bind by reference, so create references to each array element
                $bindParams[] = &$bindValues[$key];
            }

            // Call bind_param with the unpacked array of references
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the query
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    } else {
        showMySQLiAlert($connections);
        return false;
    }
}

/**
 * Advanced function to delete data from a table with support for multiple filters
 * 
 * @param string $tableName The name of the table
 * @param string|array|null $attributeWhere Column name(s) for filtering
 * @param mixed|array|null $attributeWhereValue Value(s) to filter by
 * @return bool True on success, false on failure
 */
function deleteData($tableName, $attributeWhere = null, $attributeWhereValue = null)
{
    global $connections;  // Use the global connection variable

    // Initialize the query
    $query = "DELETE FROM `$tableName`";

    // Initialize parameter types and values arrays
    $paramTypes = "";
    $bindValues = [];

    // Handle the WHERE clause
    if ($attributeWhere !== null && $attributeWhereValue !== null) {
        // Convert single values to arrays for consistent handling
        if (!is_array($attributeWhere)) {
            $attributeWhere = [$attributeWhere];
        }

        if (!is_array($attributeWhereValue)) {
            $attributeWhereValue = [$attributeWhereValue];
        }

        // Verify where arrays have the same size
        if (count($attributeWhere) !== count($attributeWhereValue)) {
            error_log("deleteData error: attributeWhere and attributeWhereValue arrays must have the same size");
            return false;
        }

        // Build the WHERE clause
        $whereClauses = [];
        for ($i = 0; $i < count($attributeWhere); $i++) {
            $whereClauses[] = "`" . $attributeWhere[$i] . "` = ?";

            // Add to parameter types and values
            $paramTypes .= is_int($attributeWhereValue[$i]) ? 'i' : 's';
            $bindValues[] = $attributeWhereValue[$i];
        }

        // Add WHERE clause to query
        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(" AND ", $whereClauses);
        }
    }

    // Prepare the statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        if (!empty($bindValues)) {
            // Create array with $paramTypes as first element, followed by references to each value
            $bindParams = [$stmt, $paramTypes];

            foreach ($bindValues as $key => $value) {
                // We need to bind by reference, so create references to each array element
                $bindParams[] = &$bindValues[$key];
            }

            // Call bind_param with the unpacked array of references
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the query
        $result = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $result;
    } else {
        showMySQLiAlert($connections);
        return false;
    }
}

function normalizeData(array &$data)
{
    foreach ($data as $key => $value) {
        // Check if the value is empty or 0
        if ($value === '' || $value === 0) {
            $data[$key] = null;
        }
    }
}

// Sanitize input
function sanitizeInput($input)
{
    global $connections;  // Use the global connection variable

    return mysqli_real_escape_string($connections, trim($input));
}

function showAlert($alert)
{
    $alert = htmlspecialchars($alert, ENT_QUOTES, 'UTF-8');

    echo "<script language='javascript'>
            window.onload = function() {
                alert(\"$alert\");
            }
          </script>";
}

function showMySQLiAlert($connections)
{
    showAlert("Error: " . mysqli_error($connections));
}

function goToPage($page)
{
    header("Location: " . $page);
    // echo "<script>window.location.href='$page';</script>";
}

function preformat($item)
{
    echo '<pre>';
    print_r($item);
    echo '</pre>';
}

function unsetPost($fields)
{
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            unset($_POST[$field]);
        }
    }
}
