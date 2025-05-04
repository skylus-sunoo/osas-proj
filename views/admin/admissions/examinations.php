<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_examinations.css">
    <style>
        .admin-requirements-search {
            padding: 2rem;
        }

        .admin-requirements-search form div {
            justify-content: center;
            align-items: center;
        }

        .admin-requirements-search form .form-group {
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

        <form action="/admissions/examinations" method="post">
            <div class="form-group">
                <input class="admin-input" type="number" name="search_ControlNumber" placeholder="Search by control number" style="width: 100%;">
                <button type="submit" class="primary-button">Search</button>
            </div>
        </form>
        <h2>Create Exam Date</h2>

        <div class="admin-requirements-search">
            <form action="/admissions/requirements" method="post">
                <div class="form-group">
                    <input class="admin-input" type="number" name="search_ControlNumber" placeholder="Search by control number" style="width: 100%;">
                    <button type="submit" class="primary-button">Search</button>
                </div>
            </form>
        </div>

        <div class="admin-requirements-form">

            <!-- <?= preformat($_POST) ?> -->

            <form action="/admissions/requirements" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <input type="hidden" name="requirements_ID" value="<?= $_POST['requirements_ID'] ?? '' ?>">
                        <label for="requirements_ControlNumber">Control Number</label>
                        <input class="admin-input" type="text" name="requirements_ControlNumber" disabled value="<?= $_POST['requirements_ControlNumber'] ?? 'N/A' ?>">

                        <label for="requirements_Name">Name</label>
                        <input class="admin-input" type="text" name="requirements_Name" disabled value="<?= $_POST['requirements_Name'] ?? 'N/A' ?>">
                    </div>

                    <div class="form-group">
                        <label for="requirements_ControlNumber">Requirements</label>
                        <div>
                            <input type="checkbox" name="requirements_Picture" value="Yes" <?= (isset($_POST['admission_Picture'])) ? 'checked' : '' ?>>
                            <label for="requirements_Picture">ID Picture</label>
                        </div>

                        <div>
                            <input type="checkbox" name="requirements_Folder" value="Yes" <?= (isset($_POST['admission_Folder'])) ? 'checked' : '' ?>>
                            <label for="requirements_Folder">Short Folder</label>
                        </div>

                        <div>
                            <input type="checkbox" name="requirements_Certificate" value="Yes" <?= (isset($_POST['admission_Certificate'])) ? 'checked' : '' ?>>
                            <label for="requirements_Certificate">Certified True Copy of G12 report card <br> Certificate of ALS Rating</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="primary-button">Save</button>
            </form>
        </div>

    </main>

</body>

</html>