<aside class="enrollment-information-aside">
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
</aside>

<?php


function markedAsComplete($table)
{
    $tableMapping = [
        1 => TB_ADMISSION_INFO,
        2 => TB_ADMISSION_PERSONAL,
        3 => TB_ADMISSION_FAMILY,
        // 4 => TB_ADMISSION_EDUCATION,
        // 5 => TB_ADMISSION_MEDICAL
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
