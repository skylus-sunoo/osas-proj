<?php

// Database constants
define('TB_ADMISSION_USER', 'tb_admission_user');
define('TB_ADMISSION_INFO', 'tb_admission_info');
define('TB_ADMISSION_PERSONAL', 'tb_admission_personal');
define('TB_ADMISSION_FAMILY', 'tb_admission_family');
define('TB_ADMISSION_EDUCATION', 'tb_admission_education');
define('TB_ADMISSION_MEDICAL', 'tb_admission_medical');
define('TB_ADMISSION_CONTROL', 'tb_admission_control');

define('TB_ADMIN_USER', 'tb_admin_user');

define('TB_ADMIN_EXAM', 'tb_admin_exam');
define('TB_ADMIN_INCIDENT', 'tb_incident');

define('TB_NEWS', 'tb_news');

define('TB_EVENT', 'tb_event');
define('TB_STUDENT', 'tb_student');

// Database connection
require_once 'classes/Database.php';
$connections = Database::getInstance();

// Check the connection
if (mysqli_connect_error()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function runQuery($sql, $params = [])
{
    global $connections;

    $stmt = $connections->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $connections->error);
        throw new Exception("Database error occurred.");
    }

    if (!empty($params)) {
        $types = '';
        foreach ($params as $param) {
            $types .= getParamType($param);
        }
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        throw new Exception("Database error occurred.");
    }

    // Check if it's a SELECT query
    if (preg_match('/^\s*SELECT/i', $sql)) {
        $result = $stmt->get_result();
        if ($result === false) {
            throw new Exception("Fetching result failed: " . $stmt->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC); // Return data rows
    }

    return $stmt; // For UPDATE, INSERT, DELETE, etc.
}


/**
 * Fetches data from a specified table with support for multiple filters and flexible column selection.
 * 
 * This function allows you to retrieve data from a database table with optional filtering conditions.
 * It supports fetching a single column value, multiple columns, or all columns, and returns the results
 * in a structured format based on the input parameters.
 * 
 * @param string $tableName The name of the table to query.
 * @param string|array $columns The column(s) to retrieve:
 *                              - Use "*" to fetch all columns.
 *                              - Provide a string for a single column (e.g., "column_name").
 *                              - Provide an array for multiple columns (e.g., ["column1", "column2"]).
 * @param array|null $conditions Optional filtering conditions in the format:
 *                               - Each condition is an array: ['column', 'operator', 'value' (optional)].
 *                               - Example: [['id', '=', 1], ['status', 'IS NOT NULL']].
 *                               - Supported operators include '=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', etc.
 * @return mixed Returns the query result based on the input:
 *               - If a single column is requested, returns the value of that column (or null if no result).
 *               - If multiple columns or "*" are requested, returns an array of associative arrays (rows).
 *               - Returns null if an error occurs during query execution.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Fetch a single column value
 * $name = fetchData('users', 'name', [['id', '=', 1]]);
 * 
 * // Fetch multiple columns
 * $user = fetchData('users', ['id', 'name'], [['status', '=', 'active']]);
 * 
 * // Fetch all rows with no conditions
 * $allUsers = fetchData('users', '*');
 * 
 * // Fetch rows with complex conditions
 * $filteredUsers = fetchData('users', '*', [['age', '>', 18], ['status', '=', 'active']]);
 */
function fetchData($tableName, $columns = "*", $conditions = null)
{
    global $connections;  // Use the global database connection variable

    // Format the columns for the SQL query
    if (is_array($columns)) {
        // If $columns is an array, wrap each column name with backticks and join them
        $columnsStr = "`" . implode("`, `", $columns) . "`";
    } else {
        // If $columns is a string (could be "*" or a single column name), use it directly
        $columnsStr = $columns === "*" ? "*" : "`$columns`";
    }

    // Initialize the SQL query with the selected columns from the table
    $query = "SELECT $columnsStr FROM `$tableName`";

    // Prepare variables for the WHERE clause (if any)
    $paramTypes = ""; // String to hold the parameter types for binding
    $bindValues = []; // Array to hold the values to bind to the query

    // If conditions are provided, build the WHERE clause and prepare bind values
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Prepare the SQL statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        // If there are any conditions (bind values), bind them to the query
        if (!empty($bindValues)) {
            // Initialize the array of parameters for binding: first element is the statement, followed by the param types
            $bindParams = [$stmt, $paramTypes];

            // Loop through each value and bind it by reference
            foreach ($bindValues as $key => $value) {
                $bindParams[] = &$bindValues[$key];
            }

            // Call mysqli_stmt_bind_param with the unpacked array of bind parameters
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Retrieve the result set
        $result = mysqli_stmt_get_result($stmt);

        // Check if we're retrieving a single column and a single row of data
        if ($columns !== "*" && !is_array($columns)) {
            // Fetch the first row and return the single column value
            if ($row = mysqli_fetch_assoc($result)) {
                $singleValue = $row[$columns];
                mysqli_stmt_close($stmt); // Close the prepared statement
                return $singleValue; // Return the single value
            } else {
                mysqli_stmt_close($stmt); // Close the prepared statement
                return null; // No data found, return null
            }
        } else {
            // If selecting all columns or multiple columns, always return an array of rows
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row; // Add each row as an associative array to the $rows array
            }
            mysqli_stmt_close($stmt); // Close the prepared statement
            return $rows; // Return the array of rows (could be empty if no results)
        }

        mysqli_stmt_close($stmt); // Close the prepared statement
        return $rows; // Return the rows if the query returned multiple columns
    } else {
        // If the query preparation fails, display an error message
        showMySQLiAlert($connections);
        return null; // Return null to indicate failure
    }
}

