<?php

require_once 'models/AdmissionModel.php';

class AdmissionController
{
    private $model;

    public function __construct()
    {
        $this->model = new AdmissionModel();
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

        $this->handleErrorMessage();

        if (!isLoggedIn()) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->processLoginOrSignup();
            } else {
                $this->renderLoginView();
            }
            return;
        }

        $this->handleBranchSelection();

        $this->renderEnrollmentView();
    }

    private function handleErrorMessage()
    {
        $errorMessages = [
            1 => "The password you entered is incorrect.",
            2 => "An account with this email already exists.",
            3 => "The passwords you entered do not match.",
            4 => "No account found with this email address. Please sign up.",
            5 => "An account with this LRN already exists.",
            6 => "LRN must contain exactly 12 digits."
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
        if (!$this->model->userExists($email)) {
            $_SESSION['error'] = 4;
            goToPage('/admission/enrollment');
            return;
        }

        $hashedPassword = $this->model->getUserPassword($email);
        if (!password_verify($password, $hashedPassword)) {
            $_SESSION['error'] = 1;
            goToPage('/admission/enrollment');
            return;
        }

        $_SESSION['admission_ID'] = $this->model->getUserID($email);
        goToPage('/admission/enrollment');
    }

    private function handleSignup($email, $password, $confirmPassword)
    {
        if ($this->model->userExists($email)) {
            $_SESSION['error'] = 2;
            goToPage('/admission/enrollment');
            return;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 3;
            goToPage('/admission/enrollment');
            return;
        }

        $this->model->createUser($email, $password);
        $_SESSION['admission_ID'] = $this->model->getUserID($email);
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
            $_SESSION['admission_ContactNumber'] = $personalInfo['admission_ContactNumber'] ?? null;
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
            $_SESSION['admission_FatherNumber'] = $familyInfo['admission_FatherNumber'] ?? null;
            $_SESSION['admission_FatherOccupation'] = $familyInfo['admission_FatherOccupation'] ?? null;
            $_SESSION['admission_MotherName'] = $familyInfo['admission_MotherName'] ?? null;
            $_SESSION['admission_MotherNumber'] = $familyInfo['admission_MotherNumber'] ?? null;
            $_SESSION['admission_MotherOccupation'] = $familyInfo['admission_MotherOccupation'] ?? null;
            $_SESSION['admission_Income'] = $familyInfo['admission_Income'] ?? null;
            $_SESSION['admission_Siblings'] = $familyInfo['admission_Siblings'] ?? null;
            $_SESSION['admission_BirthOrder'] = $familyInfo['admission_BirthOrder'] ?? null;
            $_SESSION['admission_GuardianName'] = $familyInfo['admission_GuardianName'] ?? null;
            $_SESSION['admission_GuardianNumber'] = $familyInfo['admission_GuardianNumber'] ?? null;
            $_SESSION['admission_GuardianOccupation'] = $familyInfo['admission_GuardianOccupation'] ?? null;


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
            'admission_Religion' => $_POST['enrollment-information-religion'],
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
}

//     public function handleCourse()
//     {
//         include_once 'views/public/include/header.php';
//         include_once 'views/public/admission/course.php';
//     }
// }
// Compare this snippet from views/public/admission/login.php: