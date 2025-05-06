<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_overview.css">
    <style>
        .admin-incidents table {
            width: 100%;
        }

        .table-wrapper {
            margin: 10px;
        }

        /* Table Styling */
        .admin-incidents table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            /* margin-top: 2rem; */
            background-color: var(--primary-hex-white);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .admin-incidents th:nth-child(2),
        .admin-incidents td:nth-child(2) {
            width: 30%;
        }

        .admin-incidents th:nth-child(6),
        .admin-incidents td:nth-child(6),
        .admin-incidents th:nth-child(7),
        .admin-incidents td:nth-child(7) {
            width: 5%;
        }

        #overview-reviewing {
            background-color: rgba(var(--primary-rgb-selected), 0.25);
        }

        .admin-incidents th,
        .admin-incidents td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--primary-hex-green-light);
            color: var(--primary-hex-green-dark);
        }

        .admin-incidents th {
            background-color: var(--primary-hex-green-dark);
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        .admin-incidents td {
            background-color: #fff;
            font-size: 1rem;
            text-align: center;
            /* padding: 0 !important; */
            padding: 10px;
        }

        .admin-incidents tr:hover {
            /* background-color: var(--primary-hex-green-light); */
        }

        .admin-incidents td button.review-btn {
            background-color: var(--primary-hex-yellow);
            color: black;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            border: none;
            cursor: pointer;
            font-family: 'Gotham', sans-serif;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            font-weight: bold;
        }

        .admin-incidents td button.review-btn:hover {
            background-color: var(--primary-hex-green);
            color: white;
        }

        /* Additional Styles for Table Row */
        .admin-incidents tr:nth-child(even) td {
            background-color: var(--primary-hex-white);
            /* Alternate row color */
        }

        .admin-incidents tr:nth-child(odd) td {
            background-color: #f8f8f8;
            /* Lighter row color */
        }

        /* Column Specific Adjustments */
        .admin-incidents td:nth-child(1),
        .admin-incidents td:nth-child(8) {
            text-align: center;
        }

        /* DONE status cell styling */
        .admin-incidents td div.done {
            color: var(--primary-hex-green);
            background-color: rgba(var(--primary-rgb-green), 0.1);
            font-weight: bold;
            text-align: center;
            padding: 0.5rem;
            border-style: solid;
            border-color: var(--primary-hex-green);
            border-radius: 15px;
            width: 100%;
            margin: auto;
            box-sizing: border-box;
        }

        /* Not DONE status cell styling */
        .admin-incidents td div.not-done {
            color: var(--primary-hex-red);
            background-color: rgba(var(--primary-rgb-red), 0.1);
            font-weight: bold;
            text-align: center;
            padding: 0.5rem;
            border-style: solid;
            border-color: var(--primary-hex-red);
            border-radius: 15px;
            width: 100%;
            margin: auto;
            box-sizing: border-box;
        }
    </style>
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Incidents Overview</h1>
        </div>
        <hr>

        <!-- <?php preformat($_POST); ?> -->

        <div class="admin-incidents" id="admin-incidents">
            <div class="admin-admissions-search" style="display: flex; margin-top: 1rem;">
                <form action="/incidents/overview" method="post" style="max-width: 80%;">
                    <div class="search-group">
                        <input class="admin-input" type="text" name="filter_Name" placeholder="Search by name" style="width: 500px;">

                        <select name="filter_Type" class="admin-select">
                            <option value="">Search by incident type</option>
                            <?php
                            $incidentTypes = [
                                'Bullying',
                                'Destruction of Property',
                                'Tardiness',
                                'Vandalism',
                                'Fighting'
                            ];
                            ?>
                            <?php foreach ($incidentTypes as $incident): ?>
                                <option value="<?= htmlspecialchars($incident) ?>">
                                    <?= htmlspecialchars($incident) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="filter_Status" class="admin-select">
                            <option value="">Search by status</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Dismissed">Dismissed</option>
                        </select>
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>

                <div style="text-align: right; width: 100%;">
                    <button class="primary-button" id="btnCreateIncident">Create Incident</button>
                </div>
            </div>

            <div class="admin-incidents-list">
                <div class="table-wrapper">
                    <?php
                    $controller->renderIncidentsOverview();
                    ?>
                </div>
            </div>
        </div>
    </main>

    <div id="modalIncident" class="public-modal" style="display: none;">
        <div class="public-modal-content" style="margin-top: 15vh;">
            <section class="public-modal-title">
                <strong>Incident</strong>
            </section>

            <form method="post" action="/incidents/overview">
                <section class="public-modal-body">
                    <strong>Violator Information</strong>
                    <br>
                    <br>
                    <div style="display: flex; flex-direction: column; row-gap: 1rem;">
                        <input class="admin-input" type="hidden" name="incident_ID" value="<?= $_POST['incident_ID'] ?? '' ?>">

                        <div>
                            <label for="incident_Name">Name (Last, First Middle)</label>
                            <input class="admin-input" type="text" name="incident_Name" required value="<?= $_POST['incident_Name'] ?? '' ?>">
                        </div>

                        <div>
                            <label for="incident_Type">Type of Violation</label>
                            <select name="incident_Type" class="admin-select" required style="width: 100%; box-sizing: border-box;">
                                <option value=""></option>
                                <?php foreach ($incidentTypes as $incident): ?>
                                    <option value="<?= htmlspecialchars($incident) ?>" <?= isset($_POST['incident_Type']) && $incident === $_POST['incident_Type'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($incident) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="incident_DateTime">Date and Time</label>
                            <input class="admin-input" type="datetime-local" name="incident_DateTime" required value="<?= $_POST['incident_DateTime'] ?? '' ?>">
                        </div>

                        <div style="display: flex; column-gap: 1rem">
                            <div>
                                <label for="incident_Location">Location</label>
                                <input class="admin-input" type="text" name="incident_Location" required value="<?= $_POST['incident_Location'] ?? '' ?>">
                            </div>
                            <div>
                                <label for="incident_Status">Status</label>
                                <select name="incident_Status" class="admin-select" required style="width: 100%; box-sizing: border-box;">
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Dismissed">Dismissed</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="incident_Description">Description</label>
                            <textarea class="admin-input" type="text" name="incident_Description" required rows="5" style="width: 100%; resize: none;"><?= $_POST['incident_Description'] ?? '' ?></textarea>
                        </div>
                    </div>
                </section>

                <section class="public-modal-footer">
                    <input type="hidden" name="form_action" id="form_action" value="create">
                    <button type="submit" class="primary-button" onclick="setFormAction('create')">Create</button>
                    <button type="submit" class="secondary-button" onclick="setFormAction('update')">Update</button>
                    <button type="submit" class="danger-button" onclick="setFormAction('delete')">Delete</button>
                    <a id="btnCloseModalIncident" class="close-button">Cancel</a>
                </section>
            </form>
        </div>
    </div>

    <script>
        function setFormAction(action) {
            document.getElementById('form_action').value = action;
        }

        // Show
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const isReviewing = urlParams.has('review');
            if (isReviewing) {
                document.getElementById("modalIncident").style.display = "block";
            }
        });

        document.getElementById("btnCreateIncident").addEventListener("click", function() {
            document.getElementById("modalIncident").style.display = "block";
        });

        // Close
        document.getElementById("btnCloseModalIncident").addEventListener("click", function() {
            document.getElementById("modalIncident").style.display = "none";
        });

        // Out of bounds close
        window.addEventListener("click", function(event) {
            if (event.target == document.getElementById("modalIncident")) {
                document.getElementById("modalIncident").style.display = "none";
            }
        });
    </script>
</body>

</html>



<!-- $userModel = new UserModel();
$userModel->createRandomUser(TB_ADMISSION_USER);
$userModel->createRandomUser(TB_ADMISSION_USER);
$userModel->createRandomUser(TB_ADMISSION_USER); -->