/**
 * Fetches a limited number of rows from a specified table with support for pagination.
 * 
 * This function is a wrapper around fetchData that allows you to limit the number of rows returned
 * and implement pagination using the LIMIT and OFFSET SQL clauses.
 *
 * @param string $tableName The name of the table to query.
 * @param string|array $columns The column(s) to retrieve:
 *                              - Use "*" to fetch all columns.
 *                              - Provide a string for a single column (e.g., "column_name").
 *                              - Provide an array for multiple columns (e.g., ["column1", "column2"]).
 * @param array|null $conditions Optional filtering conditions in the format:
 *                               - Each condition is an array: ['column', 'operator', 'value' (optional)].
 * @param int $limit The number of rows to fetch (default is 10).
 * @param int $offset The starting point for the query (used for pagination, default is 0).
 * @return mixed Returns the query result based on the input:
 *               - If a single column is requested, returns the value of that column (or null if no result).
 *               - If multiple columns or "*" are requested, returns an array of associative arrays (rows).
 *               - Returns null if an error occurs during query execution.
 */
function fetchDataLimited($tableName, $columns = "*", $conditions = null, $limit = 10, $offset = 0)
{
    global $connections;  // Use the global database connection variable

    // Format the columns for the SQL query
    if (is_array($columns)) {
        // If $columns is an array, wrap each column name with backticks and join them
        $columnsStr = "`" . implode("`, `", $columns) . "`";
    } else {
        // If $columns is a string (could be "*" or a single column name), use it directly
        $columnsStr = $columns === "*" ? "*" : "`$columns`";
    }

    // Initialize the SQL query with the selected columns from the table
    $query = "SELECT $columnsStr FROM `$tableName`";

    // Prepare variables for the WHERE clause (if any)
    $paramTypes = ""; // String to hold the parameter types for binding
    $bindValues = []; // Array to hold the values to bind to the query

    // If conditions are provided, build the WHERE clause and prepare bind values
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Add the LIMIT and OFFSET clauses to the query
    $query .= " LIMIT ?, ?";  // Add placeholders for limit and offset

    // Prepare the SQL statement
    if ($stmt = mysqli_prepare($connections, $query)) {
        // If there are any conditions (bind values), bind them to the query
        if (!empty($bindValues)) {
            // Initialize the array of parameters for binding: first element is the statement, followed by the param types
            $bindParams = [$stmt, $paramTypes];

            // Loop through each value and bind it by reference
            foreach ($bindValues as $key => $value) {
                $bindParams[] = &$bindValues[$key];
            }

            // Bind the limit and offset as integers
            $bindParams[] = &$limit;
            $bindParams[] = &$offset;

            // Call mysqli_stmt_bind_param with the unpacked array of bind parameters
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        } else {
            // If no bind values, directly bind limit and offset
            mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
        }

        // Execute the prepared statement
        mysqli_stmt_execute($stmt);

        // Retrieve the result set
        $result = mysqli_stmt_get_result($stmt);

        // Check if we're retrieving a single column and a single row of data
        if ($columns !== "*" && !is_array($columns)) {
            // Fetch the first row and return the single column value
            if ($row = mysqli_fetch_assoc($result)) {
                $singleValue = $row[$columns];
                mysqli_stmt_close($stmt); // Close the prepared statement
                return $singleValue; // Return the single value
            } else {
                mysqli_stmt_close($stmt); // Close the prepared statement
                return null; // No data found, return null
            }
        } else {
            // If selecting all columns or multiple columns, always return an array of rows
            $rows = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row; // Add each row as an associative array to the $rows array
            }
            mysqli_stmt_close($stmt); // Close the prepared statement
            return $rows; // Return the array of rows (could be empty if no results)
        }

        mysqli_stmt_close($stmt); // Close the prepared statement
        return $rows; // Return the rows if the query returned multiple columns
    } else {
        // If the query preparation fails, display an error message
        showMySQLiAlert($connections);
        return null; // Return null to indicate failure
    }
}

