<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="../../../assets/css/public_enrollment.css">
</head>

<body class="public-body">
    <main class="public-main">
        <header class="public-header">
            <h2>ENROLLMENT</h2>
            <h4><i>ADMISSION >> ENROLLMENT FORM</i></h4>
            <hr>
        </header>

        <?php include_once 'enrollment_milestones.php' ?>
        <!-- <?= preformat($_SESSION) ?> -->

        <div class="enrollment-information">
            <?php include_once 'enrollment_aside.php' ?>

            <section class="enrollment-information-section <?= isset($_SESSION['admission_ControlNumber']) ? 'enrollment-information-disabled' : '' ?>">
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
                            <!-- <?php preformat($_SESSION) ?> -->
                            <section class="enrollment-information-form-section">

                                <div>
                                    <h4>* SHS Strand </h4>
                                    <select name="enrollment-information-strand" id="strand" required="required" style="height: 60%">
                                        <option value=""></option>
                                        <option <?= optionIsSession('admission_Strand', 'STEM') ?>>STEM</option>
                                        <option <?= optionIsSession('admission_Strand', 'HUMSS') ?>>HUMSS</option>
                                        <option <?= optionIsSession('admission_Strand', 'ABM') ?>>ABM</option>
                                        <option <?= optionIsSession('admission_Strand', 'GAS') ?>>GAS</option>
                                        <option <?= optionIsSession('admission_Strand', 'TVL-ICT') ?>>TVL-ICT</option>
                                        <option <?= optionIsSession('admission_Strand', 'TVL-HE') ?>>TVL-HE</option>
                                    </select>
                                </div>

                                <?php
                                // $options = [
                                //     'STEM',
                                //     'HUMSS',
                                //     'ABM',
                                //     'GAS',
                                //     'TVL-ICT',
                                //     'TVL-HE'
                                // ];
                                // echo generateSelectFieldEntryNew('strand', 'SHS Strand', $options, 'admission_Strand', true);

                                $options = [
                                    'GR12' => 'Grade 12 Student',
                                    'SHS' => 'SHS Graduate',
                                    'ALS' => 'ALS Passer',
                                    'DEGREE' => 'Associate Certificate, Vocational, or Diploma Degree Holder'
                                ];
                                if (isset($_SESSION['admission_ControlNumber'])) {
                                    echo generateSelectFieldEntryNew('typeStudenta', 'Type of New Student', $options, 'admission_TypeStudent', true);
                                } else {
                                    echo generateSelectFieldEntryNew('typeStudent', 'Type of New Student', $options, 'admission_TypeStudent', true);
                                }

                                echo generateFormFieldEntryNew('LRN', 'Learner Reference Number (12 digits)', 'admission_LRN', 'number', true);
                                ?>
                            </section>
                        </div>

                        <br>
                        <hr>

                        <h3> Preferred Course </h3> <!--dapat kung anong course lang meron ung campus */-->
                        <br>
                        <h4>* Program Name </h4>

                        <section class="enrollment-information-form-section">

                            <!-- Program Selection -->
                            <select name="enrollment-information-program" id="program" required="required" style="width: 80%">
                                <!-- Program Options generated with PHP, all options are in the HTML from the start -->
                                <option value=""></option>

                                <!-- These are the program options with PHP embedded -->
                                <option <?= optionIsSession('admission_Program', 'BSCS') ?> class="STEM TVL-ICT">Bachelor of Science in Computer Science</option>
                                <option <?= optionIsSession('admission_Program', 'BSIT') ?> class="STEM TVL-ICT">Bachelor of Science in Information Technology</option>
                                <option <?= optionIsSession('admission_Program', 'BSCE') ?> class="STEM HUMSS GAS">Bachelor of Early Childhood Education</option>
                                <option <?= optionIsSession('admission_Program', 'BSE') ?> class="STEM HUMSS GAS ">Bachelor of Secondary Education Major in English</option>
                                <option <?= optionIsSession('admission_Program', 'BSE') ?> class="STEM HUMSS GAS">Bachelor of Secondary Education Major in Mathematics</option>
                                <option <?= optionIsSession('admission_Program', 'BSE') ?> class="STEM HUMSS GAS">Bachelor of Secondary Education Major in Science</option>
                                <option <?= optionIsSession('admission_Program', 'BSBA') ?> class="STEM ABM GAS">Bachelor of Science in Business Administration Major in Finance</option>
                                <option <?= optionIsSession('admission_Program', 'BSBA') ?> class="STEM ABM GAS">Bachelor of Science in Business Administration Major in Marketing Management</option>
                                <option <?= optionIsSession('admission_Program', 'BSBA') ?> class="STEM ABM GAS ">Bachelor of Science in Business Administration Major in Human Resource Management</option>
                                <option <?= optionIsSession('admission_Program', 'BSHM') ?> class="STEM HUMSS ABM TVL-HE TVL-ICT GAS">Bachelor of Science in Hospitality Management</option>
                                <option <?= optionIsSession('admission_Program', 'BSTM') ?> class="STEM HUMSS ABM TVL-HE TVL-ICT GAS">Bachelor of Science in Tourism Management</option>
                                <option <?= optionIsSession('admission_Program', 'BSPSY') ?> class="STEM HUMSS GAS">Bachelor of Science in Psychology</option>
                            </select>

                            <button type="submit" class="primary-button">Save Admission Information</button>
                        </section>

                        <script>
                            // JavaScript to filter program options based on strand selection
                            document.getElementById('strand').addEventListener('change', function() {
                                var strand = this.value;
                                var programSelect = document.getElementById('program');
                                var options = programSelect.querySelectorAll('option');

                                // If no strand is selected (empty value), hide all program options
                                if (!strand) {
                                    options.forEach(function(option) {
                                        option.style.display = 'none'; // Hide all options
                                    });
                                } else {
                                    // Show all options first
                                    options.forEach(function(option) {
                                        option.style.display = 'block'; // Default: show
                                    });

                                    // If a strand is selected, hide the options that do not belong to that strand
                                    options.forEach(function(option) {
                                        if (!option.classList.contains(strand)) {
                                            option.style.display = 'none'; // Hide options that don't match the strand
                                        }
                                    });
                                }
                            });

                            // Initially hide options based on selected strand (if any)
                            document.addEventListener('DOMContentLoaded', function() {
                                var strand = document.getElementById('strand').value;
                                if (strand) {
                                    document.getElementById('strand').dispatchEvent(new Event('change')); // Trigger change handler
                                } else {
                                    // If the strand is empty on page load, hide all program options
                                    var programSelect = document.getElementById('program');
                                    var options = programSelect.querySelectorAll('option');
                                    options.forEach(function(option) {
                                        option.style.display = 'none'; // Hide all options
                                    });
                                }
                            });
                        </script>
                    </form>
                </div>

                <div class="enrollment-personal-information">
                    <form action="/admission/save_personal_information" method="POST">
                        <div class="enrollment-information-form">
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('firstName', 'First Name', 'admission_FirstName', 'text');
                                echo generateFormField('middleName', 'Middle Name', 'admission_MiddleName', 'text', false);
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

                                ?>

                                <div class="enrollment-information-region">
                                    <h4>* Region</h4>
                                    <select id="region" name="enrollment-information-region" class="admission_Region" required>
                                        <option value=""></option>
                                        <?php foreach ($regions as $regionCode => $regionData): ?>
                                            <option <?= optionIsSession('admission_Region', $regionCode) ?>><?= htmlspecialchars($regionData['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="enrollment-information-province">
                                    <h4>* Province</h4>
                                    <!-- Province Select (initially empty) -->
                                    <select id="province" name="enrollment-information-province" class="admission_Province" required>
                                        <option value=""></option>
                                        <?php
                                        if (isset($regions[$_SESSION['admission_Region']])) {
                                            $selectedRegion = $_SESSION['admission_Region'];
                                            $provinces = $regions[$selectedRegion]['provinces'];
                                            foreach ($provinces as $province): ?>
                                                <option <?= optionIsSession('admission_Province', $province) ?>><?= htmlspecialchars($province) ?></option>
                                        <?php endforeach;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <script>
                                    // Data for regions and their corresponding provinces
                                    var regionsData = <?php echo json_encode($regions); ?>;

                                    // Function to update the provinces based on the selected region
                                    document.getElementById('region').addEventListener('change', function() {
                                        var regionCode = this.value;
                                        var provinceSelect = document.getElementById('province');

                                        // Reset the provinces select
                                        provinceSelect.innerHTML = '<option value=""></option>';

                                        if (regionCode) {
                                            var provinces = regionsData[regionCode].provinces;

                                            // Add the provinces to the select element
                                            provinces.forEach(function(province) {
                                                var option = document.createElement('option');
                                                option.value = province;
                                                option.textContent = province;

                                                // Check if the current province is selected from the session
                                                <?php if (isset($_SESSION['admission_Province'])): ?>
                                                    if (province === "<?php echo $_SESSION['admission_Province']; ?>") {
                                                        option.selected = true;
                                                    }
                                                <?php endif; ?>

                                                provinceSelect.appendChild(option);
                                            });
                                        }
                                    });

                                    // Trigger change event on page load to populate provinces correctly if a region is selected
                                    window.addEventListener('load', function() {
                                        var regionCode = document.getElementById('region').value;
                                        if (regionCode) {
                                            document.getElementById('region').dispatchEvent(new Event('change'));
                                        }
                                    });
                                </script>
                            </section>
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('contactNumber', 'Contact Number (0XXXYYYZZZZ)', 'admission_ContactNumber', 'number', true);
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
                                echo generateFormField('religion', 'Religion', 'admission_Religion', 'text', false);

                                $options = ['Yes', 'No'];
                                echo generateSelectField('indigenous', 'Are you from an Indigenous Tribe?', $options, 'admission_Indigenous');
                                ?>
                            </section>
                        </div>
                        <button type="submit" class="primary-button">Save Personal Information</button>
                    </form>
                </div>

                <div class="enrollment-family-information">
                    <form action="/admission/save_family_information" method="POST">
                        <div class="enrollment-information-form">
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('fatherName', 'Father\'s name', 'admission_FatherName', 'text', false);
                                echo generateFormField('fatherNumber', 'Contact Number', 'admission_FatherNumber', 'number', false);
                                echo generateFormField('fatherOccupation', 'Occupation', 'admission_FatherOccupation', 'text', false);
                                ?>
                            </section>
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('motherName', 'Mother\'s name', 'admission_MotherName', 'text', false);
                                echo generateFormField('motherNumber', 'Contact Number', 'admission_MotherNumber', 'number  ', false);
                                echo generateFormField('motherOccupation', 'Occupation', 'admission_MotherOccupation', 'text', false);
                                ?>
                            </section>
                            <hr>
                            <section class="enrollment-information-form-section">
                                <?php
                                $options = [
                                    'below 10,000',
                                    '11,000-20,000',
                                    '21,000-30,000',
                                    '31,000-40,000',
                                    '41,000-50,000',
                                    'above 50,000'
                                ];
                                echo generateSelectField('income', 'Estimate Monthly Family Income', $options, 'admission_Income');

                                echo generateFormField('siblings', 'Number of Siblings', 'admission_Siblings', 'number', false);

                                $options = [
                                    'Eldest',
                                    'Middle',
                                    'Youngest'
                                ];
                                echo generateSelectField('birthOrder', 'Birth Order', $options, 'admission_BirthOrder', false);
                                ?>
                            </section>
                            <hr>
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('guardianName', 'Guardian\'s name', 'admission_GuardianName', 'text');
                                echo generateFormField('guardianNumber', 'Contact Number', 'admission_GuardianNumber', 'text');
                                echo generateFormField('guardianOccupation', 'Occupation', 'admission_GuardianOccupation', 'text');
                                ?>
                            </section>
                        </div>
                        <button type="submit" class="primary-button">Save Family Background</button>
                    </form>
                </div>

                <div class="enrollment-education-information">
                    <form action="/admission/save_education_information" method="POST">
                        <div class="enrollment-information-form">
                            <div>
                                <h4 class="enrollment-education-level">Elementary</h4>
                                <section class="enrollment-information-form-section">
                                    <?php
                                    echo generateFormField('elementaryName', 'School Name', 'admission_ElementaryName', 'text');
                                    echo generateFormField('elementaryAddress', 'School Address', 'admission_ElementaryAddress', 'text');
                                    echo generateFormField('elementaryYear', 'Year Graduated (4 Digits)', 'admission_ElementaryYear', 'number');
                                    $options = [
                                        'Public',
                                        'Private'
                                    ];
                                    echo generateSelectField('elementaryType', 'Type', $options, 'admission_ElementaryType');
                                    ?>
                                </section>
                            </div>
                            <div>
                                <h4 class="enrollment-education-level">High School</h4>
                                <section class="enrollment-information-form-section">
                                    <?php
                                    echo generateFormField('highschoolName', 'School Name', 'admission_HighschoolName', 'text');
                                    echo generateFormField('highschoolAddress', 'School Address', 'admission_HighschoolAddress', 'text');
                                    echo generateFormField('highschoolYear', 'Year Graduated (4 Digits)', 'admission_HighschoolYear', 'number');
                                    echo generateSelectField('highschoolType', 'Type', $options, 'admission_HighschoolType');
                                    ?>
                                </section>
                            </div>
                            <hr>
                            <div>
                                <h4 class="enrollment-education-level">Senior High School</h4>
                                <section class="enrollment-information-form-section">
                                    <?php
                                    echo generateFormField('seniorName', 'School Name', 'admission_SeniorName', 'text', false);
                                    echo generateFormField('seniorAddress', 'School Address', 'admission_SeniorAddress', 'text', false);
                                    echo generateFormField('seniorYear', 'Year Graduated (4 Digits)', 'admission_SeniorYear', 'number', false);
                                    echo generateSelectField('seniorType', 'Type', $options, 'admission_SeniorType', false);
                                    ?>
                                </section>
                            </div>
                            <hr>
                            <div>
                                <h4 class="enrollment-education-level">Vocational</h4>
                                <section class="enrollment-information-form-section">
                                    <?php
                                    echo generateFormField('vocationalName', 'School Name', 'admission_VocationalName', 'text', false);
                                    echo generateFormField('vocationalAddress', 'School Address', 'admission_VocationalAddress', 'text', false);
                                    echo generateFormField('vocationalYear', 'Year Graduated (4 Digits)', 'admission_VocationalYear', 'number', false);
                                    echo generateSelectField('vocationalType', 'Type', $options, 'admission_VocationalType', false);
                                    ?>
                                </section>
                            </div>
                        </div>
                        <button type="submit" class="primary-button">Save Educational History</button>
                    </form>
                </div>

                <div class="enrollment-medical-information">
                    <form action="/admission/save_medical_information" method="POST">
                        <div class="enrollment-information-form">
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateFormField('medication', 'List any medications you are taking:', 'admission_Medication', 'text', false);
                                ?>
                            </section>
                            <div>
                                <h4 class="enrollment-medical-note">Do you have any of the following? Kindly put a check.</h4>
                                <section class="enrollment-medical-list">
                                    <?php
                                    echo generateCheckField('allergy', 'Allergy', 'admission_Allergy');
                                    echo generateCheckField('scoliosis', 'Scoliosis', 'admission_Scoliosis');
                                    echo generateCheckField('asthma', 'Asthma', 'admission_Asthma');
                                    echo generateCheckField('hypertension', 'Hypertension', 'admission_Hypertension');
                                    echo generateCheckField('diabetes', 'Diabetes', 'admission_Diabetes');
                                    echo generateCheckField('insomnia', 'Insomnia', 'admission_Insomnia');
                                    echo generateCheckField('vertigo', 'Vertigo', 'admission_Vertigo');
                                    echo generateFormField('others', 'Others', 'admission_Others', 'text', false);
                                    ?>
                                </section>
                            </div>
                            <section class="enrollment-information-form-section">
                                <?php
                                echo generateSelectField('PWD', 'Are you a PWD?', ['Yes', 'No'], 'admission_PWD', true);
                                ?>
                            </section>
                        </div>
                        <button type="submit" class="primary-button">Save Medical Background</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
</body>

</html>

<script src="../../../assets/js/enrollment.js"></script>

<script>
    //#region Enrollment Sidebar
    // Select all button elements inside the "enrollment-information-aside"
    const buttons = document.querySelectorAll('.enrollment-information-aside button');

    const targetDivs = [
        document.querySelector('.enrollment-admission-information'),
        document.querySelector('.enrollment-personal-information'),
        document.querySelector('.enrollment-family-information'),
        document.querySelector('.enrollment-education-information'),
        document.querySelector('.enrollment-medical-information')
    ];

    // console.log(targetDivs);

    // Function to handle button selection
    function handleButtonClick(button) {
        const selectedStep = button.getAttribute('data-step');

        // Show/hide target divs
        targetDivs.forEach(div => {
            div.style.display = div.classList.contains(selectedStep) ? 'block' : 'none';
        });

        // Update button colors
        buttons.forEach(btn => {
            const h1 = btn.querySelector('h1');
            if (h1) { // Check if h1 exists
                if (btn === button) {
                    h1.style.color = 'var(--primary-hex-yellow)';
                } else {
                    h1.style.color = 'white';
                }
            }
        });
    }

    // Attach click event to each button
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            handleButtonClick(this);
        });
    });

    // Check if any div in targetDivs has the class .aside-selected
    let selectedDiv = targetDivs.find(div => div.classList.contains('aside-selected'));
    // If no div has .aside-selected, set the first div in the array to have it
    if (!selectedDiv) {
        selectedDiv = targetDivs[0]; // Choose the first div as selected
        selectedDiv.classList.add('aside-selected');

        // Now, update the corresponding button based on selectedDiv
        const selectedStep = selectedDiv.classList[0]; // Assuming the div's first class is the step name
        const selectedButton = document.querySelector(`button[data-step="${selectedStep}"]`);
        selectedButton.classList.add('aside-selected');
    }
    var selectedButton = document.querySelector(`.aside-selected`);

    const enrollmentPage = <?php echo json_encode($_SESSION['enrollmentPage']); ?>;
    switch (enrollmentPage) {
        case '2':
            selectedButton = document.querySelector(`button[data-step="enrollment-personal-information"]`);
            break;
        case '3':
            selectedButton = document.querySelector(`button[data-step="enrollment-family-information"]`);
            break;
        case '4':
            selectedButton = document.querySelector(`button[data-step="enrollment-education-information"]`);
            break;
        case '5':
            selectedButton = document.querySelector(`button[data-step="enrollment-medical-information"]`);
            break;
        default:
            selectedButton = document.querySelector(`button[data-step="enrollment-admission-information"]`);
            break;
    }

    if (selectedButton) {
        handleButtonClick(selectedButton);
    }
    //#endregion
</script>