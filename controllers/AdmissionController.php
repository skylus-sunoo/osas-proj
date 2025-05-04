<?php

require_once 'models/AdmissionModel.php';
require_once 'models/UserModel.php';

class AdmissionController
{
    private $model;
    private $userModel;

    public function __construct()
    {
        $this->model = new AdmissionModel();
        $this->userModel = new UserModel();
    }

    public function logoutUser()
    {
        unset($_SESSION['admission_ID']);
        unset($_SESSION['admission_Branch']);
        $_SESSION['logout'] = 1;
        goToPage('/dashboard/home');
    }

    public function handleEnrollmentRedirect()
    {
        include_once 'views/public/include/header.php';

        if (isset($_POST['enrollment-control-number']) == 'true') {
            $tableMapping = [
                1 => TB_ADMISSION_INFO,
                2 => TB_ADMISSION_PERSONAL,
                3 => TB_ADMISSION_FAMILY,
                4 => TB_ADMISSION_EDUCATION,
                5 => TB_ADMISSION_MEDICAL
            ];

            $incomplete = false;
            foreach ($tableMapping as $key => $value) {
                // Check if the record exists in the table
                $column = ($key === 1) ? 'admission_Entry' : 'admission_ID';
                $id = ($key === 1) ? $_SESSION['admission_Entry'] : $_SESSION['admission_ID'];

                // If the data exists in the table, display the checkmark
                if (!checkForData($value, [[$column, '=', $id]])) {
                    $incomplete = true;
                }
            }

            if ($incomplete) {
                $_SESSION['error'] = 8;
            } else {
                $this->model->createControlNumber($_SESSION['admission_ID']);
            }
        }

        $this->handleErrorMessage();

        if (!isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processLoginOrSignup();
            } else {
                $this->renderLoginView();
            }
            return;
        }

        $this->getControlNumber();

        $this->handleBranchSelection();