/**
 * Checks if data exists in a specified table with support for multiple filtering conditions.
 * 
 * This function performs a query to count the number of rows in a specified table that match the provided
 * conditions. It allows for complex filtering with operators such as '=', '!=', '<', '>', 'IS NULL', and others.
 * The function returns a boolean indicating whether at least one row meets the criteria.
 * 
 * @param string $tableName The name of the table to check for data.
 * @param array|null $conditions Optional filtering conditions in the format:
 *                               - Each condition is an array: ['column', 'operator', 'value' (optional)].
 *                               - Example: [['id', '=', 1], ['status', 'IS NOT NULL']].
 *                               - Supported operators include '=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', etc.
 *                               - If no conditions are provided, the query will check the entire table.
 * @return bool Returns `true` if at least one row matches the conditions, `false` otherwise.
 *              Returns `false` if an error occurs during query execution.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Check if a specific admission exists
 * $exists = checkForData('admissions', [['admission_id', '=', 1], ['admission_Branch', 'IS NOT NULL']]);
 * 
 * // Check if there are active users
 * $hasActiveUsers = checkForData('users', [['status', '=', 'active']]);
 * 
 * // Check if any users exist (no conditions)
 * $hasUsers = checkForData('users');
 */
function checkForData($tableName, $conditions = null)
{
    // Initialize the base query to count rows in the table
    $query = "SELECT COUNT(*) FROM `$tableName`";
    $paramTypes = ""; // String to hold the parameter types for binding
    $bindValues = []; // Array to hold the values to bind to the query

    // If conditions are provided, build the WHERE clause and prepare bind values
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Execute the prepared query and return the result (true if at least one row matches)
    return executePreparedQuery($query, $paramTypes, $bindValues);
}

/**
 * Updates data in a specified table with support for multiple columns and filtering conditions.
 * 
 * This function allows updating one or more columns in a database table, where each column can be assigned a
 * corresponding value. It supports filtering with multiple conditions, allowing for fine-grained control over
 * which rows to update. The update values and conditions are flexible, and the query is executed safely using prepared statements.
 * 
 * @param string $tableName The name of the table to update.
 * @param string|array $attributeToUpdate The column name(s) to update:
 *                                       - Use a string for a single column (e.g., "column_name").
 *                                       - Use an array for multiple columns (e.g., ["column1", "column2"]).
 * @param mixed|array $attributeToUpdateValue The value(s) to set for the columns:
 *                                            - Use a single value for one column.
 *                                            - Use an array for multiple column values.
 *                                            - The values must correspond to the columns in the same order.
 * @param array|null $conditions Optional filtering conditions to apply to the rows to update:
 *                               - Each condition is an array: ['column', 'operator', 'value' (optional)].
 *                               - Example: [['id', '=', 1], ['status', 'IS NOT NULL']].
 *                               - Supported operators include '=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', etc.
 * @return bool Returns `true` if the update was successful, `false` otherwise.
 *              Returns `false` if an error occurs during query execution or if the input arrays have mismatched sizes.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Update a single column value for a specific admission
 * $success = updateData('admissions', 'admission_status', 'approved', [['admission_id', '=', 1]]);
 * 
 * // Update multiple columns for specific users
 * $success = updateData('users', ['status', 'age'], ['inactive', 30], [['status', '=', 'active']]);
 * 
 * // Update a column for all records where a condition is met
 * $success = updateData('users', 'last_login', '2025-01-01', [['status', '=', 'active']]);
 */
