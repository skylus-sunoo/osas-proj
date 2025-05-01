<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="../../../assets/css/public_enrollment.css">
</head>

<body class="enrollment-body">
    <main class="public-main">
        <header class="public-header">
            <h2>ENROLLMENT</h2>
            <h4><i>ADMISSION >> ENROLLMENT FORM</i></h4>
            <hr>
        </header>

        <div class="enrollment-information">
            <?php include_once 'enrollment_aside.php' ?>

            <section class="enrollment-information-section">
                <div class="enrollment-admission-information">
                    <div class="enrollment-information-branch">
                        <h1><?= $_SESSION['admission_Branch'] ?></h1>
                        <form action="/admission/enrollment" method="POST">
                            <input type="hidden" name="branchReset" value="true">
                            <button type="submit">Change Branch</button>
                        </form>
                    </div>

                    <form action="/admission/save_admission_information" method="POST">
                        <hr>
                        <br>

                        <div class="enrollment-information-form">
                            <section class="enrollment-information-form-section">
                                <?php
                                $options = [
                                    'New',
                                    'Transferee',
                                    '2nd Courser',
                                    'TCP'
                                ];
                                echo generateSelectField('entry', 'Entry', $options, 'admission_Entry');

                                $options = [
                                    'Filipino',
                                    'Foreign'
                                ];
                                echo generateSelectField('typeApplicant', 'Applicant Type', $options, 'admission_TypeApplicant');
                                ?>
                            </section>
                            <section class="enrollment-information-form-section">
                                <?php
                                $options = [
                                    'STEM',
                                    'ICT',
                                    'HUMSS',
                                    'GAS',
                                    'ABM',
                                    'HE'
                                ];
                                echo generateSelectFieldEntryNew('strand', 'SHS Strand', $options, 'admission_Strand', true);

                                $options = [
                                    'GR12' => 'Grade 12 Student',
                                    'SHS' => 'SHS Graduate',
                                    'ALS' => 'ALS Passer',
                                    'DEGREE' => 'Associate Certificate, Vocational, or Diploma Degree Holder'
                                ];
                                echo generateSelectFieldEntryNew('typeStudent', 'Type of New Student', $options, 'admission_TypeStudent', true);

                                echo generateFormFieldEntryNew('LRN', 'Learner Reference Number', 'admission_LRN', 'number', true, true);
                                ?>
                            </section>
                        </div>

                        <br>
                        <hr>

                        <h3> Prefered Course </h3> <!--dapat kung anong course lang meron ung campus */-->
                        <br>
                        <h4> Program Name </h4>

                        <section class="enrollment-information-form-section">
                            <select name="enrollment-information-program" required>
                                <option value=""></option>
                                <option <?= optionIsSession('admission_Program', 'BSCE') ?>>Bachelor of Early Childhood Education</option>
                                <option <?= optionIsSession('admission_Program', 'BSE') ?>>Bachelor of Secondary Education</option>
                                <option <?= optionIsSession('admission_Program', 'BSBA') ?>>Bachelor of Science in Business Administration</option>
                                <option <?= optionIsSession('admission_Program', 'BSCS') ?>>Bachelor of Science in Computer Science</option>
                                <option <?= optionIsSession('admission_Program', 'BSHM') ?>>Bachelor of Science in Hospitality Management</option>
                                <option <?= optionIsSession('admission_Program', 'BSIT') ?>>Bachelor of Science in Information Technology</option>
                                <option <?= optionIsSession('admission_Program', 'BSPSY') ?>>Bachelor of Science in Psychology</option>
                                <option <?= optionIsSession('admission_Program', 'BSTM') ?>>Bachelor of Science in Tourism Management</option>
                            </select>

                            <button type="submit" class="primary-button">Save Admission Information</button>
                        </section>
                    </form>
                </div>

                <div class="enrollment-personal-information">
                    <form action="/admission/save_personal_information" method="POST">
                        <div class="enrollment-information-form">
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('firstName', 'First Name', 'admission_FirstName', 'text');
                                echo generateFormField('middleName', 'Middle Name', 'admission_MiddleName', 'text');
                                echo generateFormField('lastName', 'Last Name', 'admission_LastName', 'text');

                                $options = ['JR', 'SR', 'II', 'III', 'IV', 'V'];
                                echo generateSelectField('suffix', 'Suffix', $options, 'admission_Suffix', false);
                                ?>
                            </section>
                            <section class="enrollment-information-form-section">
                                <?php
                                // Region options with corresponding provinces
                                $regions = [
                                    'NCR' => [
                                        'name' => 'NCR - National Capital Region',
                                        'provinces' => [
                                            'Quezon City',
                                            'Manila',
                                            'Makati',
                                            'Caloocan',
                                            'Pasig',
                                            'Taguig',
                                            'Parañaque',
                                            'Las Piñas',
                                            'Mandaluyong',
                                            'Marikina',
                                            'Pasay',
                                            'Malabon',
                                            'Navotas',
                                            'Valenzuela',
                                            'San Juan',
                                            'Muntinlupa'
                                        ]
                                    ],
                                    'CAR' => [
                                        'name' => 'CAR - Cordillera Administrative Region',
                                        'provinces' => ['Abra', 'Apayao', 'Benguet', 'Ifugao', 'Kalinga', 'Mountain Province']
                                    ],
                                    'NIR' => [
                                        'name' => 'NIR - Negros Island Region',
                                        'provinces' => ['Negros Occidental', 'Negros Oriental']
                                    ],
                                    'BARMM' => [
                                        'name' => 'BARMM - Bangsamoro Autonomous Region in Muslim Mindanao',
                                        'provinces' => ['Maguindanao', 'Lanao del Sur', 'Basilan', 'Sulu', 'Tawi-Tawi']
                                    ],
                                    'I' => ['name' => 'I - Ilocos Region', 'provinces' => ['Ilocos Norte', 'Ilocos Sur', 'La Union', 'Pangasinan']],
                                    'II' => ['name' => 'II - Cagayan Valley', 'provinces' => ['Batanes', 'Cagayan', 'Isabela', 'Nueva Vizcaya', 'Quirino']],
                                    'III' => ['name' => 'III - Central Luzon', 'provinces' => ['Aurora', 'Bataan', 'Bulacan', 'Nueva Ecija', 'Pampanga', 'Tarlac', 'Zambales']],
                                    'IV_A' => ['name' => 'IV-A - CALABARZON', 'provinces' => ['Cavite', 'Laguna', 'Batangas', 'Rizal', 'Quezon']],
                                    'IV_B' => ['name' => 'IV-B - MIMAROPA', 'provinces' => ['Mindoro Occidental', 'Mindoro Oriental', 'Marinduque', 'Romblon', 'Palawan']],
                                    'V' => ['name' => 'V - Bicol Region', 'provinces' => ['Albay', 'Camarines Norte', 'Camarines Sur', 'Catanduanes', 'Masbate', 'Sorsogon']],
                                    'VI' => ['name' => 'VI - Western Visayas', 'provinces' => ['Aklan', 'Antique', 'Capiz', 'Iloilo', 'Negros Occidental']],
                                    'VII' => ['name' => 'VII - Central Visayas', 'provinces' => ['Bohol', 'Cebu', 'Negros Oriental', 'Siquijor']],
                                    'VIII' => ['name' => 'VIII - Eastern Visayas', 'provinces' => ['Biliran', 'Eastern Samar', 'Leyte', 'Northern Samar', 'Southern Leyte', 'Western Samar']],
                                    'IX' => ['name' => 'IX - Zamboanga Peninsula', 'provinces' => ['Zamboanga del Norte', 'Zamboanga del Sur', 'Zamboanga Sibugay']],
                                    'X' => ['name' => 'X - Northern Mindanao', 'provinces' => ['Bukidnon', 'Camiguin', 'Lanao del Norte', 'Misamis Occidental', 'Misamis Oriental']],
                                    'XI' => ['name' => 'XI - Davao Region', 'provinces' => ['Davao del Norte', 'Davao del Sur', 'Davao Occidental', 'Davao Oriental', 'Davao de Oro']],
                                    'XII' => ['name' => 'XII - SOCCSKSARGEN', 'provinces' => ['Cotabato', 'Sultan Kudarat', 'South Cotabato', 'Saranggani', 'General Santos City']],
                                ];

                                // Generate the region select field
                                echo generateSelectField('region', 'Region', array_map(fn($region) => $region['name'], $regions), 'admission_Region');

                                // Empty province select field
                                echo generateSelectField('province Empty', 'Province', [], 'admission_Province', false);

                                // Generate province select fields based on regions
                                foreach ($regions as $regionCode => $regionData) {
                                    $fieldHTML = '<div class="enrollment-information-province ';
                                    $fieldHTML .= $regionCode;
                                    $fieldHTML .= '">
                                            <h4>Province</h4> 
                                            <select name="enrollment-information-province">
                                                <option value=""></option>'; // Default empty option

                                    foreach ($regionData['provinces'] as $value => $text) {
                                        $value = (string) $value;
                                        $text = (string) $text;
                                        // Use optionIsSession to determine if this option should be selected
                                        $selected = optionIsSession('admission_Province', $value);
                                        $fieldHTML .= '<option value="' . htmlspecialchars($value) . '" ' . $selected . '>' . htmlspecialchars($text) . '</option>';
                                    }

                                    // Close the select tag
                                    $fieldHTML .= '</select></div>';

                                    // Echo the generated HTML
                                    echo $fieldHTML;
                                }
                                ?>
                            </section>
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('contactNumber', 'Contact Number', 'admission_ContactNumber', 'number', true);
                                echo generateFormField('landlineNumber', 'Landline Number', 'admission_LandlineNumber', 'number', false);

                                $options = ['Single', 'Married', 'Divorced', 'Separated', 'Widowed'];
                                echo generateSelectField('civilStatus', 'Civil Status', $options, 'admission_CivilStatus');

                                $options = ['Male', 'Female'];
                                echo generateSelectField('sex', 'Sex', $options, 'admission_Sex');
                                ?>
                            </section>

                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('birthDate', 'Date of Birth', 'admission_BirthDate', 'date');

                                echo generateFormField('birthPlace', 'Place of Birth', 'admission_BirthPlace', 'text');
                                echo generateFormField('religion', 'Religion', 'admission_Religion', 'text');

                                $options = ['Yes', 'No'];
                                echo generateSelectField('indigenous', 'Are you from an Indigenous Tribe?', $options, 'admission_Indigenous');
                                ?>
                            </section>
                        </div>
                        <button type="submit" class="primary-button">Save Personal Information</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>

<script src="../../../assets/js/enrollment.js"></script>