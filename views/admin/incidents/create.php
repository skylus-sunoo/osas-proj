<form action="/incidents/submit" method="post">
    <label for="student_ID">Student ID</label>
    <input type="number" name="student_ID" required>

    <label for="incident_DateTime">Date Time</label>
    <input type="datetime-local" name="incident_DateTime" required>

    <label for="incident_Location">Location</label>
    <input type="text" name="incident_Location" required>

    <label for="incident_Type">Type</label>
    <input type="text" name="incident_Type" required>

    <label for="incident_Description">Description</label>
    <input type="text" name="incident_Description" required>

    <label for="incident_Status">Status</label>
    <select name="incident_Status">
        <option value="Ongoing">Ongoing</option>
        <option value="Resolved">Resolved</option>
        <option value="Dismissed">Dismissed</option>
    </select>

    <div id="input-container">
        <input type="text" id="my-input">
        <button id="add-button">Add Input</button>
    </div>
    <div id="new-input-container"></div>

    <button type="reset">Reset</button>
    <button type="submit">Submit</button>
</form>

<script>
    document.getElementById("add-button").addEventListener("click", function() {
        const newInput = document.createElement("input");
        newInput.type = "text";
        document.getElementById("new-input-container").appendChild(newInput);
    });
</script>