function updateData($tableName, $attributeToUpdate, $attributeToUpdateValue, $conditions = null)
{
    // Ensure attributeToUpdate is an array, even for a single column
    if (!is_array($attributeToUpdate)) {
        $attributeToUpdate = [$attributeToUpdate];
    }

    // Ensure attributeToUpdateValue is an array, even for a single value
    if (!is_array($attributeToUpdateValue)) {
        $attributeToUpdateValue = [$attributeToUpdateValue];
    }

    // Check if the update columns and values arrays have the same size
    if (count($attributeToUpdate) !== count($attributeToUpdateValue)) {
        error_log("updateData error: attributeToUpdate and attributeToUpdateValue arrays must have the same size");
        return false;
    }

    // Build the SET clause of the query
    $setClauses = [];
    for ($i = 0; $i < count($attributeToUpdate); $i++) {
        $setClauses[] = "`" . $attributeToUpdate[$i] . "` = ?"; // Prepare each column for update
    }

    // Initialize the SQL UPDATE query
    $query = "UPDATE `$tableName` SET " . implode(", ", $setClauses);

    // Initialize arrays for parameter types and values
    $paramTypes = "";
    $bindValues = [];

    // Add each update value to the parameter arrays, with corresponding types
    foreach ($attributeToUpdateValue as $value) {
        $paramTypes .= getParamType($value); // Determine the parameter type
        $bindValues[] = $value; // Store the value to bind later
    }

    // If filtering conditions are provided, append them to the WHERE clause
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Execute the prepared query with the bound parameters and return the result
    return executePreparedQuery($query, $paramTypes, $bindValues);
}

/**
 * Inserts data into a specified table with support for multiple columns and optional default values.
 * 
 * This function performs an `INSERT` operation into a specified table. It can insert data with specific column names
 * and values, or it can insert a row with only default values if no columns or values are provided. It supports 
 * inserting data into one or more columns and ensures the query is executed safely using prepared statements.
 * 
 * @param string $tableName The name of the table to insert data into.
 * @param string|array|null $attributeToInsert Optional column name(s) for the insertion:
 *                                             - Use a string for a single column (e.g., "column_name").
 *                                             - Use an array for multiple columns (e.g., ["column1", "column2"]).
 *                                             - If omitted or set to `null`, the query will insert a row with default values.
 * @param mixed|array|null $attributeToInsertValue Optional value(s) for the insertion:
 *                                                  - Use a single value for one column.
 *                                                  - Use an array for multiple column values.
 *                                                  - If omitted or set to `null`, the query will insert a row with default values.
 * @return bool Returns `true` on success, `false` on failure.
 *              Returns `false` if an error occurs during query execution or if the input arrays have mismatched sizes.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Insert a row with specific values
 * $success = insertData('users', ['name', 'age'], ['John Doe', 30]);
 * 
 * // Insert a row with default values
 * $success = insertData('users');
 */
function insertData($tableName, $attributeToInsert = null, $attributeToInsertValue = null)
{
    global $connections;  // Use the global connection variable

    // Check if we're inserting a row with only default values
    if ($attributeToInsert === null && $attributeToInsertValue === null) {
        // Simple INSERT query with default values only (no columns or values specified)
        $query = "INSERT INTO `$tableName` () VALUES ()";

        if ($stmt = mysqli_prepare($connections, $query)) {
            // Execute the query and return the result (true for success, false for failure)
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt); // Close the prepared statement
            return $result; // Return the success status of the execution
        } else {
            showMySQLiAlert($connections); // Handle any errors during query preparation
            return false; // Return false if there was an error
        }
    }

    // Continue with standard insertion logic when columns and values are provided

    // Convert single values to arrays for consistent handling (in case a single column or value is provided)
    if (!is_array($attributeToInsert)) {
        $attributeToInsert = [$attributeToInsert];
    }

    if (!is_array($attributeToInsertValue)) {
        $attributeToInsertValue = [$attributeToInsertValue];
    }

    // Ensure the number of columns and values are the same
    if (count($attributeToInsert) !== count($attributeToInsertValue)) {
        echo ("insertData error: attributeToInsert and attributeToInsertValue arrays must have the same size");
        return false; // Return false if the arrays have mismatched sizes
    }

    // Build the column names part of the query
    $columns = [];
    foreach ($attributeToInsert as $column) {
        $columns[] = "`" . $column . "`"; // Enclose each column name with backticks for safety
    }

    // Build the placeholders for values in the query
    $placeholders = array_fill(0, count($attributeToInsert), "?");

    // Initialize the INSERT query with columns and placeholders
    $query = "INSERT INTO `$tableName` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

    // Initialize parameter types and values arrays for prepared statement
    $paramTypes = "";
    $bindValues = [];

    // Add the values to the parameter arrays, determining the correct parameter type for each value
    foreach ($attributeToInsertValue as $value) {
        $paramTypes .= getParamType($value); // Determine the parameter type based on the value
        $bindValues[] = $value; // Store the value to be bound to the query
    }

    // Execute the prepared query with the bound parameters
    return executePreparedQuery($query, $paramTypes, $bindValues);
}

