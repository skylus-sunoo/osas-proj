<?php
$incidents = fetchData('tb_incident');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident List</title>
</head>

<body>
    <h2>All Incidents</h2>

    <?php if (!empty($incidents)): ?>
        <table class="incident-table">
            <thead>
                <tr>
                    <th style="display: none;">Incident ID</th>
                    <th>Student ID</th>
                    <th>Incident Date & Time</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($incidents as $incident): ?>
                    <tr>
                        <td style="display: none;"><?php echo htmlspecialchars($incident['incident_ID']); ?></td>
                        <td><?php echo htmlspecialchars($incident['student_ID']); ?></td>
                        <td><?php echo htmlspecialchars($incident['incident_DateTime']); ?></td>
                        <td><?php echo htmlspecialchars($incident['incident_Location']); ?></td>
                        <td><?php echo htmlspecialchars($incident['incident_Type']); ?></td>
                        <td><?php echo htmlspecialchars($incident['incident_Description']); ?></td>
                        <td><?php echo htmlspecialchars($incident['incident_Status']); ?></td>
                        <td>
                            <form action="/incidents/list/modal" method="post">
                                <button type="submit">Update</button>
                            </form>
                            <form action="/incidents/list/delete" method="post">
                                <input type="hidden" name="incident_ID" value="<?php echo htmlspecialchars($incident['incident_ID']); ?>" hidden>
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No incidents found.</p>
    <?php endif; ?>
</body>

</html>