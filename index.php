<?php

declare(strict_types=1);
?>

<link rel="apple-touch-icon" sizes="180x180" href="../../../assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../../assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../../assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="../../../assets/img/favicon/site.webmanifest">

<?php if (strpos($_SERVER['REQUEST_URI'], '/admin') !== false): ?>
<?php else: ?>
<?php endif; ?>
<link rel="preload" href="/assets/css/styles.css" as="style" />
<link rel="stylesheet" href="/assets/css/styles.css">

<link rel="preload" href="/assets/fonts/fonts.css" as="style" />
<link rel="stylesheet" href="/assets/fonts/fonts.css">

<?php
session_start();

require_once '_config.php';
require_once 'classes/Router.php';
require_once 'controllers/AdmissionController.php';
require_once 'controllers/AdminController.php';
require_once 'controllers/NewsController.php';

$router = new Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->add("/admin/logout", function () {
    $controller = new AdminController();
    $controller->logoutUser();
});

$router->add("/admin/login", function () {
    $controller = new AdminController();
    $controller->handleLoginRedirect();
});

$router->add("/admin/home", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/dashboard/home.php';
});

$router->add("/admin/news", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/dashboard/news.php';
});

$router->add("/admin/news_review", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $_SESSION['news_ID'] = $_POST['news_ID'];

    goToPage("/admin/news?single=true");
});

$router->add("/admin/news_delete", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->deleteNews();
});

$router->add("/admin/news_save", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->saveNews();
});

$router->add("/admin/news_clear", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    unset($_SESSION['news_ID']);
    
    goToPage("/admin/news?single=true");
});

$router->add("/admissions/overview", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/admissions/overview.php';
});

$router->add("/admissions/overview_review", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $_SESSION['admission_ID'] = $_POST['admission_ID'];

    goToPage("/admissions/overview?single=true");
});

$router->add("/admissions/requirements", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->handleRequirements();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/admissions/requirements.php';
});

$router->add("/admissions/examinations", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    // $controller->handleExaminations();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/admissions/examinations.php';
});

$router->add("/admissions/exam_results", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->handleExamResults();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/admissions/examinations.php';
});

$router->add("/admissions/exam_reports", function () {
    goToPage("../form_exam_results.php");
});

$router->add("/admissions/exam_create", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->createExam();
});

$router->add("/admissions/exam_release", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->releaseExam();
});

$router->add("/admissions/exam_delete", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->deleteExam();
});

$router->add("/incidents/overview", function () {
    $controller = new AdminController();
    $controller->handleAdminRedirect();

    $controller->handleIncidentActions();

    include_once 'views/admin/include/sidebar.php';
    include_once 'views/admin/include/header.php';
    include_once 'views/admin/incidents/overview.php';
});

$router->add("/dashboard/home", function () {
    if (isset($_SESSION['logout'])) {
        session_unset();
        session_destroy();
        showAlert("You have successfully logged out.");
    }

    $controller = new NewsController();
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/home.php';
    include_once 'views/public/include/news_list.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/dashboard/news", function () {
    $controller = new NewsController();
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/news.php';
    include_once 'views/public/include/news_list.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/dashboard/news_updates", function () {
    $controller = new NewsController();
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/news_updates.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/dashboard/downloads", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/downloads.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/admission/logout", function () {
    $controller = new AdmissionController();
    $controller->logoutUser();
});

$router->add("/admission/application", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/admission/admission.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/admission/enrollment", function () {
    $controller = new AdmissionController();
    $controller->handleEnrollmentRedirect();
    include_once 'views/public/include/footer.php';
});

$router->add("/admission/download", function () {
    goToPage("../form_application.php");
});

$router->add("/admission/save_admission_information", function () {
    $controller = new AdmissionController();
    $controller->saveAdmissionInformation();
});

$router->add("/admission/save_personal_information", function () {
    $controller = new AdmissionController();
    $controller->savePersonalInformation();
});

$router->add("/admission/save_family_information", function () {
    $controller = new AdmissionController();
    $controller->saveFamilyInformation();
});

$router->add("/admission/save_education_information", function () {
    $controller = new AdmissionController();
    $controller->saveEducationInformation();
});

