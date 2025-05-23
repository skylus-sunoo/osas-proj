<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_overview.css">
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Admission Overview</h1>
        </div>
        <hr>

        <!-- Tabs for switching content -->
        <div class="tabs">
            <button id="tab1" class="active">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">groups</span>&nbsp; Admissions Overview
            </button>
            <button id="tab2">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">data_loss_prevention</span>&nbsp; Single Admission</div>
            </button>
        </div>

        <!-- Admin Admissions Search and Overview -->
        <div class="tab-content admin-admissions" id="admin-admissions">
            <div class="admin-admissions-search">
                <form action="/admissions/overview" method="post">
                    <div class="search-group">
                        <input class="admin-input" type="text" name="filter_Email" placeholder="Search by user email" style="width: 100%;">
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>
            </div>

            <div class="admin-admissions-list">
                <div class="table-wrapper">
                    <?php
                    $controller->renderAdmissionsOverview();
                    ?>
                </div>
            </div>
        </div>

        <!-- Single Admission -->
        <div class="tab-content admin-admissions-single" id="admin-admissions-single">
            <?php
            $controller->renderAdmissionsOverviewSingle();
            ?>
        </div>

    </main>

    <script>
        // JavaScript for tab switching
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the 'single' GET parameter exists
            const urlParams = new URLSearchParams(window.location.search);
            const isSingle = urlParams.has('single'); // true if 'single' exists, otherwise false

            // If 'single' is present in the URL, show the 'Single Admission' tab
            if (isSingle) {
                document.getElementById('admin-admissions').classList.remove('active');
                document.getElementById('admin-admissions-single').classList.add('active');
                document.getElementById('tab1').classList.remove('active');
                document.getElementById('tab2').classList.add('active');
            } else {
                document.getElementById('admin-admissions').classList.add('active');
                document.getElementById('admin-admissions-single').classList.remove('active');
                document.getElementById('tab1').classList.add('active');
                document.getElementById('tab2').classList.remove('active');
            }

            // Tab switching functionality
            document.getElementById('tab1').addEventListener('click', function() {
                document.getElementById('admin-admissions').classList.add('active');
                document.getElementById('admin-admissions-single').classList.remove('active');
                this.classList.add('active');
                document.getElementById('tab2').classList.remove('active');
            });

            document.getElementById('tab2').addEventListener('click', function() {
                document.getElementById('admin-admissions').classList.remove('active');
                document.getElementById('admin-admissions-single').classList.add('active');
                this.classList.add('active');
                document.getElementById('tab1').classList.remove('active');
            });
        });
    </script>
</body>

</html>



<!-- $userModel = new UserModel();
$userModel->createRandomUser(TB_ADMISSION_USER);
$userModel->createRandomUser(TB_ADMISSION_USER);
$userModel->createRandomUser(TB_ADMISSION_USER); -->