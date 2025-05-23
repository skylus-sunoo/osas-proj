<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloadable Forms - CVSU Silang</title>
    <link rel="stylesheet" href="../../../assets/css/public_home.css">

    <style>
        /* Base Reset */
        .download-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
        }

        /* Each form item */
        .download-form-item {
            position: relative;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        /* Overlay effect */
        .download-form-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(45, 71, 57, 0.25);
            /* slight green overlay */
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        /* Improved Hover */
        .download-form-item:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.95);

        }

        /* Hide overlay on hover */
        .download-form-item:hover::after {
            opacity: 0;
        }

        .download-form-item img {
            width: 100%;
        }

        /* Heading for each form */
        .download-form-item h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-hex-green);
            /* dark green */
            padding-inline: 1rem;
            margin: 0;
            min-height: 4.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Link styling (for accessibility and better UX) */
        .download-form-grid a {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .download-heading {
            text-align: center;
            color: var(--primary-hex-yellow);
            font-size: 2.5rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="public-body">
    <main class="public-main">
        <header class="public-header">
            <h2>Downloadable Forms</h2>
            <h4><i>HOME >> DOWNLOADABLE FORMS</i></h4>
            <hr>
        </header>

        <br>

        <h1 class="download-heading">OSAS Files</h1>
        <section class="download-form-grid">
            <?=
            generateFormItem(
                'Parent/Guardian Permit/Consent',
                'OSAS-QF-25',
                'https://drive.google.com/file/d/1QgI0oyot7XEkf5ePskNXYFBeQsQn5O-S/view'
            );
            generateFormItem(
                'Application Form for Scholarship',
                'OSAS-QF-28',
                'https://drive.google.com/file/d/1HxRTVZram_bJbnTfkTb28xIpHM_O2rj6/view'
            );
            generateFormItem(
                'Application for Student Assistantship',
                'OSAS-QF-33',
                'https://drive.google.com/file/d/1pxmfBaiItdaV2YNXOvS0kObTdyZ6K3r5/view'
            );
            generateFormItem(
                'Request for Certificate of Good Moral Character',
                'OSAS-QF-41',
                'https://drive.google.com/file/d/1aQtcPg4i7-XrEKiXznSHxyS0zMGJHpkW/view'
            );
            ?>
        </section>

        <h1 class="download-heading">Registrar Files:</h1>
        <section class="download-form-grid">
            <?=
            generateFormItem(
                'Student Information Sheet',
                'UREG-QF-02',
                'https://drive.google.com/file/d/11AJfThDVGtU-GGAxDxdFaqFKNuJUCW08/view'
            );
            generateFormItem(
                'Pre-Registration Form',
                'UREG-QF-05',
                'https://drive.google.com/file/d/1yqjHLjAqaCkmL9pDrS0_Utw-RSFMGc4y/view'
            );
            generateFormItem(
                'Letter of Intent',
                'UREG-QF-07',
                'https://drive.google.com/file/d/1JASRubDZbWtHfIL29SNyNO72KQuPlmJo/view'
            );
            generateFormItem(
                'Adding/Dropping/Changing of Subject Schedule',
                'UREG-QF-09',
                'https://drive.google.com/file/d/1fkG7Xy-2UIIDsAoAjP7KBB8_l1Vheaaq/view'
            );
            generateFormItem(
                'Request for Withdrawal of Registration',
                'UREG-QF-10',
                'https://drive.google.com/file/d/1LvyJHBhEJ1JweQMVPsbyAiLO5Xz9KZfq/view'
            );
            generateFormItem(
                'Grading Sheet',
                'UREG-QF-13',
                'https://drive.google.com/file/d/12mWpdQ-KNiYhhoy9-BBlxn2nXUk-O3-R/view'
            );
            generateFormItem(
                'Application for Graduation',
                'UREG-QF-14',
                'https://drive.google.com/file/d/1lahN6eZd6z3FoPPcToQybosIOxa6Xbar/view'
            );
            generateFormItem(
                'Report of Completion',
                'UREG-QF-16',
                'https://drive.google.com/file/d/1cxXv-0Qprbd4m20RD8aWuT-PQLolXazD/view'
            );
            ?>
        </section>
    </main>
</body>

</html>

<?php

function generateFormItem($label, $img, $link)
{
    echo '<a target="_blank" href="' . $link . '">
                <div class="download-form-item">
                    <img oncontextmenu="return false;" src="../../../assets/img/forms/' . $img . '.png">
                    <h3>' . $label . '</h3>
                </div>
            </a>';
}