        $this->renderEnrollmentView();
    }

    private function getControlNumber()
    {
        if ($this->model->controlNumberExists($_SESSION['admission_ID'])) {
            $_SESSION['admission_ControlNumber'] = $this->model->getControlNumber($_SESSION['admission_ID']);
        }
    }

    private function handleErrorMessage()
    {
        $errorMessages = [
            1 => "The password you entered is incorrect.",
            2 => "An account with this email already exists.",
            3 => "The passwords you entered do not match.",
            4 => "No account found with this email address. Please sign up.",
            5 => "An account with this LRN already exists.",
            6 => "LRN must contain exactly 12 digits.",
            7 => "Please input a valid year with 4 digits.",
            8 => "Application information are not yet completed."
        ];

        if (isset($_SESSION['error']) && isset($errorMessages[$_SESSION['error']])) {
            showAlert($errorMessages[$_SESSION['error']]);
            unset($_SESSION['error']);
        }
    }

    private function processLoginOrSignup()
    {
        $loginEmail = filter_input(INPUT_POST, 'login-email', FILTER_SANITIZE_EMAIL);
        $loginPassword = $_POST['login-password'] ?? null;

        $signupEmail = filter_input(INPUT_POST, 'signup-email', FILTER_SANITIZE_EMAIL);
        $signupPassword = $_POST['signup-password'] ?? null;
        $signupConfirmPassword = $_POST['signup-confirm-password'] ?? null;

        if ($loginEmail) {
            $this->handleLogin($loginEmail, $loginPassword);
        } elseif ($signupEmail) {
            $this->handleSignup($signupEmail, $signupPassword, $signupConfirmPassword);
        }
    }

    private function handleLogin($email, $password)
    {
        if (!$this->userModel->userExists($this->userModel->tableAdmission(), $email)) {
            $_SESSION['error'] = 4;
            goToPage('/admission/enrollment');
            return;
        }

        $hashedPassword = $this->userModel->getUserPassword($this->userModel->tableAdmission(), $email);
        if (!password_verify($password, $hashedPassword)) {
            $_SESSION['error'] = 1;
            goToPage('/admission/enrollment');
            return;
        }

        $_SESSION['admission_ID'] = $this->userModel->getUserID($this->userModel->tableAdmission(), $email);
        $_SESSION['admission_Email'] = $email;
        goToPage('/admission/enrollment');
    }

    private function handleSignup($email, $password, $confirmPassword)
    {
        if ($this->userModel->userExists($this->userModel->tableAdmission(), $email)) {
            $_SESSION['error'] = 2;
            goToPage('/admission/enrollment');
            return;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 3;
            goToPage('/admission/enrollment');
            return;
        }

        $this->userModel->createUser($this->userModel->tableAdmission(), $email, $password);
        $_SESSION['admission_ID'] = $this->userModel->getUserID($this->userModel->tableAdmission(), $email);
        $_SESSION['admission_Email'] = $email;
        goToPage('/admission/enrollment');
    }

    private function handleBranchSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['branch'])) {
                $_SESSION['admission_Branch'] = $_POST['branch'];
                $this->model->updateUserBranch($_SESSION['admission_Branch'], $_SESSION['admission_ID']);
            } elseif (isset($_POST['branchReset'])) {
                unset($_SESSION['admission_Branch']);
                $this->model->deleteUserBranch($_SESSION['admission_ID']);
            }
        }

        if ($this->model->userBranchExists($_SESSION['admission_ID']) && !isset($_POST['branchReset'])) {
            $_SESSION['admission_Branch'] = $this->model->getUserBranch($_SESSION['admission_ID']);
        }
    }

    private function renderLoginView()
    {
        include_once 'views/public/admission/login.php';
    }

    private function renderEnrollmentView()
    {
        if (isset($_SESSION['admission_Branch'])) {
            $admissionInfoRaw = $this->model->getAdmissionInformation($_SESSION['admission_ID']);
            $admissionInfo = $admissionInfoRaw[0] ?? [];

            $_SESSION['admission_Entry'] = $admissionInfo['admission_Entry'] ?? null;
            $_SESSION['admission_TypeApplicant'] = $admissionInfo['admission_TypeApplicant'] ?? null;
            $_SESSION['admission_Strand'] = $admissionInfo['admission_Strand'] ?? null;
            $_SESSION['admission_TypeStudent'] = $admissionInfo['admission_TypeStudent'] ?? null;
            $_SESSION['admission_LRN'] = $admissionInfo['admission_LRN'] ?? null;
            $_SESSION['admission_Program'] = $admissionInfo['admission_Program'] ?? null;
            // preformat($admissionInfo);
            // echo $_SESSION['admission_Entry'];


            $personalInfoRaw = $this->model->getPersonalInformation($_SESSION['admission_ID']);
            $personalInfo = $personalInfoRaw[0] ?? [];

            $_SESSION['admission_FirstName'] = $personalInfo['admission_FirstName'] ?? null;
            $_SESSION['admission_MiddleName'] = $personalInfo['admission_MiddleName'] ?? null;
            $_SESSION['admission_LastName'] = $personalInfo['admission_LastName'] ?? null;
            $_SESSION['admission_Suffix'] = $personalInfo['admission_Suffix'] ?? null;
            $_SESSION['admission_Region'] = $personalInfo['admission_Region'] ?? null;
            $_SESSION['admission_Province'] = $personalInfo['admission_Province'] ?? null;
            $_SESSION['admission_ContactNumber'] = isset($personalInfo['admission_ContactNumber']) ? str_pad($personalInfo['admission_ContactNumber'], 11, '0', STR_PAD_LEFT) : '';
            $_SESSION['admission_LandlineNumber'] = $personalInfo['admission_LandlineNumber'] ?? null;
            $_SESSION['admission_CivilStatus'] = $personalInfo['admission_CivilStatus'] ?? null;
            $_SESSION['admission_Sex'] = $personalInfo['admission_Sex'] ?? null;
            $_SESSION['admission_BirthDate'] = $personalInfo['admission_BirthDate'] ?? null;
            $_SESSION['admission_BirthPlace'] = $personalInfo['admission_BirthPlace'] ?? null;
            $_SESSION['admission_Religion'] = $personalInfo['admission_Religion'] ?? null;
            $_SESSION['admission_Indigenous'] = $personalInfo['admission_Indigenous'] ?? null;


            $familyInfoRaw = $this->model->getFamilyInformation($_SESSION['admission_ID']);
            $familyInfo = $familyInfoRaw[0] ?? [];

            $_SESSION['admission_FatherName'] = $familyInfo['admission_FatherName'] ?? null;
            $_SESSION['admission_FatherNumber'] = isset($familyInfo['admission_FatherNumber']) ? str_pad($familyInfo['admission_FatherNumber'], 11, '0', STR_PAD_LEFT) : '';
            $_SESSION['admission_FatherOccupation'] = $familyInfo['admission_FatherOccupation'] ?? null;
            $_SESSION['admission_MotherName'] = $familyInfo['admission_MotherName'] ?? null;
            $_SESSION['admission_MotherNumber'] = isset($familyInfo['admission_MotherNumber']) ? str_pad($familyInfo['admission_MotherNumber'], 11, '0', STR_PAD_LEFT) : '';
            $_SESSION['admission_MotherOccupation'] = $familyInfo['admission_MotherOccupation'] ?? null;
            $_SESSION['admission_Income'] = $familyInfo['admission_Income'] ?? null;
            $_SESSION['admission_Siblings'] = $familyInfo['admission_Siblings'] ?? null;
            $_SESSION['admission_BirthOrder'] = $familyInfo['admission_BirthOrder'] ?? null;
            $_SESSION['admission_GuardianName'] = $familyInfo['admission_GuardianName'] ?? null;
            $_SESSION['admission_GuardianNumber'] = isset($familyInfo['admission_GuardianNumber']) ? str_pad($familyInfo['admission_GuardianNumber'], 11, '0', STR_PAD_LEFT) : '';
            $_SESSION['admission_GuardianOccupation'] = $familyInfo['admission_GuardianOccupation'] ?? null;


            $educationInfoRaw = $this->model->getEducationInformation($_SESSION['admission_ID']);
            $educationInfo = $educationInfoRaw[0] ?? [];

            $_SESSION['admission_ElementaryName'] = $educationInfo['admission_ElementaryName'] ?? null;
            $_SESSION['admission_ElementaryAddress'] = $educationInfo['admission_ElementaryAddress'] ?? null;
            $_SESSION['admission_ElementaryYear'] = $educationInfo['admission_ElementaryYear'] ?? null;
            $_SESSION['admission_ElementaryType'] = $educationInfo['admission_ElementaryType'] ?? null;
            $_SESSION['admission_HighschoolName'] = $educationInfo['admission_HighschoolName'] ?? null;
            $_SESSION['admission_HighschoolAddress'] = $educationInfo['admission_HighschoolAddress'] ?? null;
            $_SESSION['admission_HighschoolYear'] = $educationInfo['admission_HighschoolYear'] ?? null;
            $_SESSION['admission_HighschoolType'] = $educationInfo['admission_HighschoolType'] ?? null;
            $_SESSION['admission_SeniorName'] = $educationInfo['admission_SeniorName'] ?? null;
            $_SESSION['admission_SeniorAddress'] = $educationInfo['admission_SeniorAddress'] ?? null;
            $_SESSION['admission_SeniorYear'] = $educationInfo['admission_SeniorYear'] ?? null;
            $_SESSION['admission_SeniorType'] = $educationInfo['admission_SeniorType'] ?? null;
            $_SESSION['admission_VocationalName'] = $educationInfo['admission_VocationalName'] ?? null;
            $_SESSION['admission_VocationalAddress'] = $educationInfo['admission_VocationalAddress'] ?? null;
            $_SESSION['admission_VocationalYear'] = $educationInfo['admission_VocationalYear'] ?? null;
            $_SESSION['admission_VocationalType'] = $educationInfo['admission_VocationalType'] ?? null;


            $medicalInfoRaw = $this->model->getmedicalInformation($_SESSION['admission_ID']);
            $medicalInfo = $medicalInfoRaw[0] ?? [];

            $_SESSION['admission_Medication'] = $medicalInfo['admission_Medication'] ?? null;
            $_SESSION['admission_Allergy'] = $medicalInfo['admission_Allergy'] ?? null;
            $_SESSION['admission_Scoliosis'] = $medicalInfo['admission_Scoliosis'] ?? null;
            $_SESSION['admission_Asthma'] = $medicalInfo['admission_Asthma'] ?? null;
            $_SESSION['admission_Hypertension'] = $medicalInfo['admission_Hypertension'] ?? null;
            $_SESSION['admission_Diabetes'] = $medicalInfo['admission_Diabetes'] ?? null;
            $_SESSION['admission_Insomnia'] = $medicalInfo['admission_Insomnia'] ?? null;
            $_SESSION['admission_Vertigo'] = $medicalInfo['admission_Vertigo'] ?? null;
            $_SESSION['admission_Others'] = $medicalInfo['admission_Others'] ?? null;
            $_SESSION['admission_PWD'] = $medicalInfo['admission_PWD'] ?? null;

            $_SESSION['admission_ControlNumber'] = $this->model->getControlNumber($_SESSION['admission_ID']);

            if ($_SESSION['admission_ControlNumber'] == 0) {
                $_SESSION['admission_ControlNumber'] = null;
            }
            // if($this->model->hasAppointment($_SESSION['admission_ID'])){
            $_SESSION['admission_Appointment'] = $this->model->getAppointment($_SESSION['admission_ID']);
            // }
            // if($this->model->hasExam($_SESSION['admission_ID'])){
            $_SESSION['admission_Exam'] = $this->model->getExam($_SESSION['admission_ID']);
            // }
            // if($this->model->hasResult($_SESSION['admission_ID'])){
            $_SESSION['admission_Result'] = $this->model->getResult($_SESSION['admission_ID']);
            // }

            include_once 'views/public/admission/enrollment_information.php';
        } else {
            include_once 'views/public/admission/enrollment_branch.php';
        }
    }

    public function saveAdmissionInformation()
    {
        $data = [
            'admission_Entry' => $_POST['enrollment-information-entry'],
            'admission_TypeApplicant' => $_POST['enrollment-information-typeApplicant'],
            'admission_Strand' => $_POST['enrollment-information-strand'] ?? null,
            'admission_TypeStudent' => $_POST['enrollment-information-typeStudent'] ?? null,
            'admission_LRN' => $_POST['enrollment-information-LRN'] ?? null,
            'admission_Program' => $_POST['enrollment-information-program'],
        ];

        normalizeData($data);

        if ($this->model->userLRNExists($data['admission_LRN'], $_SESSION['admission_ID'])) {
            $_SESSION['error'] = 5;
            goToPage('/admission/enrollment');
            return;
        }

        if (!preg_match('/^\d{12}$/', $data['admission_LRN']) && $data['admission_LRN'] != null) {
            $_SESSION['error'] = 6;
            goToPage('/admission/enrollment');
            return;
        }

        $this->model->updateAdmissionInformation($data, $_SESSION['admission_ID']);

        goToPage('/admission/enrollment');
    }

    public function savePersonalInformation()
    {
        $data = [
            'admission_ID' => $_SESSION['admission_ID'],
            'admission_FirstName' => $_POST['enrollment-information-firstName'],
            'admission_MiddleName' => $_POST['enrollment-information-middleName'] ?? null,
            'admission_LastName' => $_POST['enrollment-information-lastName'],
            'admission_Suffix' => $_POST['enrollment-information-suffix'] ?? null,
            'admission_Region' => $_POST['enrollment-information-region'],
            'admission_Province' => $_POST['enrollment-information-province'],
            'admission_ContactNumber' => $_POST['enrollment-information-contactNumber'],
            'admission_LandlineNumber' => $_POST['enrollment-information-landlineNumber'] ?? null,
            'admission_CivilStatus' => $_POST['enrollment-information-civilStatus'],
            'admission_Sex' => $_POST['enrollment-information-sex'],
            'admission_BirthDate' => $_POST['enrollment-information-birthDate'],
            'admission_BirthPlace' => $_POST['enrollment-information-birthPlace'],
            'admission_Religion' => $_POST['enrollment-information-religion'] ?? null,
            'admission_Indigenous' => $_POST['enrollment-information-indigenous'],
        ];

        normalizeData($data);

        if ($this->model->userPersonalInfoExists($_SESSION['admission_ID'])) {
            $this->model->updatePersonalInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        } else {
            $this->model->createPersonalInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        }
    }

    public function saveFamilyInformation()
    {
        $data = [
            'admission_ID' => $_SESSION['admission_ID'],
            'admission_FatherName' => $_POST['enrollment-information-fatherName'] ?? null,
            'admission_FatherNumber' => $_POST['enrollment-information-fatherNumber'] ?? null,
            'admission_FatherOccupation' => $_POST['enrollment-information-fatherOccupation'] ?? null,
            'admission_MotherName' => $_POST['enrollment-information-motherName'] ?? null,
            'admission_MotherNumber' => $_POST['enrollment-information-motherNumber'] ?? null,
            'admission_MotherOccupation' => $_POST['enrollment-information-motherOccupation'] ?? null,
            'admission_Income' => $_POST['enrollment-information-income'],
            'admission_Siblings' => $_POST['enrollment-information-siblings'] ?? null,
            'admission_BirthOrder' => $_POST['enrollment-information-birthOrder'] ?? null,
            'admission_GuardianName' => $_POST['enrollment-information-guardianName'],
            'admission_GuardianNumber' => $_POST['enrollment-information-guardianNumber'],
            'admission_GuardianOccupation' => $_POST['enrollment-information-guardianOccupation'],
        ];

        normalizeData($data);

        if ($data['admission_Siblings'] == null) {
            $data['admission_BirthOrder'] = null;
        }

        if ($this->model->userFamilyInfoExists($_SESSION['admission_ID'])) {
            $this->model->updateFamilyInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        } else {
            $this->model->createFamilyInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        }
    }

    public function saveEducationInformation()
    {
        $data = [
            'admission_ID' => $_SESSION['admission_ID'],
            'admission_ElementaryName' => $_POST['enrollment-information-elementaryName'],
            'admission_ElementaryAddress' => $_POST['enrollment-information-elementaryAddress'],
            'admission_ElementaryYear' => $_POST['enrollment-information-elementaryYear'],
            'admission_ElementaryType' => $_POST['enrollment-information-elementaryType'],
            'admission_HighschoolName' => $_POST['enrollment-information-highschoolName'],
            'admission_HighschoolAddress' => $_POST['enrollment-information-highschoolAddress'],
            'admission_HighschoolYear' => $_POST['enrollment-information-highschoolYear'],
            'admission_HighschoolType' => $_POST['enrollment-information-highschoolType'],
            'admission_SeniorName' => $_POST['enrollment-information-seniorName'] ?? null,
            'admission_SeniorAddress' => $_POST['enrollment-information-seniorAddress'] ?? null,
            'admission_SeniorYear' => $_POST['enrollment-information-seniorYear'] ?? null,
            'admission_SeniorType' => $_POST['enrollment-information-seniorType'] ?? null,
            'admission_VocationalName' => $_POST['enrollment-information-vocationalName'] ?? null,
            'admission_VocationalAddress' => $_POST['enrollment-information-vocationalAddress'] ?? null,
            'admission_VocationalYear' => $_POST['enrollment-information-vocationalYear'] ?? null,
            'admission_VocationalType' => $_POST['enrollment-information-vocationalType'] ?? null
        ];

        normalizeData($data);

        if (!preg_match('/^\d{4}$/', $data['admission_ElementaryYear'])) {
            $_SESSION['error'] = 6;
            goToPage('/admission/enrollment');
            return;
        }

        if ($this->model->userEducationInfoExists($_SESSION['admission_ID'])) {
            $this->model->updateEducationInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        } else {
            $this->model->createEducationInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        }
    }

    public function saveMedicalInformation()
    {
        $data = [
            'admission_ID' => $_SESSION['admission_ID'],
            'admission_Medication' => $_POST['enrollment-information-medication'] ?? null,
            'admission_Allergy' => $_POST['enrollment-information-allergy'] ?? null,
            'admission_Scoliosis' => $_POST['enrollment-information-scoliosis'] ?? null,
            'admission_Asthma' => $_POST['enrollment-information-asthma'] ?? null,
            'admission_Hypertension' => $_POST['enrollment-information-hypertension'] ?? null,
            'admission_Diabetes' => $_POST['enrollment-information-diabetes'] ?? null,
            'admission_Insomnia' => $_POST['enrollment-information-insomnia'] ?? null,
            'admission_Vertigo' => $_POST['enrollment-information-vertigo'] ?? null,
            'admission_Others' => $_POST['enrollment-information-others'] ?? null,
            'admission_PWD' => $_POST['enrollment-information-PWD']
        ];

        normalizeData($data);

        if ($this->model->userMedicalInfoExists($_SESSION['admission_ID'])) {
            $this->model->updateMedicalInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        } else {
            $this->model->createMedicalInformation($data, $_SESSION['admission_ID']);
            goToPage('/admission/enrollment');
        }
    }

    /**
     * Generates a 'select' element where the options are a list of dates, both AM and PM included.
     * 
     * @param int|string $input       Int is for the number of valid days. String (YYYY-MM-DD) is for the end date.
     * @param bool       $includeSundays Whether to include Sundays or skip them.
     * @param string     $start       Start date as a string (e.g., 'tomorrow', '2024-06-01').
     * @return string     HTML 'select' element.
     */
    public function generateAppointmentSelect($input, $includeSundays = false, $start = 'tomorrow')
    {
        $options = [];

        try {
            $startDate = new DateTime($start);
        } catch (Exception $e) {
            // Fallback to tomorrow if invalid start date
            $startDate = new DateTime('tomorrow');
        }

        // Case 1: Integer input — number of valid days (excluding Sundays if needed)
        if (is_int($input)) {
            $validDaysCount = 0;
            while ($validDaysCount < $input) {
                $dayOfWeek = $startDate->format('w');
                if ($includeSundays || $dayOfWeek != 0) {
                    $formattedDate = $startDate->format('F j, Y');
                    $options[] = "<option value='{$formattedDate} AM'>{$formattedDate} AM</option>";
                    $options[] = "<option value='{$formattedDate} PM'>{$formattedDate} PM</option>";
                    $validDaysCount++;
                }
                $startDate->modify('+1 day');
            }
        }
        // Case 2: String input — treat as an end date
        elseif (is_string($input)) {
            try {
                $endDate = new DateTime($input);
            } catch (Exception $e) {
                return '<select name="enrollment-information-appointment" id="enrollment-information-appointment"></select>'; // Return empty if end date is invalid
            }

            while ($startDate <= $endDate) {
                $dayOfWeek = $startDate->format('w');
                if ($includeSundays || $dayOfWeek != 0) {
                    $formattedDate = $startDate->format('F j, Y');
                    $options[] = "<option value='{$formattedDate} AM'>{$formattedDate} AM</option>";
                    $options[] = "<option value='{$formattedDate} PM'>{$formattedDate} PM</option>";
                }
                $startDate->modify('+1 day');
            }
        }

        return '<select name="enrollment-information-appointment" id="enrollment-information-appointment">' . implode("\n", $options) . '</select>';
    }

    public function setAppointment()
    {
        $this->model->updateAppointment($_SESSION['admission_ID'], $_POST['enrollment-information-appointment-confirm']);
        goToPage('/admission/enrollment');
    }

    public function hasAppointment()
    {
        return $this->model->hasAppointment($_SESSION['admission_ID']);
    }

    public function renderSubmissionSchedule()
    {
        echo '<input disabled type="text" style="cursor: not-allowed; "value="' . $this->model->getAppointment($_SESSION['admission_ID']) . '">';
    }
}

//     public function handleCourse()
//     {
//         include_once 'views/public/include/header.php';
//         include_once 'views/public/admission/course.php';
//     }
// }
// Compare this snippet from views/public/admission/login.php: