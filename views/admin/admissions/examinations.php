<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_examinations.css">
    <link rel="stylesheet" href="../../../assets/css/admin_styles.css">
    <style>
        /* Base Styles for the Admin Requirements Form */

        .admin-requirements-form {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .admin-requirements-form form {
            display: flex;
            flex-direction: column;
            row-gap: 2rem;
        }

        .admin-requirements-form label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* Checkboxes */
        .admin-requirements-form input[type="checkbox"]:hover {
            cursor: pointer;
        }

        .admin-requirements-form input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            position: relative;
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid #ccc;
            background-color: var(--primary-hex-white);
            ;
            transition: background-color 0.3s, border-color 0.3s;
            margin-right: 10px;
        }

        .admin-requirements-form input[type="checkbox"]:checked {
            background-color: var(--primary-hex-green-light);
            border-color: var(--primary-hex-green-light);
        }

        .admin-requirements-form input[type="checkbox"]:checked::before {
            content: '✔';
            position: absolute;
            top: -2px;
            left: 3px;
            font-size: 16px;
            color: white;
        }
    </style>
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Examinations</h1>
        </div>
        <hr>

        <!-- Tabs for switching content -->
        <div class="tabs">
            <button id="tab1" class="active">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">calendar_month</span>&nbsp; Exam Dates
            </button>
            <button id="tab2">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">assignment_turned_in</span>&nbsp; Exam Results</div>
            </button>
        </div>

        <!-- <?= preformat($_POST) ?> -->

        <div class="tab-content admin-exam-dates" id="admin-exam-dates">
            <div class="admin-examinations-set">
                <form action="/admissions/exam_create" method="post">
                    <div class="admin-form-group" style="flex-direction: row;">
                        <!-- <?=
                                generateDateMeridiemSelect('exam_Date', 120, ['MON']);
                                ?> -->
                        <input class="admin-input" type="date" name="exam_DateCalendar" required>
                        <select name="exam_DateMeridiem" class="admin-select" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        <input class="admin-input" type="number" name="exam_Capacity" placeholder="Insert capacity" required>
                        <button type="submit" class="primary-button">Set Exam Date</button>
                    </div>
                </form>
            </div>

            <?php
            $controller->renderExamTable();
            ?>
        </div>

        <div class="tab-content admin-exam-results" id="admin-exam-results">
            <div class="admin-examinations-set">
                <form action="/admissions/exam_results?results=true" method="post">
                    <div class="admin-form-group" style="flex-direction: row;">
                        <input class="admin-input" type="date" name="exam_DateCalendar" required>
                        <select name="exam_DateMeridiem" class="admin-select" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>
            </div>


            <?php
            $controller->renderExamBatch();
            ?>
            <!-- <div class="admin-input-search">
                <form action="/admissions/exam_results?results=true" method="post">
                    <div class="admin-form-group" style="flex-direction: row;">
                        <input class="admin-input" type="number" name="search_ControlNumber" placeholder="Search by control number" style="width: 100%;">
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>
            </div>

            <div class="admin-requirements-form">
                <form action="/admissions/exam_results?results=true" method="post">
                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <input type="hidden" name="results_ID" value="<?= $_POST['results_ID'] ?? '' ?>">
                            <label for="results_ControlNumber">Control Number</label>
                            <input class="admin-input" type="text" name="results_ControlNumber" style="max-width: 100%;" disabled value="<?= $_POST['results_ControlNumber'] ?? 'N/A' ?>">

                            <label for="results_Name">Name</label>
                            <input class="admin-input" type="text" name="results_Name" style="max-width: 100%;" disabled value="<?= $_POST['results_Name'] ?? 'N/A' ?>">
                        </div>

                        <div class="admin-form-group">
                            <label for="results_Email">Email</label>
                            <input class="admin-input" type="text" name="results_Email" style="max-width: 100%;" disabled value="<?= $_POST['results_Email'] ?? 'N/A' ?>">

                            <label for="results_ControlNumber">Exam Result</label>
                            <select name="results_Result" class="admin-select">
                                <option value=""></option>
                                <option value="FAILED" <?= (isset($_POST['results_Result']) && $_POST['results_Result'] == 'FAILED') ? 'selected' : '' ?>>Failed</option>
                                <option value="PASSED" <?= (isset($_POST['results_Result']) && $_POST['results_Result'] == 'PASSED') ? 'selected' : '' ?>>Passed</option>
                            </select>
                        </div>
                    </div>
                    <div class="admin-form-row">
                        <button type="submit" class="primary-button" style="width: 100%;">Save</button>
                    </div>
                </form>
            </div> -->
        </div>
    </main>

    <script>
        // JavaScript for tab switching
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the 'single' GET parameter exists
            const urlParams = new URLSearchParams(window.location.search);
            const isSingle = urlParams.has('results'); // true if 'single' exists, otherwise false

            // If 'single' is present in the URL, show the 'Single Admission' tab
            if (isSingle) {
                document.getElementById('admin-exam-dates').classList.remove('active');
                document.getElementById('admin-exam-results').classList.add('active');
                document.getElementById('tab1').classList.remove('active');
                document.getElementById('tab2').classList.add('active');
            } else {
                document.getElementById('admin-exam-dates').classList.add('active');
                document.getElementById('admin-exam-results').classList.remove('active');
                document.getElementById('tab1').classList.add('active');
                document.getElementById('tab2').classList.remove('active');
            }

            // Tab switching functionality
            document.getElementById('tab1').addEventListener('click', function() {
                document.getElementById('admin-exam-dates').classList.add('active');
                document.getElementById('admin-exam-results').classList.remove('active');
                this.classList.add('active');
                document.getElementById('tab2').classList.remove('active');
            });

            document.getElementById('tab2').addEventListener('click', function() {
                document.getElementById('admin-exam-dates').classList.remove('active');
                document.getElementById('admin-exam-results').classList.add('active');
                this.classList.add('active');
                document.getElementById('tab1').classList.remove('active');
            });
        });
    </script>

</body>

</html>