/**
 * Deletes data from a specified table with support for multiple filtering conditions.
 * 
 * This function performs a `DELETE` operation on a specified table. It allows for filtering the rows to delete 
 * using conditions such as column values and operators. The function uses prepared statements to ensure safe query execution.
 * 
 * @param string $tableName The name of the table to delete data from.
 * @param array|null $conditions Optional array of conditions to filter the rows to delete:
 *                               - Each condition is an array with the format: ['column', 'operator', 'value' (optional)].
 *                               - Example: [['admission_id', '=', 1], ['admission_Branch', 'IS NOT NULL']].
 *                               - Supported operators include '=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', etc.
 * @return bool Returns `true` on success, `false` on failure.
 *              Returns `false` if there is an error during query execution or if the query is malformed.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Delete rows where admission_id equals 1
 * $success = deleteData('admissions', [['admission_id', '=', 1]]);
 * 
 * // Delete rows where admission_Branch is not null
 * $success = deleteData('admissions', [['admission_Branch', 'IS NOT NULL']]);
 * 
 * // Delete rows where status is 'inactive' and last_login is older than a specific date
 * $success = deleteData('users', [['status', '=', 'inactive'], ['last_login', '<', '2020-01-01']]);
 */
function deleteData($tableName, $conditions = null)
{
    // Initialize the base DELETE query
    $query = "DELETE FROM `$tableName`";

    // Initialize arrays for parameter types and bound values (for prepared statements)
    $paramTypes = "";
    $bindValues = [];

    // Check if filtering conditions are provided and build the WHERE clause
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Execute the prepared query with the appropriate parameters
    return executePreparedQuery($query, $paramTypes, $bindValues);
}

/**
 * Fetches the count of rows from a specified table with optional filtering conditions.
 * 
 * This function counts the number of rows in a specified table that match the provided conditions.
 * It allows for complex filtering with operators such as '=', '!=', '<', '>', 'IS NULL', and others.
 * 
 * @param string $tableName The name of the table to query.
 * @param array|null $conditions Optional filtering conditions in the format:
 *                               - Each condition is an array: ['column', 'operator', 'value' (optional)].
 *                               - Example: [['id', '=', 1], ['status', 'IS NOT NULL']].
 *                               - Supported operators include '=', '!=', '<', '>', '<=', '>=', 'LIKE', 'IS NULL', etc.
 * @return int|false Returns the count of matching rows, or `false` if an error occurs during query execution.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Count rows where status is 'active'
 * $count = countData('users', [['status', '=', 'active']]);
 * 
 * // Count all rows in the table (no conditions)
 * $count = countData('users');
 */
