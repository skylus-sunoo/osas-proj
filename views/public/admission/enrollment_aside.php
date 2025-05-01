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
                <a class="primary-button" id="get-control-number">Get Control Number</a>
                <br>
            </div>
            <div class="post-control" style="display: <?= isset($_SESSION['admission_ControlNumber']) ? 'block' : 'none' ?>;">
                <p>Your control number is:</p>
                <h1 style="color: var(--primary-yellow); font-size: 2rem;"><?= $_SESSION['admission_ControlNumber'] ?></h1>
                <br>
                <p>Click the button below to proceed to the enrollment process.</p>
                <br>
                <form method="post" action="/admission/enrollment">
                    <input type="hidden" name="enrollment-control-number" value="true">
                    <button type="submit" class="primary-button">Proceed to Enrollment</button>
                </form>
            </div>
        </section>
    </section>
</aside>


<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
        <!-- Modal Title -->
        <div class="modal-title">
            <strong>Get Control Number</strong>
        </div>

        <!-- Modal Body (Paragraphs) -->
        <div class="modal-body">
            <p>Please review your application carefully. Once you receive your control number, you cannot modify your information.</p>
            <br>
            <b>
                <p><?= $_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_LastName'] . ' ' . $_SESSION['admission_Suffix'] ?></p>
                <p><?= 'CvSU - ' . $_SESSION['admission_Branch'] ?></p>
                <p><?= $_SESSION['admission_Program'] ?></p>
            </b>
            <br>
            <p>Do you want to proceed and get your control number now?</p>
        </div>

        <!-- Modal Footer (Buttons) -->
        <div class="modal-footer">
            <form method="post" action="/admission/enrollment">
                <input type="hidden" name="enrollment-control-number" value="true">
                <button type="submit" class="primary-button">Get Control Number</button>
            </form>
            <button class="close-button" id="close-modal">Close</button>
        </div>
    </div>
</div>

<style>
    /* Basic Styles for Modal */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        /* Ensure Flexbox is applied */
        justify-content: center !important;
        align-items: center !important;
        padding: 20px;
    }

    .modal-content {
        margin: auto;
        margin-top: 30vh;
        background-color: #fff;
        color: #333;
        padding: 20px;
        border-radius: 10px;
        max-width: 500px;
        width: 100%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }

    .modal-body {
        font-size: 1rem;
        margin-bottom: 20px;
    }

    .modal-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .close-button {
        background-color: #ccc;
        color: black;
        border: none;
        padding: 10px 20px;
        border-radius: 1rem;
        padding: 1rem;
        padding-inline: 1.5rem;
        cursor: pointer;
        font-size: 1rem;
    }

    .close-button:hover {
        background-color: black;
        color: white;
    }
</style>

<script>
    // Show modal when 'Get Control Number' is clicked
    document.getElementById("get-control-number").addEventListener("click", function() {
        document.getElementById("modal").style.display = "block";
    });

    // Close modal when 'Close' button is clicked
    document.getElementById("close-modal").addEventListener("click", function() {
        document.getElementById("modal").style.display = "none";
    });

    // Optional: Close modal if the user clicks outside the modal content
    window.addEventListener("click", function(event) {
        if (event.target == document.getElementById("modal")) {
            document.getElementById("modal").style.display = "none";
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
