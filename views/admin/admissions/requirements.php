<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_requirements.css">
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Requirements</h1>
        </div>
        <hr>

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

                        <label for="requirements_Email">Email</label>
                        <input class="admin-input" type="text" name="requirements_Email" disabled value="<?= $_POST['requirements_Email'] ?? 'N/A' ?>">
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

                        <button type="submit" class="primary-button">Save</button>
                    </div>
                </div>
            </form>
        </div>

    </main>

</body>

</html>