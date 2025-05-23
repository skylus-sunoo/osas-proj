<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_overview.css">
    <link rel="stylesheet" href="../../../assets/css/admin_examinations.css">

    <style>
        button.delete-btn {
            background-color: rgba(var(--primary-rgb-red), 0.5);
            color: black;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            border: none;
            cursor: pointer;
            font-family: 'Gotham', sans-serif;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        button.delete-btn:hover {
            background-color: var(--primary-hex-red);
            color: white;
        }
    </style>
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>News</h1>
        </div>
        <hr>

        <!-- Tabs for switching content -->
        <div class="tabs">
            <button id="tab1" class="active">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">full_coverage</span>&nbsp; News Overview
            </button>
            <button id="tab2">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">newsmode</span>&nbsp; News Action</div>
            </button>
        </div>

        <!-- Admin Admissions Search and Overview -->
        <div class="tab-content admin-admissions" id="admin-admissions">
            <div class="admin-admissions-search">
                <form action="/admin/news" method="post">
                    <div class="search-group">
                        <input class="admin-input" type="text" name="filter_News" placeholder="Search by title" style="width: 100%;">
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>
            </div>

            <div class="admin-admissions-list">
                <div class="table-wrapper">
                    <?php
                    $controller->renderNewsOverview();
                    ?>
                </div>
            </div>
        </div>

        <!-- Single Admission -->
        <div class="tab-content admin-admissions-single" id="admin-admissions-single">
            <?php
            $controller->renderNewsOverviewSingle();
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