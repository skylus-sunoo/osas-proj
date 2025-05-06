<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_home.css">
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Dashboard</h1>
        </div>
        <hr>

        <div class="home-cards">
            <?php
            $count = countData(TB_ADMISSION_USER);
            $controller->generateHomeCard('orange', 'person', $count, 'Total Users', 'View Users', '/admissions/overview');

            $count = countData(TB_ADMISSION_INFO);
            $controller->generateHomeCard('var(--primary-hex-blue-dark)', 'school', $count, 'Total Admissions', 'View Admissions', '/admissions/overview');

            $count = countData(TB_ADMISSION_CONTROL);
            $controller->generateHomeCard('coral', 'confirmation_number', $count, 'Total Control Number', 'Search by Control Number', '/admissions/requirements');

            $count = countData(TB_ADMISSION_CONTROL, [['admission_Picture', 'IS NOT NULL'], ['admission_Folder', 'IS NOT NULL']]);
            $controller->generateHomeCard('purple', 'upload_file', $count, 'Finished Requirements', 'Setup Requirements', '/admissions/requirements');
            ?>
        </div>
        <hr>
        <div class="home-cards">
            <?php
            $count = countData(TB_ADMISSION_CONTROL, [['admission_Exam', 'IS NOT NULL']]);
            $controller->generateHomeCard('darkblue', 'event_available', $count, 'Has Exam Schedule', 'Release Exam Schedules', '/admissions/examinations');

            $count = countData(TB_ADMISSION_CONTROL, [['admission_Result', '=', 'PASSED']]);
            $controller->generateHomeCard('var(--primary-hex-green)', 'sentiment_very_satisfied', $count, 'Passed the Exam', 'Setup Exam Result', '/admissions/examinations?results=true');
            $count = countData(TB_ADMISSION_CONTROL, [['admission_Result', '=', 'FAILED']]);
            $controller->generateHomeCard('var(--primary-hex-red)', 'sentiment_very_dissatisfied', $count, 'Failed the Exam', 'Setup Exam Result', '/admissions/examinations?results=true');
            ?>
        </div>

        <!-- <div class="admin-admissions-content">
            <div class="admissions-card">
                <h2>New Applications</h2>
                <p>Number of new applications: <?= $newApplicationsCount; ?></p>
            </div>
            <div class="admissions-card">
                <h2>Pending Applications</h2>
                <p>Number of pending applications: <?= $pendingApplicationsCount; ?></p>
            </div>
            <div class="admissions-card">
                <h2>Accepted Applications</h2>
                <p>Number of accepted applications: <?= $acceptedApplicationsCount; ?></p>
            </div>
            <div class="admissions-card">
                <h2>Rejected Applications</h2>
                <p>Number of rejected applications: <?= $rejectedApplicationsCount; ?></p>
            </div>
            <div class="admissions-card">
                <h2>Application Statistics</h2>
                <p>Statistics of applications: <?= $applicationStatistics; ?></p>
            </div>
        </div> -->
    </main>
</body>

</html>