$router->add("/admission/save_medical_information", function () {
    $controller = new AdmissionController();
    $controller->saveMedicalInformation();
});

$router->add("/admission/updateAppointment", function () {
    $controller = new AdmissionController();
    $controller->setAppointment();
});

$router->add("/admission/course", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/admission/course.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/dashboard/students", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/students.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/about/statements", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/statements.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/about/history", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/history.php';
    include_once 'views/public/include/footer.php';
});

$router->add("/about/officials", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/officials.php';
    include_once 'views/public/include/footer.php';
});

$router->dispatch($path);

function isLoggedIn()
{
    return isset($_SESSION['admission_ID']);
}

function optionIsSession($session, $value)
{
    $selected = (isset($_SESSION[$session]) && $_SESSION[$session] == $value) ? 'selected' : '';
    return 'value="' . $value . '" ' . $selected;
}

function generateCheckField($fieldTag, $label, $value = null)
{
    // Default value for the input if the session value is set
    $sessionValue = isset($_SESSION[$value]) ? 'Yes' : '';
    if (isset($sessionValue) && !empty($sessionValue)) {
        $checked = 'checked';
    } else {
        $checked = '';
    }

    // Generate the HTML for the field, including the class for 'entry_new' if necessary
    $fieldHTML = '
        <div class="enrollment-checkbox enrollment-information-' . htmlspecialchars($fieldTag) . ' style="flex-grow: 1; max-width: 25%;">
            <input type="checkbox" name="enrollment-information-' . htmlspecialchars($fieldTag) . '" 
                   value="Yes"' . $checked . '>
            <h4>' . htmlspecialchars($label) . '</h4>
        </div>
    ';

    // Return the generated HTML
    return $fieldHTML;
}

function generateFormField($fieldTag, $label, $value = null, $type, $isRequired = true)
{
    // Default value for the input if the session value is set
    $sessionValue = isset($_SESSION[$value]) ? $_SESSION[$value] : '';

    // If the field is required, add the "required" attribute
    $required = $isRequired ? 'required' : '';
    $requiredLabel = $isRequired ? '* ' : '';

    // Generate the HTML for the field, including the class for 'entry_new' if necessary
    $fieldHTML = '
        <div class="enrollment-information-' . htmlspecialchars($fieldTag) . '">
            <h4>' . $requiredLabel . htmlspecialchars($label) . '</h4>
            <input type="' . $type . '" name="enrollment-information-' . htmlspecialchars($fieldTag) . '" 
                   value="' . htmlspecialchars((string)$sessionValue) . '" ' . $required . '>
        </div>
    ';

    // Return the generated HTML
    return $fieldHTML;
}

function generateFormFieldEntryNew($fieldTag, $label, $value = null, $type, $isRequired = true)
{
    // Default value for the input if the session value is set
    $sessionValue = isset($_SESSION[$value]) ? $_SESSION[$value] : '';

    // If the field is required, add the "required" attribute
    $required = $isRequired ? 'required' : '';

    // Generate the HTML for the field, including the class for 'entry_new' if necessary
    $fieldHTML = '
        <div class="entry-new enrollment-information-' . htmlspecialchars($fieldTag) . '">
            <h4>* ' . htmlspecialchars($label) . '</h4>
            <input type="' . $type . '" name="enrollment-information-' . htmlspecialchars($fieldTag) . '" 
                   value="' . htmlspecialchars((string)$sessionValue) . '" ' . $required . '>
        </div>
    ';

    // Return the generated HTML
    return $fieldHTML;
}