function countData($tableName, $conditions = null)
{
    global $connections;  // Use the global connection variable

    // Initialize the base query to count rows in the table
    $query = "SELECT COUNT(*) AS row_count FROM `$tableName`";

    // Initialize parameter types and values arrays for prepared statement
    $paramTypes = "";
    $bindValues = [];

    // If conditions are provided, build the WHERE clause and prepare bind values
    buildWhereClause($conditions, $paramTypes, $bindValues, $query);

    // Prepare the query
    if ($stmt = mysqli_prepare($connections, $query)) {
        // Bind the parameters if there are any
        if (!empty($bindValues)) {
            $bindParams = [$stmt, $paramTypes];

            // Loop through each value and bind it by reference
            foreach ($bindValues as $key => $value) {
                $bindParams[] = &$bindValues[$key];
            }

            // Call mysqli_stmt_bind_param with the unpacked array of bind parameters
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Get the result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the row count
        if ($row = mysqli_fetch_assoc($result)) {
            $rowCount = (int)$row['row_count'];
            mysqli_stmt_close($stmt); // Close the prepared statement
            return $rowCount; // Return the count of rows
        } else {
            mysqli_stmt_close($stmt); // Close the prepared statement
            return false; // If no result, return false
        }
    } else {
        // If the query preparation fails, show error
        showMySQLiAlert($connections);
        return false; // Return false to indicate failure
    }
}

/**
 * Determines the parameter type for a given value.
 *
 * This function is typically used to identify the type of a parameter
 * for database queries or similar operations where type specification
 * is required.
 *
 * @param mixed $value The value to evaluate.
 * @return string Returns 'i', 'd', or 's'.
 */
function getParamType($param) {
    if (is_int($param)) {
        return 'i';
    } elseif (is_double($param)) {
        return 'd';
    } else {
        return 's';
    }
}

/**
 * Builds a WHERE clause for an SQL query based on the provided conditions.
 *
 * @param array $conditions An array of conditions where each condition is an array
 *                          containing the column name, operator, and optional value.
 *                          Example: [['column1', '=', 'value1'], ['column2', 'IS NULL']]
 * @param string &$paramTypes A reference to a string that will be appended with parameter
 *                            types for prepared statements (e.g., 's', 'i', 'd', 'b').
 * @param array &$bindValues A reference to an array that will be populated with values
 *                           to bind to the prepared statement.
 * @param string &$query A reference to the SQL query string that will be appended with
 *                       the generated WHERE clause.
 *
 * @return void This function does not return a value. It modifies the $paramTypes,
 *              $bindValues, and $query parameters by reference.
 *
 * @throws InvalidArgumentException If the conditions array contains invalid data.
 *
 * @example
 * $conditions = [
 *     ['name', '=', 'John'],
 *     ['age', '>', 25],
 *     ['status', 'IS NOT NULL']
 * ];
 * $paramTypes = '';
 * $bindValues = [];
 * $query = "SELECT * FROM users";
 * buildWhereClause($conditions, $paramTypes, $bindValues, $query);
 * // Result:
 * // $query = "SELECT * FROM users WHERE `name` = ? AND `age` > ? AND `status` IS NOT NULL";
 * // $paramTypes = "si";
 * // $bindValues = ['John', 25];
 */
function buildWhereClause($conditions, &$paramTypes, &$bindValues, &$query)
{
    if (empty($conditions)) {
        return;
    }

    $clauses = [];

    foreach ($conditions as $condition) {
        $column = $condition[0];
        $operator = strtoupper($condition[1]);
        $value = $condition[2] ?? null;

        // Check if we need to apply 'LIKE' for partial matching
        if ($operator === 'LIKE' && $value !== null) {
            // Add the percent signs for a partial match
            $value = "%" . $value . "%";
            $operator = 'LIKE';  // Ensure we use LIKE
        }

        if (in_array($operator, ['IS NULL', 'IS NOT NULL'])) {
            // For IS NULL or IS NOT NULL, no need for parameter binding
            $clauses[] = "`$column` $operator";
        } else {
            // For other operators, bind the value
            $clauses[] = "`$column` $operator ?";
            $paramTypes .= getParamType($value);
            $bindValues[] = $value;
        }
    }

    if (!empty($clauses)) {
        $query .= " WHERE " . implode(" AND ", $clauses);
    }
}

/**
 * Prepares, binds parameters, executes a MySQLi prepared statement, and returns the success status.
 * 
 * This function simplifies the process of executing a prepared statement with bound parameters. It handles the preparation 
 * of the query, binding the provided values, and executing the query. It also handles the special case of `SELECT` queries 
 * by returning the result of a `COUNT(*)` query or simply indicating success for other types of queries like `INSERT`, `UPDATE`, and `DELETE`.
 * 
 * @param mysqli $connection The MySQLi connection object to use for executing the query.
 * @param string $query The SQL query string with placeholders (e.g., "SELECT * FROM table WHERE column = ?").
 * @param string|null $paramTypes The parameter types for the bound values (optional, e.g., 'ssi' for string, string, integer).
 *                                Each character represents the type of each bound parameter: 's' for string, 'i' for integer, 'd' for double, 'b' for blob.
 * @param array|null $bindValues The values to bind to the prepared statement (optional).
 *                                This is an array where each element corresponds to a parameter in the query.
 * @return bool|int Returns `true` on success for `INSERT`, `UPDATE`, `DELETE`, or other non-SELECT queries.
 *                  For `SELECT` queries, it returns the result (e.g., `COUNT(*)`), or `false` if an error occurs.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @throws Exception If the query preparation or execution fails, an error alert is displayed.
 * 
 * @example
 * // Example for executing a SELECT query
 * $result = executePreparedQuery('SELECT COUNT(*) FROM users WHERE status = ?', 's', ['active']);
 * 
 * // Example for executing an UPDATE query
 * $success = executePreparedQuery('UPDATE users SET name = ? WHERE id = ?', 'si', ['John Doe', 1]);
 * 
 * // Example for executing an INSERT query
 * $success = executePreparedQuery('INSERT INTO users (name, age) VALUES (?, ?)', 'si', ['John Doe', 30]);
 */
function executePreparedQuery($query, $paramTypes = null, $bindValues = null)
{
    global $connections;  // Use the global connection variable

    // Prepare the statement
    if ($stmt = mysqli_prepare($connections, $query)) {

        // If there are bound values, bind them to the prepared statement
        if (!empty($bindValues) && $paramTypes) {
            $bindParams = [$stmt, $paramTypes];  // Start the bind parameter array with the statement and param types
            foreach ($bindValues as &$val) {
                $bindParams[] = &$val;  // Append references to the values (needed for binding by reference)
            }
            // Bind the parameters dynamically
            call_user_func_array('mysqli_stmt_bind_param', $bindParams);
        }

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Check if it's a SELECT query that returns a result (like COUNT(*))
            if (stripos($query, 'SELECT') === 0) {
                // For SELECT queries, bind the result and fetch the result (COUNT(*))
                mysqli_stmt_bind_result($stmt, $count);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt); // Close the prepared statement

                return $count; // Return the result (COUNT(*) from a SELECT query)
            } else {
                // For non-SELECT queries like INSERT, UPDATE, DELETE, just close the statement
                mysqli_stmt_close($stmt);
                return true; // Return true to indicate success
            }
        } else {
            mysqli_stmt_close($stmt);
            return false; // Return false if there was an issue executing the statement
        }
    } else {
        // Show MySQLi error if preparation failed
        showMySQLiAlert($connections);
        return false; // Return false if preparation failed
    }
}

