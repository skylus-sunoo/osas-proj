<?php

declare(strict_types=1);
?>

<link rel="apple-touch-icon" sizes="180x180" href="../../../assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="../../../assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="../../../assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="../../../assets/img/favicon/site.webmanifest">

<?php
session_start();

require_once '_config.php';
require_once 'classes/Router.php';

$router = new Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->add("/dashboard/home", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/home.php';
});

$router->add("/dashboard/about", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/dashboard/about.php';
});

$router->add("/admission/application", function () {
    include_once 'views/public/include/header.php';
    include_once 'views/public/admission/admission.php';
});

$router->add("/admission/enrollment", function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['branch'])) {
            $_SESSION['branch'] = $_POST['branch'];
        } elseif (isset($_POST['branchReset'])) {
            unset($_SESSION['branch']);
        }
    }

    include_once 'views/public/include/header.php';

    if (isset($_SESSION['branch'])) {
        include_once 'views/public/admission/enrollment_information.php';
    } else{
        include_once 'views/public/admission/enrollment_branch.php';
    }
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

// $router->add("/incidents/list", function () {
//     include_once 'views/admin/include/header.php';

//     include_once 'views/admin/incidents/list.php';
// });

// $router->add("/incidents/list/delete", function () {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         deleteData('tb_incident', 'incident_ID', $_POST['incident_ID']);

//         unsetPost(['incident_ID']);
//     }
//     goToPage('/incidents/list');
// });

// $router->add("/incidents/create", function () {
//     include_once 'views/admin/include/header.php';

//     include_once 'views/admin/incidents/list.php';
//     include_once 'views/admin/incidents/create.php';
// });

// $router->add("/incidents/submit", function () {
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $data = [
//             'student_ID' => $_POST['student_ID'],
//             'incident_DateTime' => $_POST['incident_DateTime'],
//             'incident_Location' => $_POST['incident_Location'],
//             'incident_Type' => $_POST['incident_Type'],
//             'incident_Description' => $_POST['incident_Description'],
//             'incident_Status' => $_POST['incident_Status'],
//         ];
//         insertData("tb_incident", ['student_ID', 'incident_DateTime', 'incident_Location', 'incident_Type', 'incident_Description', 'incident_Status'], $data);

//         unsetPost(['student_ID', 'incident_DateTime', 'incident_Location', 'incident_Type', 'incident_Description', 'incident_Status']);
//     }
//     goToPage('/incidents/create');
// });

$router->dispatch($path);
?>

<link rel="preload" href="/assets/css/styles.css" as="style" />
<link rel="stylesheet" href="/assets/css/styles.css">

<link rel="preload" href="/assets/css/fonts.css" as="style" />
<link rel="stylesheet" href="/assets/fonts/fonts.css">