function generateSelectField($fieldTag, $label, $options, $sessionKey, $isRequired = true)
{
    // Ensure $fieldTag and $label are strings before passing them to htmlspecialchars()
    $fieldTag = (string) $fieldTag;
    $label = (string) $label;

    // Start generating the HTML for the select field
    $fieldHTML = '
        <div class="enrollment-information-' . htmlspecialchars($fieldTag);

    $required = $isRequired ? 'required' : '';
    $requiredLabel = $isRequired ? '* ' : '';

    $fieldHTML .= '">
        <h4>' . $requiredLabel . htmlspecialchars($label) . '</h4> 
        <select name="enrollment-information-' . htmlspecialchars($fieldTag) . '" ' . $required . '>
            <option value=""></option>'; // Default empty option


    // Check if the options array is associative or indexed
    if (array_keys($options) === range(0, count($options) - 1)) {
        // This is an indexed array (value == text)
        foreach ($options as $option) {
            // Ensure option is a string before passing it to htmlspecialchars()
            $option = (string) $option;
            // Use optionIsSession to determine if this option should be selected
            $selected = optionIsSession($sessionKey, $option);
            $fieldHTML .= '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
        }
    } else {
        // This is an associative array (value != text)
        foreach ($options as $value => $text) {
            // Ensure value and text are strings before passing them to htmlspecialchars()
            $value = (string) $value;
            $text = (string) $text;
            // Use optionIsSession to determine if this option should be selected
            $selected = optionIsSession($sessionKey, $value);
            $fieldHTML .= '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($text) . '</option>';
        }
    }

    // Close the select tag
    $fieldHTML .= '</select></div>';

    // Return the generated HTML
    return $fieldHTML;
}

function generateSelectFieldEntryNew($fieldTag, $label, $options, $sessionKey, $addEntryNewClass = false)
{
    // Ensure $fieldTag and $label are strings before passing them to htmlspecialchars()
    $fieldTag = (string) $fieldTag;
    $label = (string) $label;

    // Start generating the HTML for the select field
    $fieldHTML = '
        <div class="entry-new enrollment-information-' . htmlspecialchars($fieldTag);

    // Add the entry-new class if requested
    if ($addEntryNewClass) {
        $fieldHTML .= ' entry-new';
    }

    $fieldHTML .= '">
        <h4>* ' . htmlspecialchars($label) . '</h4>
        <select name="enrollment-information-' . htmlspecialchars($fieldTag) . '" required>
            <option value=""></option>'; // Default empty option

    // Check if the options array is associative or indexed
    if (array_keys($options) === range(0, count($options) - 1)) {
        // This is an indexed array (value == text)
        foreach ($options as $option) {
            // Ensure option is a string before passing it to htmlspecialchars()
            $option = (string) $option;
            // Use optionIsSession to determine if this option should be selected
            $selected = optionIsSession($sessionKey, $option);
            $fieldHTML .= '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
        }
    } else {
        // This is an associative array (value != text)
        foreach ($options as $value => $text) {
            // Ensure value and text are strings before passing them to htmlspecialchars()
            $value = (string) $value;
            $text = (string) $text;
            // Use optionIsSession to determine if this option should be selected
            $selected = optionIsSession($sessionKey, $value);
            $fieldHTML .= '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($text) . '</option>';
        }
    }

    // Close the select tag
    $fieldHTML .= '</select></div>';

    // Return the generated HTML
    return $fieldHTML;
}

/**
 * Generates a 'select' element where the options are a list of dates, both AM and PM included.
 * 
 * @param string $element       Element name of the select
 * @param int|string $input       Int is for the number of valid days. String (YYYY-MM-DD) is for the end date.
 * @param array       $includeDays Array of days of the week to include (e.g., ['MON', 'TUE', 'WED']).
 * @param string     $start       Start date as a string (e.g., 'tomorrow', '2024-06-01').
 * @return string     HTML 'select' element.
 */
