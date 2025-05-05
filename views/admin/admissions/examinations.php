<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_examinations.css">
    <style>
        .admin-examinations-search {
            padding: 1rem;
        }

        .admin-examinations-search form div {
            justify-content: center;
            align-items: center;
        }

        .admin-examinations-search form .form-group {
            display: flex;
            flex-direction: row;
            column-gap: 2rem;
        }

        /* Base Styles for the Admin Requirements Form */
        .form-row {
            display: flex;
            flex-direction: row;
            column-gap: 15px;
        }

        .form-row div {
            width: 100%;
        }

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

        /* Spacing and Layout */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .form-group div {
            display: flex;
            align-items: center;
            column-gap: 0.25rem;
        }

        .form-group input[type="checkbox"] {
            margin: 0;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            max-width: 400px;
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
            <button id="tab1" class="active">Exam Dates</button>
            <button id="tab2">Exam Results</button>
        </div>

        <!-- <?= preformat($_POST) ?> -->

        <div class="tab-content admin-exam-dates" id="admin-exam-dates">
            <div class="admin-examinations-search">
                <form action="/admissions/exam_create" method="post">
                    <div class="form-group">
                        <!-- <?=
                                generateDateMeridiemSelect('exam_Date', 120);
                                ?> -->
                        <input class="admin-input" type="date" name="exam_DateCalendar" required>
                        <select name="exam_DateMeridiem" required>
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

        </div>

        <!-- <form action="/admissions/examinations" method="post">
            <div class="form-group">
                <input type="hidden" name="exam_Release">
                <button type="submit" class="primary-button">Release exam dates to users.</button>
            </div>
        </form> -->
    </main>

    <script>
        // JavaScript for tab switching
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the 'single' GET parameter exists
            const urlParams = new URLSearchParams(window.location.search);
            const isSingle = urlParams.has('single'); // true if 'single' exists, otherwise false

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