/**
 * Normalizes the data by replacing empty strings and zeros with `null`.
 * 
 * This function takes an array and checks each value. If the value is an empty string (`''`) or `0`, 
 * it replaces it with `null`. This is useful for cleaning up data before inserting it into the database,
 * ensuring that `null` values are used where appropriate instead of empty strings or zeros.
 * 
 * @param array &$data The data array to normalize. The array is passed by reference, so the original array is modified.
 * @return void This function modifies the `$data` array in-place and does not return any value.
 * 
 * @example
 * // Example usage: Normalizing data before insertion into the database
 * $data = ['name' => 'John', 'age' => 0, 'email' => ''];
 * normalizeData($data);
 * // $data will be ['name' => 'John', 'age' => null, 'email' => null]
 */
function normalizeData(array &$data)
{
    foreach ($data as $key => $value) {
        // Check if the value is empty or 0 and normalize to null
        if ($value === '' || $value === 0) {
            $data[$key] = null;
        }
    }
}

/**
 * Sanitizes user input by escaping special characters to prevent SQL injection.
 * 
 * This function uses `mysqli_real_escape_string` to escape special characters in a string,
 * ensuring that the input is safe to use in a SQL query. The input is trimmed of whitespace before escaping.
 * This is typically used to sanitize user inputs before using them in SQL queries.
 * 
 * @param string $input The user input to sanitize.
 * @return string The sanitized input string, safe for use in SQL queries.
 * 
 * @global mysqli $connections The global MySQLi connection object used for database interaction.
 * 
 * @example
 * // Example usage: Sanitizing user input before inserting into the database
 * $userInput = "O'Reilly";
 * $safeInput = sanitizeInput($userInput);
 * // $safeInput will be 'O\'Reilly' (escaped for SQL)
 */
function sanitizeInput($input)
{
    global $connections;  // Use the global connection variable

    // Sanitize input by trimming and escaping special characters
    return mysqli_real_escape_string($connections, trim($input));
}

/**
 * Displays an alert message in JavaScript after escaping special characters for safety.
 * 
 * This function generates a JavaScript `alert()` pop-up that displays the provided message.
 * It uses `htmlspecialchars` to escape special characters in the message to prevent XSS (Cross-Site Scripting) attacks.
 * 
 * @param string $alert The message to display in the alert pop-up.
 * @return void This function outputs the JavaScript code directly, with no return value.
 * 
 * @example
 * // Example usage: Showing an alert with a custom message
 * showAlert("This is a test alert!");
 */
