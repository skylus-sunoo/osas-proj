<aside class="enrollment-information-aside">
    <section class="enrollment-information-sidebar">
        <button data-step="enrollment-admission-information">
            <h1>Admission Information <?= markedAsComplete(1); ?></h1>
        </button>
        <button data-step="enrollment-personal-information">
            <h1>Personal Information <?= markedAsComplete(2); ?></h1>
        </button>
        <button data-step="enrollment-family-information">
            <h1>Family Background <?= markedAsComplete(3); ?></h1>
        </button>
        <button data-step="enrollment-education-information">
            <h1>Educational History <?= markedAsComplete(4); ?></h1>
        </button>
        <button data-step="enrollment-medical-information">
            <h1>Medical Background <?= markedAsComplete(5); ?></h1>
        </button>
        <section class="enrollment-information-control-section">
            <div class="pre-control" style="display: <?= isset($_SESSION['admission_ControlNumber']) ? 'none' : 'block' ?>;">
                <p>You <b>cannot modify</b> your application info once you have your control number.</p>
                <br>
                <hr>
                <br>
                <p>Please get your control number by clicking the button below.</p>
                <br>
                <br>
                <a class="primary-button" id="btnGetControlNumber">Get Control Number</a>
                <br>
            </div>
            <div class="post-control" style="display: <?= isset($_SESSION['admission_ControlNumber']) ? 'block' : 'none' ?>;">
                <p>Your control number is:</p>
                <h1 style="color: var(--primary-yellow); font-size: 2.5rem;"><?= $_SESSION['admission_ControlNumber'] ?></h1>
                <br>
                <hr>
                <br>
                <p>Download your application form here</p>
                <br>
                <form method="post" action="../generate-pdf.php" target="_blank">
                    <input type="hidden" name="application_form_id" value="<?= $_SESSION['admission_ID'] ?>">
                    <button type="submit" class="primary-button">Download Profile</button>
                </form>
                <br>
                <hr>
                <br>
                <?php
                if ($this->hasAppointment()):
                ?>
                    <p>Submission schedule</p>
                    <br>
                    <?=
                    $this->renderSubmissionSchedule();
                    ?>
                <?php else: ?>
                    <p>Select a date to submit <b>all</b> of your requirements.</p>
                    <br>
                    <?=
                    $this->generateAppointmentSelect(60);
                    ?>
                    <br>
                    <br>
                    <br>
                    <a class="primary-button" id="btnSetAppointment">Save schedule of visit</a>
                <?php endif; ?>
            </div>
        </section>
    </section>
</aside>

<div id="modalControl" class="public-modal" style="display: none;">
    <div class="public-modal-content">
        <section class="public-modal-title">
            <strong>Get Control Number</strong>
        </section>

        <section class="public-modal-body">
            <p>Please review your application carefully. Once you receive your control number, you cannot modify your information.</p>
            <br>
            <b>
                <p><?= $_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_LastName'] . ' ' . $_SESSION['admission_Suffix'] ?></p>
                <p><?= 'CvSU - ' . $_SESSION['admission_Branch'] ?></p>
                <p><?= $_SESSION['admission_Program'] ?></p>
            </b>
            <br>
            <p>Do you want to proceed and get your control number now?</p>
        </section>

        <section class="public-modal-footer">
            <form method="post" action="/admission/enrollment">
                <input type="hidden" name="enrollment-control-number" value="true">
                <button type="submit" class="primary-button">Get Control Number</button>
            </form>
            <button id="btnCloseModalControl" class="close-button">Close</button>
        </section>
    </div>
</div>

<div id="modalAppointment" class="public-modal" style="display: none;">
    <div class="public-modal-content">
        <section class="public-modal-title">
            <strong>Schedule Appointment</strong>
        </section>

        <section class="public-modal-body">
            <p>Only save a schedule if your requirements are <b>complete</b>. Do not pick a schedule you cannot attend to.</p>
            <br>
            <p>Selected Schedule: <b><span id="modalAppointmentDate"></span></b></p>
        </section>

        <section class="public-modal-footer">
            <form method="post" action="/admission/updateAppointment">
                <input type="hidden" name="enrollment-information-appointment-confirm" id="enrollment-information-appointment-confirm">
                <button type="submit" class="primary-button">Set Schedule</button>
            </form>
            <button id="btnCloseModalAppointment" class="close-button">Cancel</button>
        </section>
    </div>
</div>

<script>
    const selectAppointment = document.getElementById('enrollment-information-appointment');
    const hiddenInput = document.getElementById('enrollment-information-appointment-confirm');

    const modalAppointment = document.getElementById('modalAppointmentDate');

    // Initial date
    hiddenInput.value = selectAppointment.value;
    modalAppointment.innerText = selectAppointment.value;

    // This gets the value anytime the selection changes
    selectAppointment.addEventListener('change', function() {
        const selectedValue = this.value;
        hiddenInput.value = selectedValue;
        modalAppointment.innerText = selectedValue;
        // alert("Selected appointment: " + selectedValue);
    });

    // Show
    document.getElementById("btnGetControlNumber").addEventListener("click", function() {
        document.getElementById("modalControl").style.display = "block";
    });

    // Close
    document.getElementById("btnCloseModalControl").addEventListener("click", function() {
        document.getElementById("modalControl").style.display = "none";
    });

    // Show
    document.getElementById("btnSetAppointment").addEventListener("click", function() {
        document.getElementById("modalAppointment").style.display = "block";
    });

    // Close
    document.getElementById("btnCloseModalAppointment").addEventListener("click", function() {
        document.getElementById("modalAppointment").style.display = "none";
    });

    // Out of bounds close
    window.addEventListener("click", function(event) {
        if (event.target == document.getElementById("modalControl")) {
            document.getElementById("modalControl").style.display = "none";
        }
        if (event.target == document.getElementById("modalAppointment")) {
            document.getElementById("modalAppointment").style.display = "none";
        }
    });
</script>

<?php
function markedAsComplete($table)
{
    $tableMapping = [
        1 => TB_ADMISSION_INFO,
        2 => TB_ADMISSION_PERSONAL,
        3 => TB_ADMISSION_FAMILY,
        4 => TB_ADMISSION_EDUCATION,
        5 => TB_ADMISSION_MEDICAL
    ];

    if (isset($tableMapping[$table])) {
        $tableConstant = $tableMapping[$table];

        // Check if the record exists in the table
        $column = ($table === 1) ? 'admission_Entry' : 'admission_ID';
        $id = ($table === 1) ? $_SESSION['admission_Entry'] : $_SESSION['admission_ID'];

        // If the data exists in the table, display the checkmark
        if (checkForData($tableConstant, [[$column, '=', $id]])) {
            echo '<span style="color: green">✔</span>';
        } else {
            echo '<span style="color: red">✘</span>';
        }
    } else {
        // If the table number isn't valid, show an error or nothing
        echo '<span style="color: red">✘</span>';
    }
}
