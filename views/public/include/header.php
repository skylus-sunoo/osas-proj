<?php
function is_active($needle, $class = 'active_nav')
{
    return (strpos($_SERVER['REQUEST_URI'], $needle) !== false) ? $class : '';
}
function is_active_sub($needle)
{
    return is_active($needle, 'active_subnav');
}
?>



<link rel="stylesheet" href="../../../assets/css/public_header.css">

<header class="header-main">
    <div class="header-school">
        <img src="../../../assets/img/logo.png" alt="">
        <h1>CVSU SILANG</h1>
    </div>

    <nav class="header-nav">
        <a href="../dashboard/home" class="<?= is_active('/dashboard/home') ?>">HOME</a>

        <div class="dropdown">
            <a href="../admission/application" class="dropbtn <?= is_active('/admission/') ?>">ADMISSION</a>
            <div class="dropdown-content">
                <a href="../admission/application" class="<?= is_active_sub('/admission/application') ?>">Application for Admission</a>
                <a href="../admission/enrollment" class="<?= is_active_sub('/admission/enrollment') ?>">Enrollment Form</a>
                <a href="../admission/course" class="<?= is_active_sub('/admission/course') ?>">Course Offered</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" class="dropbtn <?= is_active('students') ?>">STUDENTS</a>
            <div class="dropdown-content">
                <a href="../dashboard/students" class="<?= is_active_sub('students') ?>">Student Portal</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#" class="dropbtn <?= is_active('/about/') ?>">ABOUT CVSU</a>
            <div class="dropdown-content">
                <a href="../about/statements" class="<?= is_active_sub('statements') ?>">Statements</a>
                <a href="../about/history" class="<?= is_active_sub('history') ?>">History</a>
                <a href="../about/officials " class="<?= is_active_sub('officials') ?>">Campus Officials</a>
            </div>
        </div>
    </nav>

</header>