function showAlert($alert)
{
    // Escape special characters to prevent XSS attacks
    $alert = htmlspecialchars($alert, ENT_QUOTES, 'UTF-8');

    // Output JavaScript to show an alert with the escaped message
    echo "<script language='javascript'>
            window.onload = function() {
                alert(\"$alert\");
            }
          </script>";
}

// Helper function to generate an <option> tag with the 'selected' attribute if needed
/**
 * Generates an <option> tag with the 'selected' attribute if the current value matches the option value.
 *
 * @param string $category The current selected category.
 * @param string $optionValue The value for this <option> tag.
 * @param string $optionLabel The label to display for this <option> tag. Defaults to $optionValue if not provided.
 * @return string The complete HTML for the <option> tag, including the 'selected' attribute if needed.
 */
function getSelectedOption($category, $optionValue, $optionLabel = null) {
    // If $optionLabel is not provided, use $optionValue as the label
    $optionLabel = $optionLabel ?: $optionValue;

    $selected = $category === $optionValue ? ' selected' : '';
    return '<option value="' . htmlspecialchars($optionValue) . '"' . $selected . '>' . htmlspecialchars($optionLabel) . '</option>';
}

/**
 * Displays a MySQLi error alert message in JavaScript.
 * 
 * This function retrieves the last MySQL error from the given database connection
 * and displays it in an alert using the `showAlert` function.
 * It is typically used for debugging purposes to notify the user about MySQL-related issues.
 * 
 * @param mysqli $connections The MySQLi connection object used to fetch the error message.
 * @return void This function triggers an alert with the MySQL error message.
 * 
 * @example
 * // Example usage: Showing a MySQLi error alert
 * showMySQLiAlert($connections);
 */
function showMySQLiAlert($connections)
{
    // Call showAlert function to display the MySQL error message
    showAlert("Error: " . mysqli_error($connections));
}

/**
 * Redirects the user to a different page using the `Location` HTTP header.
 * 
 * This function sends a `Location` header to the browser, which causes the browser to navigate to the specified page.
 * It is typically used for redirects after form submissions or other actions.
 * 
 * @param string $page The URL of the page to redirect to.
 * @return void This function performs a redirect and does not return any value.
 * 
 * @example
 * // Example usage: Redirecting to a new page after form submission
 * goToPage('success.php');
 */
function goToPage($page)
{
    // Redirect the user to the specified page
    header("Location: " . $page);
}

/**
 * Outputs a variable or array in a human-readable format within <pre> tags.
 * 
 * This function uses `print_r` wrapped in `<pre>` tags to format and display the contents
 * of a variable or array in a readable format. It is useful for debugging and inspecting data structures.
 * 
 * @param mixed $item The variable or array to print.
 * @return void This function outputs the formatted data directly and does not return a value.
 * 
 * @example
 * // Example usage: Displaying an array in a readable format
 * preformat($myArray);
 */
function preformat($item)
{
    // Display the formatted content of the item in a readable format
    echo '<pre>';
    print_r($item);
    echo '</pre>';
}

/**
 * Truncates a string to a specific number of characters and appends an ellipsis if truncated.
 *
 * This function safely truncates multibyte strings (like UTF-8) and appends "..." only
 * if the original string exceeds the specified character count.
 *
 * @param string $originalString The original string to be truncated.
 * @param int $charCount The maximum number of characters before truncation occurs.
 * @return string The truncated string with an ellipsis if needed.
 *
 * @example
 * echo truncate("This is a very long sentence that should be shortened.", 20);
 * // Output: "This is a very long..."
 */
function truncate($originalString, $charCount)
{
    if (mb_strlen($originalString) <= $charCount) {
        return $originalString;
    }

    $truncated = mb_substr($originalString, 0, $charCount);
    
    // Avoid cutting in the middle of a word
    $lastSpace = mb_strrpos($truncated, ' ');
    if ($lastSpace !== false) {
        $truncated = mb_substr($truncated, 0, $lastSpace);
    }

    return $truncated . '...';
}

/**
 * Unsets (removes) specific fields from the $_POST superglobal array.
 * 
 * This function allows you to unset multiple fields from the `$_POST` array at once. 
 * It is useful for clearing sensitive or unnecessary data after processing form submissions.
 * 
 * @param array $fields An array of field names to unset from `$_POST`.
 * @return void This function modifies the `$_POST` array by unsetting the specified fields.
 * 
 * @example
 * // Example usage: Unsetting 'password' and 'confirm_password' fields after processing
 * unsetPost(['password', 'confirm_password']);
 */
function unsetPost($fields)
{
    foreach ($fields as $field) {
        // Check if the field exists in $_POST and unset it if it does
        if (isset($_POST[$field])) {
            unset($_POST[$field]);
        }
    }
}

/**
 * Retrieves the provided value if it is set and not null; otherwise, returns a default value.
 *
 * @param mixed $value The value to check.
 * @param mixed $or The default value to return if $value is not set or is null. Default is 'N/A'.
 * @return mixed Returns $value if it is set and not null; otherwise, returns $or.
 */
function getAssocValueOrNA($value, $or = 'N/A')
{
    return isset($value) && $value !== null ? $value : $or;
}

/**
 * Retrieves the value associated with a given key from an array. 
 * If the key does not exist or the value is null, a default value is returned.
 *
 * @param array $data The array to retrieve the value from.
 * @param string|int $key The key to look for in the array.
 * @param mixed $default The default value to return if the key does not exist in the array. Default is 'N/A'.
 * @return mixed Returns the value associated with the key if it exists; otherwise, returns $default.
 */
function getValueOrNA($data, $key, $default = 'N/A')
{
    return isset($data[$key]) ? $data[$key] : $default;
}
