<?php

declare(strict_types=1);
?>

<link rel="apple-touch-icon" sizes="180x180" href="../../../assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../../assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../../assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="../../../assets/img/favicon/site.webmanifest">

<link rel="preload" href="/assets/css/styles.css" as="style" />
<link rel="stylesheet" href="/assets/css/styles.css">

<link rel="preload" href="/assets/css/fonts.css" as="style" />
<link rel="stylesheet" href="/assets/fonts/fonts.css">

<?php
session_start();

require_once '_config.php';
require_once 'classes/Router.php';
require_once 'controllers/AdmissionController.php';

$router = new Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->add("/dashboard/home", function () {
    if (isset($_SESSION['logout'])) {
        session_unset(); 
        session_destroy(); 
        showAlert("You have successfully logged out.");
    }

    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/home.php';
});

$router->add("/admission/logout", function () {
    $controller = new AdmissionController();
    $controller->logoutUser();
});

$router->add("/admission/application", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/admission/admission.php';
});

$router->add("/admission/enrollment", function () {
    $controller = new AdmissionController();
    $controller->handleEnrollmentRedirect();
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

$router->add("/admission/course", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/admission/course.php';
});

$router->add("/dashboard/students", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/students.php';
});

$router->add("/about/statements", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/statements.php';
});

$router->add("/about/history", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/history.php';
});

$router->add("/about/officials", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/about/officials.php';
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


?>