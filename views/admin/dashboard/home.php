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

            $controller->generateHomeCard('var(--primary-hex-red)', 'confirmation_number', $count, 'Total Control Number', 'View Details', '/admissions/requirements');

            ?>
        </div>

        <div class="admin-admissions-content">
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
        </div>
    </main>
</body>

</html>