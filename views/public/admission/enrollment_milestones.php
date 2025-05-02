<?php
$sessionKeys = [
    'admission_ControlNumber',
    'admission_Appointment',
    'admission_Exam',
    'admission_Result'
];

$conditions = [
    isset($_SESSION['admission_ControlNumber']),
    isset($_SESSION['admission_Appointment']),
    isset($_SESSION['admission_Exam']),
    isset($_SESSION['admission_Result']) && $_SESSION['admission_Result']
];

$steps = [];
$foundCurrent = false;

foreach ($conditions as $condition) {
    if ($condition && !$foundCurrent) {
        $steps[] = 'completed';
    } elseif (!$condition && !$foundCurrent) {
        $steps[] = 'current';
        $foundCurrent = true;
    } else {
        $steps[] = '';
    }
}
$totalSteps = count($steps);

$controlNumber = isset($_SESSION['admission_ControlNumber']) ? $_SESSION['admission_ControlNumber'] : '<span style="color: var(--primary-hex-red)">N/A</span>';
$submissionSchedule = isset($_SESSION['admission_Appointment']) ? $_SESSION['admission_Appointment'] : '<span style="color: var(--primary-hex-red)">N/A</span>';
$examSchedule = isset($_SESSION['admission_Exam']) ? $_SESSION['admission_Exam'] : '<span style="color: var(--primary-hex-red)">N/A</span>';
$admissionResult = isset($_SESSION['admission_Result']) ? $_SESSION['admission_Result'] : '<span style="color: var(--primary-hex-red)">N/A</span>';

// Define text for each step
$stepTexts = [
    'Control Number <br> <b style="color: var(--primary-hex-yellow)"> ' . $controlNumber . ' </b>',
    'Submission Schedule <br> <b style="color: var(--primary-hex-yellow)"> ' . $submissionSchedule . ' </b>',
    'Exam Schedule <br> <b style="color: var(--primary-hex-yellow)"> ' . $examSchedule . ' </b>',
    'Admission Result <br> <b style="color: var(--primary-hex-yellow)"> ' . $admissionResult . ' </b>'
];

// Find index of current and last completed
$currentIndex = array_search('current', $steps);
$lastCompletedIndex = -1;

foreach ($steps as $i => $step) {
    if ($step === 'completed') {
        $lastCompletedIndex = $i;
    }
}

// Calculate positions
$stepWidthPercent = 100 / ($totalSteps - 1);
$left = $stepWidthPercent * $lastCompletedIndex;
$width = $stepWidthPercent;
$showGradient = $lastCompletedIndex !== -1 && $currentIndex === $lastCompletedIndex + 1;

$progressSegments = [];

for ($i = 0; $i < $totalSteps - 1; $i++) {
    if ($steps[$i] === 'completed' && $steps[$i + 1] === 'completed') {
        $progressSegments[] = [
            'left' => $stepWidthPercent * $i,
            'width' => $stepWidthPercent,
            'type' => 'solid'
        ];
    } elseif ($steps[$i] === 'completed' && $steps[$i + 1] === 'current') {
        $progressSegments[] = [
            'left' => $stepWidthPercent * $i,
            'width' => $stepWidthPercent,
            'type' => 'gradient'
        ];
    }
}
?>

<div class="progress-container">
    <div class="progress-wrapper" style="padding: 0 5rem; margin-bottom: 0.5rem;">
        <div class="progress-bar">
            <?php foreach ($steps as $i => $step): ?>
                <div class="step <?= $step ?>">
                    <span class="step-text"><?= $stepTexts[$i] ?></span>
                </div>
            <?php endforeach; ?>

            <?php foreach ($progressSegments as $segment): ?>
                <div class="progress-segment <?= $segment['type'] ?>" style="left: <?= $segment['left'] ?>%; width: <?= $segment['width'] ?>%;"></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
    .step-text {
        position: relative;
        top: 50;
        width: 500px;
        font-size: 1rem;
        text-align: center;
        white-space: nowrap;
        /* Prevents the text from wrapping */
    }

    .progress-container {
        width: 100%;
        margin: 2rem 0;
        padding: 1rem 0;
        padding-bottom: 3rem;

        border: 1px solid;
        border-radius: 10px;
        color: white;
        background-color: rgba(var(--primary-rgb-blue-dark), 0.75);
    }

    .progress-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .progress-bar::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 2rem;
        right: 2rem;
        height: 12px;
        background-color: rgba(var(--primary-rgb-green), 1);
        z-index: 0;
        transform: translateY(-50%);
        border-radius: 6px;
    }

    .step {
        position: relative;
        z-index: 1;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: white;
        border: 4px solid var(--primary-hex-red);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        transition: all 0.3s ease-in-out;
    }

    .step.completed::before {
        /* content: '✓'; */
        font-weight: bold;
        color: black;
    }

    .step.completed {
        background-color: var(--primary-hex-yellow);
        border-color: var(--primary-hex-yellow);
    }

    .step.current {
        background-color: white;
        border-color: var(--primary-hex-yellow);
        box-shadow: 0 0 0 4px rgba(238, 173, 43, 0.5);
    }

    .progress-gradient {
        position: absolute;
        top: 50%;
        height: 12px;
        transform: translateY(-50%);
        background: linear-gradient(to right, var(--primary-hex-yellow), var(--primary-hex-green));
        border-radius: 6px;
        z-index: 0;
    }

    .progress-segment {
        position: absolute;
        top: 50%;
        height: 12px;
        transform: translateY(-50%);
        border-radius: 6px;
        z-index: 0;
    }

    .progress-segment.gradient {
        background: linear-gradient(to right, var(--primary-hex-yellow), var(--primary-hex-green));
    }

    .progress-segment.solid {
        background-color: var(--primary-hex-yellow);
    }
</style>