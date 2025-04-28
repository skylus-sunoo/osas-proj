<?php
declare(strict_types=1);
session_start();

require_once '_config.php';
require_once 'classes/Router.php';

$router = new Router;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->add("/", function () {
    include_once 'views/public/dashboard/about.php';
    include_once 'views/public/include/header.php';
});

$router->add("/incidents/list", function () {
    include_once 'views/admin/include/header.php';

    include_once 'views/admin/incidents/list.php';
});

$router->add("/incidents/list/delete", function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        deleteData('tb_incident', 'incident_ID', $_POST['incident_ID']);

        unsetPost(['incident_ID']);
    }
    goToPage('/incidents/list');
});

$router->add("/incidents/create", function () {
    include_once 'views/admin/include/header.php';
    
    include_once 'views/admin/incidents/list.php';
    include_once 'views/admin/incidents/create.php';
});

$router->add("/incidents/submit", function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'student_ID' => $_POST['student_ID'],
            'incident_DateTime' => $_POST['incident_DateTime'],
            'incident_Location' => $_POST['incident_Location'],
            'incident_Type' => $_POST['incident_Type'],
            'incident_Description' => $_POST['incident_Description'],
            'incident_Status' => $_POST['incident_Status'],
        ];
        insertData("tb_incident", ['student_ID', 'incident_DateTime', 'incident_Location', 'incident_Type', 'incident_Description', 'incident_Status'], $data);
        
        unsetPost(['student_ID', 'incident_DateTime', 'incident_Location', 'incident_Type', 'incident_Description', 'incident_Status']);
    }
    goToPage('/incidents/create');
});

$router->dispatch($path);
?>

<link rel="stylesheet" href="/assets/css/styles.css">
<link rel="stylesheet" href="/assets/fonts/fonts.css">