function generateDateMeridiemSelect($element, $input, $includeDays = [], $start = 'tomorrow')
{
    $options = [];

    // Map of day abbreviations to numeric values (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
    $dayMap = [
        'SUN' => 0,
        'MON' => 1,
        'TUE' => 2,
        'WED' => 3,
        'THU' => 4,
        'FRI' => 5,
        'SAT' => 6
    ];

    // Make sure the input array is in uppercase for consistency
    $includeDays = array_map('strtoupper', $includeDays);

    // Check if all included days are valid
    foreach ($includeDays as $day) {
        if (!isset($dayMap[$day])) {
            throw new InvalidArgumentException("Invalid day provided: {$day}. Must be one of: SUN, MON, TUE, WED, THU, FRI, SAT.");
        }
    }

    try {
        $startDate = new DateTime($start);
    } catch (Exception $e) {
        // Fallback to tomorrow if invalid start date
        $startDate = new DateTime('tomorrow');
    }

    // Case 1: Integer input — number of valid days (excluding days not in the $includeDays array)
    if (is_int($input)) {
        $validDaysCount = 0;
        while ($validDaysCount < $input) {
            $dayOfWeek = $startDate->format('w'); // Numeric day (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            $dayName = strtoupper($startDate->format('D')); // Abbreviated day name (e.g., 'Mon', 'Tue', etc.)

            if (in_array($dayName, $includeDays)) {
                $formattedDate = $startDate->format('F j, Y');
                $options[] = "<option value='{$formattedDate} AM'>{$formattedDate} AM</option>";
                $options[] = "<option value='{$formattedDate} PM'>{$formattedDate} PM</option>";
                $validDaysCount++;
            }
            $startDate->modify('+1 day');
        }
    }
    // Case 2: String input — treat as an end date
    elseif (is_string($input)) {
        try {
            $endDate = new DateTime($input);
        } catch (Exception $e) {
            return '<select name="' . $element . '" id="' . $element . '"></select>'; // Return empty if end date is invalid
        }

        while ($startDate <= $endDate) {
            $dayOfWeek = $startDate->format('w'); // Numeric day (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            $dayName = strtoupper($startDate->format('D')); // Abbreviated day name (e.g., 'Mon', 'Tue', etc.)

            if (in_array($dayName, $includeDays)) {
                $formattedDate = $startDate->format('F j, Y');
                $options[] = "<option value='{$formattedDate} AM'>{$formattedDate} AM</option>";
                $options[] = "<option value='{$formattedDate} PM'>{$formattedDate} PM</option>";
            }
            $startDate->modify('+1 day');
        }
    }

    return '<select name="' . $element . '" id="' . $element . '">' . implode("\n", $options) . '</select>';
}


function renderPaginationControls($currentPage, $totalPages, $totalCount)
{
    echo '<div class="pagination">';
    echo "<p>Page $currentPage of $totalPages from $totalCount items</p>";
    $controlLinkGap = 1.5; // Gap between buttons and number links
    echo "<div class='pagination-links'>";
    if ($currentPage > 1) {
        // Link to the first page
        echo '<a href="?page=1"><span class="font-MaterialSymbolsOutlined">first_page</span></a>';
        // Link to the previous page
        echo '<a href="?page=' . ($currentPage - 1) . '" style="margin-right: ' . $controlLinkGap . 'rem;"><span class="font-MaterialSymbolsOutlined">chevron_left</span></a>';
    }
    // Display a range of page numbers (e.g., 1 2 3 ... Last)
    $maxPagesToShow = 7; // Max number of page links to display
    // Calculate the start and end page
    if ($totalPages <= $maxPagesToShow) {
        // If there are fewer than 5 pages, show all pages
        $startPage = 1;
        $endPage = $totalPages;
    } else {
        // Calculate the start and end page dynamically
        if ($currentPage <= floor($maxPagesToShow / 2)) {
            // Near the start, show pages from 1
            $startPage = 1;
            $endPage = min($maxPagesToShow, $totalPages);
        } elseif ($currentPage >= $totalPages - floor($maxPagesToShow / 2)) {
            // Near the end, show the last $maxPagesToShow pages
            $startPage = max(1, $totalPages - $maxPagesToShow + 1);
            $endPage = $totalPages;
        } else {
            // In the middle, show $maxPagesToShow pages centered around the current page
            $startPage = $currentPage - floor($maxPagesToShow / 2);
            $endPage = $currentPage + floor($maxPagesToShow / 2);
        }
    }
    // Show the page numbers
    for ($page = $startPage; $page <= $endPage; $page++) {
        if ($page == $currentPage) {
            // Highlight the current page with an underline
            echo '<span class="current-page">' . $page . '</span>';
        } else {
            echo '<a href="?page=' . $page . '">' . $page . '</a>';
        }
    }
    if ($currentPage < $totalPages) {
        // Link to the next page
        echo '<a href="?page=' . ($currentPage + 1) . '" style="margin-left: ' . $controlLinkGap . 'rem;"><span class="font-MaterialSymbolsOutlined">chevron_right</span></a>';
        // Link to the last page
        echo '<a href="?page=' . $totalPages . '"><span class="font-MaterialSymbolsOutlined">last_page</span></a>';
    }
    echo '</div></div>';
}

?>