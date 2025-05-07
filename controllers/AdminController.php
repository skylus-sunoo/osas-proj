<?php

require_once 'models/AdminModel.php';
require_once 'models/UserModel.php';
require_once 'models/AdmissionModel.php';
require_once 'models/IncidentModel.php';

class AdminController
{
    private $model;
    private $userModel;
    private $admissionModel;
    private $incidentModel;

    public function __construct()
    {
        $this->model = new AdminModel();
        $this->userModel = new UserModel();
        $this->admissionModel = new AdmissionModel();
        $this->incidentModel = new IncidentModel();
    }

    public function getModelAdmission()
    {
        return $this->admissionModel;
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

    #region Login and Signup
    public function handleAdminRedirect()
    {
        if (!$this->isLoggedIn()) {
            goToPage('/admin/login');
        }
    }

    public function logoutUser()
    {
        session_unset();
        session_destroy();
        goToPage('/admin/login');
    }

    public function handleLoginRedirect()
    {
        $this->handleErrorMessage();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        include_once 'views/admin/dashboard/login.php';
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['admin_ID']);
    }

    private function handleLogin($email, $password)
    {
        if (!$this->userModel->userExists($this->userModel->tableAdmin(), $email)) {
            $_SESSION['error'] = 4;
            goToPage('/admin/login');
            return;
        }

        $hashedPassword = $this->userModel->getUserPassword($this->userModel->tableAdmin(), $email);
        if (!password_verify($password, $hashedPassword)) {
            $_SESSION['error'] = 1;
            goToPage('/admin/login');
            return;
        }

        $_SESSION['admin_ID'] = $this->userModel->getUserID($this->userModel->tableAdmin(), $email);
        $_SESSION['admin_Email'] = $email;
        goToPage('/admin/home');
    }

    private function handleSignup($email, $password, $confirmPassword)
    {
        if ($this->userModel->userExists($this->userModel->tableAdmin(), $email)) {
            $_SESSION['error'] = 2;
            goToPage('/admin/login');
            return;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 3;
            goToPage('/admin/login');
            return;
        }

        $this->userModel->createUser($this->userModel->tableAdmin(), $email, $password);
        $_SESSION['admin_ID'] = $this->userModel->getUserID($this->userModel->tableAdmin(), $email);
        $_SESSION['admin_Email'] = $email;
        goToPage('/admin/home');
    }
    #endregion

    #region Home 
    public function generateHomeCard($color, $icon, $value, $text, $redirect = null, $link = null)
    {

        $noRedirectRadius = ($redirect === null && $link == null) ? 'border-radius: 10px 10px;' : '';

        echo '<section class="home-card" style="border-color: ' . $color . ';">
                <div class="home-card-info" style="background-color: ' . $color . '; ' . $noRedirectRadius . '">
                    <div class="home-card-icon">
                        <span class="material-symbols-outlined">' . $icon . '</span>
                    </div>
                    <div class="home-card-text">
                        <h1>' . $value . '</h1>
                        <p>' . $text . '</p>
                    </div>
                </div>';

        if ($redirect != null && $link != null) {
            echo '
                    <div class="home-card-redirect">
                        <a href="' . $link . '" style="color: ' . $color . ';">
                            ' . $redirect . '
                            <span class="material-symbols-outlined" style="color: ' . $color . ';">open_in_new</span>
                        </a>
                    </div>';
        }
        echo '</section>';
    }
    #endregion

    #region Admissions
    public function renderPaginationControls($currentPage, $totalPages, $totalCount)
    {
        echo '<div class="pagination">';

        echo "<p>Page $currentPage of $totalPages from $totalCount items</p>";

        $controlLinkGap = 1.5; // Gap between buttons and number links

        echo "<div class='pagination-links'>";
        if ($currentPage > 1) {
            // Link to the first page
            echo '<a href="?page=1"><span class="material-symbols-outlined">first_page</span></a>';
            // Link to the previous page
            echo '<a href="?page=' . ($currentPage - 1) . '" style="margin-right: ' . $controlLinkGap . 'rem;"><span class="material-symbols-outlined">chevron_left</span></a>';
        }

        // Display a range of page numbers (e.g., 1 2 3 ... Last)
        $maxPagesToShow = 7; // Max number of page links to display

        // Calculate the start and end page
        if ($totalPages <= $maxPagesToShow) {
            // If there are fewer than 5 pages, show all pages
            $startPage = 1;
            $endPage = $totalPages;
        } else {
            // Calculate the start and end page dynamically
            if ($currentPage <= floor($maxPagesToShow / 2)) {
                // Near the start, show pages from 1
                $startPage = 1;
                $endPage = min($maxPagesToShow, $totalPages);
            } elseif ($currentPage >= $totalPages - floor($maxPagesToShow / 2)) {
                // Near the end, show the last $maxPagesToShow pages
                $startPage = max(1, $totalPages - $maxPagesToShow + 1);
                $endPage = $totalPages;
            } else {
                // In the middle, show $maxPagesToShow pages centered around the current page
                $startPage = $currentPage - floor($maxPagesToShow / 2);
                $endPage = $currentPage + floor($maxPagesToShow / 2);
            }
        }

        // Show the page numbers
        for ($page = $startPage; $page <= $endPage; $page++) {
            if ($page == $currentPage) {
                // Highlight the current page with an underline
                echo '<span class="current-page">' . $page . '</span>';
            } else {
                echo '<a href="?page=' . $page . '">' . $page . '</a>';
            }
        }

        if ($currentPage < $totalPages) {
            // Link to the next page
            echo '<a href="?page=' . ($currentPage + 1) . '" style="margin-left: ' . $controlLinkGap . 'rem;"><span class="material-symbols-outlined">chevron_right</span></a>';
            // Link to the last page
            echo '<a href="?page=' . $totalPages . '"><span class="material-symbols-outlined">last_page</span></a>';
        }

        echo '</div></div>';
    }

    public function renderAdmissionsOverview()
    {
        // Set the number of items per page and the current page
        $itemsPerPage = 12;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        // Calculate the starting row for the SQL query (Offset)
        $startRow = ($currentPage - 1) * $itemsPerPage;

        $filters = [];

        if (isset($_POST['filter_Email']) && !empty($_POST['filter_Email'])) {
            $filters[] = ['admission_Email', '=', $_POST['filter_Email']];
        }

        // Fetch paginated admissions data

        if ($filters != null) {
            $admissions = fetchData(TB_ADMISSION_USER, ['admission_ID', 'admission_Email'], [['admission_Email', 'LIKE', $_POST['filter_Email']]]);
            echo "<br> <h3>Showing " . count($admissions) . " results for '" . $_POST['filter_Email'] . "'</h3>";
        } else {
            $admissions = fetchDataLimited(TB_ADMISSION_USER, ['admission_ID', 'admission_Email'], $filters, $startRow, $itemsPerPage);
        }

        echo "<br>";
        // preformat($admissions);

        // Fetch the total number of rows for pagination
        $totalAdmissions = countData(TB_ADMISSION_USER);  // Fetch all records to count total
        $totalPages = ceil($totalAdmissions / $itemsPerPage);  // Calculate total pages

        echo '<table>
        <thead>
            <tr>
                <th hidden>ID</th>
                <th>Email</th>
                <th>Admission</th>
                <th>Personal</th>
                <th>Family</th>
                <th>Education</th>
                <th>Medical</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($admissions as $admission) {
            $id = $admission['admission_ID'];
            $isReviewing = false;
            if (isset($_SESSION['admission_ID']) && $id == $_SESSION['admission_ID']) {
                $isReviewing = true;
            }

            echo '<tr>';
            echo "<td hidden>$id</td>";
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . ">{$admission['admission_Email']}</td>";

            // Add classes based on the DONE status
            $admissionStatus = $this->admissionModel->userAdmissionInfoExists($id) ? 'done' : 'not-done';
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . "> <div class='$admissionStatus'>" . ($this->admissionModel->userAdmissionInfoExists($id) ? 'DONE' : 'NOT DONE') . '</div> </td>';

            $personalStatus = $this->admissionModel->userPersonalInfoExists($id) ? 'done' : 'not-done';
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . "> <div class='$personalStatus'>" . ($this->admissionModel->userPersonalInfoExists($id) ? 'DONE' : 'NOT DONE') . '</div> </td>';

            $familyStatus = $this->admissionModel->userFamilyInfoExists($id) ? 'done' : 'not-done';
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . "> <div class='$familyStatus'>" . ($this->admissionModel->userFamilyInfoExists($id) ? 'DONE' : 'NOT DONE') . '</div> </td>';

            $educationStatus = $this->admissionModel->userEducationInfoExists($id) ? 'done' : 'not-done';
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . "> <div class='$educationStatus'>" . ($this->admissionModel->userEducationInfoExists($id) ? 'DONE' : 'NOT DONE') . '</div> </td>';

            $medicalStatus = $this->admissionModel->userMedicalInfoExists($id) ? 'done' : 'not-done';
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . "> <div class='$medicalStatus'>" . ($this->admissionModel->userMedicalInfoExists($id) ? 'DONE' : 'NOT DONE') . '</div> </td>';

            // Add the "Review" button in the Actions column
            echo "<td " . ($isReviewing ? 'id="overview-reviewing"' : '') . ">";
            echo '
                <form action="/admissions/overview_review" method="post">
                    <input type="hidden" name="admission_ID" value="' . $id . '">
                    <button class="review-btn" type="submit">Review</button>
                </form>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</tbody>
        </table>';

        if ($filters == null) {
            $this->renderPaginationControls($currentPage, $totalPages, $totalAdmissions);
        }
    }

    public function renderAdmissionsOverviewSingle()
    {
        if (isset($_SESSION['admission_ID'])) {
            $dataRaw = fetchData(TB_ADMISSION_USER, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = $dataRaw[0] ?? [];

            $dataRaw = fetchData(TB_ADMISSION_INFO, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = array_merge($data, $dataRaw[0] ?? []);

            $dataRaw = fetchData(TB_ADMISSION_PERSONAL, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = array_merge($data, $dataRaw[0] ?? []);

            $dataRaw = fetchData(TB_ADMISSION_FAMILY, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = array_merge($data, $dataRaw[0] ?? []);

            $dataRaw = fetchData(TB_ADMISSION_EDUCATION, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = array_merge($data, $dataRaw[0] ?? []);

            $dataRaw = fetchData(TB_ADMISSION_MEDICAL, '*', [['admission_ID', '=', $_SESSION['admission_ID']]]);
            $data = array_merge($data, $dataRaw[0] ?? []);

            $data['admission_Conditions'] = '';
            if (checkForData(TB_ADMISSION_MEDICAL, [['admission_ID', '=', $_SESSION['admission_ID']]])) {
                $data['admission_Conditions'] .= $data['admission_Allergy'] ? 'Allergy ' : '';
                $data['admission_Conditions'] .= $data['admission_Scoliosis'] ? 'Scoliosis ' : '';
                $data['admission_Conditions'] .= $data['admission_Asthma'] ? 'Asthma ' : '';
                $data['admission_Conditions'] .= $data['admission_Hypertension'] ? 'Hypertension ' : '';
                $data['admission_Conditions'] .= $data['admission_Diabetes'] ? 'Diabetes ' : '';
                $data['admission_Conditions'] .= $data['admission_Insomnia'] ? 'Insomnia ' : '';
                $data['admission_Conditions'] .= $data['admission_Vertigo'] ? 'Vertigo ' : '';
                $data['admission_Conditions'] .= $data['admission_Others'] ? $data['admission_Others'] : '';
            }

            // $data['admission_Conditions'] = empty($data['admission_Conditions']) ? null : '';


            normalizeData($data);

            echo '
                <form class="form-overview">
                    <p>Showing information of <b>' . getValueOrNA($data, 'admission_Email') . '</b></p>
                    <br>
                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_ID">Admission ID</label>
                            <input disabled type="text" name="admission_ID" value="' . getValueOrNA($data, 'admission_ID') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Branch">Campus Branch</label>
                            <input disabled type="text" name="admission_Branch" value="' . getValueOrNA($data, 'admission_Branch') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Branch">Campus Branch</label>
                            <input disabled type="text" name="admission_Branch" value="' . getValueOrNA($data, 'admission_Branch') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_Name">Name</label>
                            <input disabled type="text" name="admission_Name" value="' . getValueOrNA($data, 'admission_LastName') . ', ' . getValueOrNA($data, 'admission_FirstName') . ' ' . getValueOrNA($data, 'admission_MiddleName', '') . ' ' . getValueOrNA($data, 'admission_Suffix', '') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Entry">Entry</label>
                            <input disabled type="text" name="admission_Entry" value="' . getValueOrNA($data, 'admission_Entry') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_TypeApplicant">Applicant Type</label>
                            <input disabled type="text" name="admission_TypeApplicant" value="' . getValueOrNA($data, 'admission_TypeApplicant') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_TypeStudent">Student Type</label>
                            <input disabled type="text" name="admission_TypeStudent" value="' . getValueOrNA($data, 'admission_TypeStudent') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Strand">Strand</label>
                            <input disabled type="text" name="admission_Strand" value="' . getValueOrNA($data, 'admission_Strand') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_LRN">Learner Reference Number</label>
                            <input disabled type="text" name="admission_LRN" value="' . getValueOrNA($data, 'admission_LRN') . '">
                        </div>
                    </section>

                    <hr>

                    <h2>Personal Information</h2>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_Address">Address</label>
                            <input disabled type="text" name="admission_Address" value="' . (isset($data['admission_Region']) ? 'Region ' : '') . str_replace('_', '-', getValueOrNA($data, 'admission_Region')) . ' ' . getValueOrNA($data, 'admission_Province') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_ContactNumber">Contact Number</label>
                            <input disabled type="text" name="admission_ContactNumber" value="' . (isset($data['admission_ContactNumber']) ? str_pad(getValueOrNA($data, 'admission_ContactNumber'), 11, '0', STR_PAD_LEFT) : getValueOrNA($data, 'admission_ContactNumber')) . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_CivilStatus">Civil Status</label>
                            <input disabled type="text" name="admission_CivilStatus" value="' . getValueOrNA($data, 'admission_CivilStatus') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Religion">Religion</label>
                            <input disabled type="text" name="admission_Religion" value="' . getValueOrNA($data, 'admission_Religion') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_BirthDate">Date of Birth</label>
                            <input disabled type="text" name="admission_BirthDate" value="' . getValueOrNA($data, 'admission_BirthDate') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_BirthPlace">Place of Birth</label>
                            <input disabled type="text" name="admission_BirthPlace" value="' . getValueOrNA($data, 'admission_BirthPlace') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Sex">Sex</label>
                            <input disabled type="text" name="admission_Sex" value="' . getValueOrNA($data, 'admission_Sex') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Indigenous">Indigenous</label>
                            <input disabled type="text" name="admission_Indigenous" value="' . getValueOrNA($data, 'admission_Indigenous') . '">
                        </div>
                    </section>

                    <hr>

                    <h2>Family Background</h2>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_FatherName">Father Name</label>
                            <input disabled type="text" name="admission_FatherName" value="' . getValueOrNA($data, 'admission_FatherName') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_FatherNumber">Contact Number</label>
                            <input disabled type="text" name="admission_FatherNumber" value="' . (isset($data['admission_FatherNumber']) ? str_pad(getValueOrNA($data, 'admission_FatherNumber'), 11, '0', STR_PAD_LEFT) : getValueOrNA($data, 'admission_FatherNumber')) . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_FatherOccupation">Occupation</label>
                            <input disabled type="text" name="admission_FatherOccupation" value="' . getValueOrNA($data, 'admission_FatherOccupation') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_MotherName">Mother Name</label>
                            <input disabled type="text" name="admission_MotherName" value="' . getValueOrNA($data, 'admission_MotherName') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_MotherNumber">Contact Number</label>
                            <input disabled type="text" name="admission_MotherNumber" value="' . (isset($data['admission_MotherNumber']) ? str_pad(getValueOrNA($data, 'admission_MotherNumber'), 11, '0', STR_PAD_LEFT) : getValueOrNA($data, 'admission_MotherNumber')) . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_MotherOccupation">Occupation</label>
                            <input disabled type="text" name="admission_MotherOccupation" value="' . getValueOrNA($data, 'admission_MotherOccupation') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_GuardianName">Guardian Name</label>
                            <input disabled type="text" name="admission_GuardianName" value="' . getValueOrNA($data, 'admission_GuardianName') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_GuardianNumber">Contact Number</label>
                            <input disabled type="text" name="admission_GuardianNumber" value="' . (isset($data['admission_GuardianNumber']) ? str_pad(getValueOrNA($data, 'admission_GuardianNumber'), 11, '0', STR_PAD_LEFT) : getValueOrNA($data, 'admission_GuardianNumber')) . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_GuardianOccupation">Occupation</label>
                            <input disabled type="text" name="admission_GuardianOccupation" value="' . getValueOrNA($data, 'admission_GuardianOccupation') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_Income">Estimated Monthly Family Income</label>
                            <input disabled type="text" name="admission_Income" value="' . getValueOrNA($data, 'admission_Income') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Siblings">Number of Siblings</label>
                            <input disabled type="text" name="admission_Siblings" value="' . getValueOrNA($data, 'admission_Siblings') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_BirthOrder">Birth Order</label>
                            <input disabled type="text" name="admission_BirthOrder" value="' . getValueOrNA($data, 'admission_BirthOrder') . '">
                        </div>
                    </section>

                    <hr>

                    <h2>Educational History</h2>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_ElementaryName">Name</label>
                        </div>

                        <div class="form-group">
                            <label for="admission_ElementaryAddress">Address</label>
                        </div>

                        <div class="form-group" style="max-width: 200px;">
                            <label for="admission_ElementaryYear">Year Graduated</label>
                        </div>

                        <div class="form-group" style="max-width: 100px;">
                            <label for="admission_ElementaryType">Type</label>
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <input disabled type="text" name="admission_ElementaryName" value="' . getValueOrNA($data, 'admission_ElementaryName') . '">
                        </div>

                        <div class="form-group">
                            <input disabled type="text" name="admission_ElementaryAddress" value="' . getValueOrNA($data, 'admission_ElementaryAddress') . '">
                        </div>

                        <div class="form-group" style="max-width: 200px;">
                            <input disabled type="text" name="admission_ElementaryYear" value="' . getValueOrNA($data, 'admission_ElementaryYear') . '">
                        </div>

                        <div class="form-group" style="max-width: 100px;">
                            <input disabled type="text" name="admission_ElementaryType" value="' . getValueOrNA($data, 'admission_ElementaryType') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <input disabled type="text" name="admission_HighschoolName" value="' . getValueOrNA($data, 'admission_HighschoolName') . '">
                        </div>

                        <div class="form-group">
                            <input disabled type="text" name="admission_HighschoolAddress" value="' . getValueOrNA($data, 'admission_HighschoolAddress') . '">
                        </div>

                        <div class="form-group" style="max-width: 200px;">
                            <input disabled type="text" name="admission_HighschoolYear" value="' . getValueOrNA($data, 'admission_HighschoolYear') . '">
                        </div>

                        <div class="form-group" style="max-width: 100px;">
                            <input disabled type="text" name="admission_HighschoolType" value="' . getValueOrNA($data, 'admission_HighschoolType') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <input disabled type="text" name="admission_SeniorName" value="' . getValueOrNA($data, 'admission_SeniorName') . '">
                        </div>

                        <div class="form-group">
                            <input disabled type="text" name="admission_SeniorAddress" value="' . getValueOrNA($data, 'admission_SeniorAddress') . '">
                        </div>

                        <div class="form-group" style="max-width: 200px;">
                            <input disabled type="text" name="admission_SeniorYear" value="' . getValueOrNA($data, 'admission_SeniorYear') . '">
                        </div>

                        <div class="form-group" style="max-width: 100px;">
                            <input disabled type="text" name="admission_SeniorType" value="' . getValueOrNA($data, 'admission_SeniorType') . '">
                        </div>
                    </section>

                    <section class="form-row">
                        <div class="form-group">
                            <input disabled type="text" name="admission_VocationalName" value="' . getValueOrNA($data, 'admission_VocationalName') . '">
                        </div>

                        <div class="form-group">
                            <input disabled type="text" name="admission_VocationalAddress" value="' . getValueOrNA($data, 'admission_VocationalAddress') . '">
                        </div>

                        <div class="form-group" style="max-width: 200px;">
                            <input disabled type="text" name="admission_VocationalYear" value="' . getValueOrNA($data, 'admission_VocationalYear') . '">
                        </div>

                        <div class="form-group" style="max-width: 100px;">
                            <input disabled type="text" name="admission_VocationalType" value="' . getValueOrNA($data, 'admission_VocationalType') . '">
                        </div>
                    </section>

                    <hr>

                    <h2>Medical Background</h2>

                    <section class="form-row">
                        <div class="form-group">
                            <label for="admission_Medications">Medications</label>
                            <input disabled type="text" name="admission_Medications" value="' . getValueOrNA($data, 'admission_Medications') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_Conditions">Conditions</label>
                            <input disabled type="text" name="admission_Conditions" value="' . getValueOrNA($data, 'admission_Conditions') . '">
                        </div>

                        <div class="form-group">
                            <label for="admission_PWD">PWD</label>
                            <input disabled type="text" name="admission_PWD" value="' . getValueOrNA($data, 'admission_PWD') . '">
                        </div>
                    </section>
                </form>';
        }
    }
    #endregion

    #region Requirements
    public function handleRequirements()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Handle search by Control Number
        if (isset($_POST['search_ControlNumber'])) {
            $controlNumber = $_POST['search_ControlNumber'];

            if (!$this->admissionModel->verifyControlNumber($controlNumber)) {
                showAlert('No user with this control number exists.');
                return;
            }

            $id = $this->admissionModel->getIDFromControlNumber($controlNumber);
            $this->populateRequirementPostData($id);
            return;
        }

        // Handle requirement update
        if (isset($_POST['requirements_ID'])) {
            $id = $_POST['requirements_ID'];

            $data = [
                'admission_Picture' => $_POST['requirements_Picture'] ?? null,
                'admission_Folder' => $_POST['requirements_Folder'] ?? null,
                'admission_Certificate' => $_POST['requirements_Certificate'] ?? null
            ];

            $this->admissionModel->updateRequirements($data, $id);
            $this->populateRequirementPostData($id);
            showAlert('Requirements updated.');
        }
    }

    /**
     * Populate $_POST with user and requirement data based on ID
     */
    private function populateRequirementPostData($id)
    {
        $_POST['requirements_ID'] = $id;
        $_POST['requirements_ControlNumber'] = $this->admissionModel->getControlNumber($id);
        $_POST['requirements_Name'] = $this->admissionModel->getFullName($id);
        $_POST['requirements_Email'] = $this->userModel->getUserEmail($this->userModel->tableAdmission(), $id);

        $requirementsRaw = $this->admissionModel->getRequirements($id);
        $requirements = $requirementsRaw[0] ?? [];

        $_POST['admission_Picture'] = $requirements['admission_Picture'] ?? null;
        $_POST['admission_Folder'] = $requirements['admission_Folder'] ?? null;
        $_POST['admission_Certificate'] = $requirements['admission_Certificate'] ?? null;
    }

    #endregion

    #region Examinations
    public function renderExamTable()
    {
        echo "<br>";
        $exams = fetchData(TB_ADMIN_EXAM, '*');

        // Sort by 'exam_DateCalendar' in ascending order
        usort($exams, function ($a, $b) {
            return strcmp($a['exam_DateCalendar'], $b['exam_DateCalendar']);
        });
        echo '<div class="admin-exams">';
        echo '<table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Capacity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($exams as $exam) {
            echo '<tr>';
            echo "<td>" . $exam['exam_Date'] . "</td>";
            echo "<td>" . $exam['exam_Capacity'] . "</td>";

            if ($exam['exam_Status'] == null) {
                echo '<td>
                <div class="released-flex"> 
                <form action="/admissions/exam_release" method="post">
                    <input type="hidden" name="exam_Date" value="' . $exam['exam_Date'] . '">
                    <input type="hidden" name="exam_Capacity" value="' . $exam['exam_Capacity'] . '">
                    <button class="review-btn" type="submit">Release</button>
                </form>
                <form action="/admissions/exam_delete" method="post">
                    <input type="hidden" name="exam_Date" value="' . $exam['exam_Date'] . '">
                    <input type="hidden" name="exam_Capacity" value="' . $exam['exam_Capacity'] . '">
                    <button class="delete-btn" type="submit">Delete</button>
                </form>
                ';
            } else {
                echo '<td>
                <div class="released-flex"> <div class="released">Released</div>
                <form action="/admissions/exam_delete" method="post">
                    <input type="hidden" name="exam_Date" value="' . $exam['exam_Date'] . '">
                    <input type="hidden" name="exam_Capacity" value="' . $exam['exam_Capacity'] . '">
                    <button class="delete-btn" type="submit">Delete</button>
                </form></div>
                ';
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>
        </table>';
        echo '</div>';
    }

    public function createExam()
    {
        // Parse the date
        $date = new DateTime($_POST['exam_DateCalendar']);

        // Format the date like "May 8, 2025"
        $formattedDate = $date->format('F j, Y');

        // Append the AM/PM value
        $exam_Date = $formattedDate . ' ' . strtoupper($_POST['exam_DateMeridiem']);

        $data = [
            'exam_Date' => $exam_Date,
            'exam_DateCalendar' => $_POST['exam_DateCalendar'],
            'exam_DateMeridiem' => $_POST['exam_DateMeridiem'],
            'exam_Capacity' => $_POST['exam_Capacity']
        ];

        normalizeData($data);

        if ($this->model->examDateExists($data['exam_Date'])) {
            $this->model->updateExamDate($data, $data['exam_Date']);
            goToPage('/admissions/examinations');
        } else {
            $this->model->createExamDate($data, $data['exam_Date']);
            goToPage('/admissions/examinations');
        }
    }

    public function releaseExam()
    {
        $exam_Status = 'RELEASED';

        $data = [
            'exam_Status' => $exam_Status
        ];

        normalizeData($data);

        if ($this->model->examDateExists($_POST['exam_Date'])) {
            $this->model->updateExamStatus($data, $_POST['exam_Date']);
            $occ = 0;

            for ($i = 0; $i < $_POST['exam_Capacity']; $i++) {
                $this->model->assignExamSlot($_POST['exam_Date']);
                $occ++;
            }

            $this->model->updateExamOccupied(['exam_Occupied' => $occ], $_POST['exam_Date']);

            goToPage('/admissions/examinations');
        }
    }

    public function deleteExam()
    {
        $this->model->deleteExamDate($_POST['exam_Date']);
        goToPage('/admissions/examinations');
    }

    public function handleExamResults()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if (isset($_POST['exam_DateCalendar']) && isset($_POST['exam_DateMeridiem'])) {
            $date = new DateTime($_POST['exam_DateCalendar']);

            // Format the date like "May 8, 2025"
            $formattedDate = $date->format('F j, Y');

            // Append the AM/PM value
            $_POST['batch_Exam'] = $formattedDate . ' ' . strtoupper($_POST['exam_DateMeridiem']);
        }

        if (isset($_POST['exam_Batch'])) {
            // $_
        }

        // Handle search by Control Number
        // if (isset($_POST['search_ControlNumber'])) {
        //     $controlNumber = $_POST['search_ControlNumber'];

        //     if (!$this->admissionModel->verifyControlNumber($controlNumber)) {
        //         showAlert('No user with this control number exists.');
        //         return;
        //     }

        //     $id = $this->admissionModel->getIDFromControlNumber($controlNumber);
        //     $this->populateResultsPostData($id);
        //     return;
        // }

        // // Handle requirement update
        // if (isset($_POST['results_ID'])) {
        //     $id = $_POST['results_ID'];

        //     $data = [
        //         'results_Result' => $_POST['results_Result'] ?? null
        //     ];

        //     normalizeData($data);

        //     $this->admissionModel->updateResult($id, $data);
        //     $this->populateResultsPostData($id);
        //     return;
        // }
    }

    /**
     * Populate $_POST with user and results data based on ID
     */
    private function populateResultsPostData($id)
    {
        $_POST['results_ID'] = $id;
        $_POST['results_ControlNumber'] = $this->admissionModel->getControlNumber($id);
        $_POST['results_Name'] = $this->admissionModel->getFullName($id);
        $_POST['results_Email'] = $this->userModel->getUserEmail($this->userModel->tableAdmission(), $id);
        $_POST['results_Result'] = $this->admissionModel->getResult($id);
    }

    public function renderExamBatch()
    {
        echo "<br>";
        if (isset($_POST['batch_Exam'])) {
            $batches = fetchData(TB_ADMISSION_CONTROL, '*', [['admission_Exam', '=', $_POST['batch_Exam']]]);
            echo '<h3 style="text-align: center;">Showing examinees for <span style="color: var(--primary-hex-blue)">' . $_POST['batch_Exam'] . '</span></h3>';
        }
        echo "<br>";
        // Sort by 'exam_DateCalendar' in ascending order
        echo '<div class="admin-exams">';
        echo '<table>
        <thead>
            <tr>
                <th style="display: none;">ID</th>
                <th>Control Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

        echo '<form action="/admissions/exam_results?results=true" method="post">
                    <input type="hidden" name="exam_Batch" value="true">
                    <input type="hidden" name="exam_DateCalendar" value="' . ($_POST['exam_DateCalendar'] ?? null) . '">
                    <input type="hidden" name="exam_DateMeridiem" value="' . ($_POST['exam_DateMeridiem'] ?? null ). '">
        ';

        if (isset($_POST['batch_Exam'])) {
            foreach ($batches as $batch) {
                echo '<tr>';
                echo "<td style='display: none;'>" . $batch['admission_ID'] . "</td>";
                echo "<td>" . $batch['admission_ControlNumber'] . "</td>";
                echo '<td style="display: flex; justify-content: center; column-gap: 1rem;">';
                echo '<div style="margin: auto 0">
                        <input type="radio" name="' . $batch['admission_ControlNumber'] . '" ' . ($batch['admission_Result'] == 'PASSED' ? 'checked' : '') . ' value="PASSED">
                        <label for="' . $batch['admission_ControlNumber'] . '">Passed</label>
                      </div>
                      <div style="margin: auto 0">
                        <input type="radio" name="' . $batch['admission_ControlNumber'] . '" ' . ($batch['admission_Result'] == 'FAILED' ? 'checked' : '') . ' value="FAILED">
                        <label for="' . $batch['admission_ControlNumber'] . '">Failed</label>
                      </div>';
                echo '</td>';
                echo '</tr>';
            }
        }

        echo '</tbody>
        </table>';

        echo '<button type="submit" class="primary-button">Save</button>
                        </form>';
        echo '</div>';
    }
    #endregion

    #region
    public function handleIncidentActions()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['form_action'] != null) {
                $action = $_POST['form_action'];

                $data = [
                    'incident_Name' => $_POST['incident_Name'],
                    'incident_Type' => $_POST['incident_Type'],
                    'incident_DateTime' => $_POST['incident_DateTime'],
                    'incident_Location' => $_POST['incident_Location'],
                    'incident_Status' => $_POST['incident_Status'],
                    'incident_Description' => $_POST['incident_Description']
                ];

                normalizeData($data);

                // echo $action;
                switch ($action) {
                    case 'create':
                        $this->incidentModel->createIncident($data, $_POST['incident_ID']);
                        break;
                    case 'update':
                        $this->incidentModel->updateIncident($data, $_POST['incident_ID']);
                        break;
                    case 'delete':
                        $this->incidentModel->deleteIncident($_POST['incident_ID']);
                        break;
                }
            }
        }
    }

    public function renderIncidentsOverview()
    {
        // Set the number of items per page and the current page
        $itemsPerPage = 12;
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        // Calculate the starting row for the SQL query (Offset)
        $startRow = ($currentPage - 1) * $itemsPerPage;

        $filters = [];

        if (isset($_POST['filter_Name']) && !empty($_POST['filter_Name'])) {
            $filters[] = ['incident_Name', 'LIKE', $_POST['filter_Name']];
        }

        if (isset($_POST['filter_Type']) && !empty($_POST['filter_Type'])) {
            $filters[] = ['incident_Type', '=', $_POST['filter_Type']];
        }

        if (isset($_POST['filter_Status']) && !empty($_POST['filter_Status'])) {
            $filters[] = ['incident_Status', '=', $_POST['filter_Status']];
        }

        // Fetch paginated admissions data

        if ($filters != null) {
            $incidents = fetchData(TB_ADMIN_INCIDENT, '*', $filters);
            echo "<br> <h3>Showing " . count($incidents) . " results.</h3>";
        } else {
            $incidents = fetchDataLimited(TB_ADMIN_INCIDENT, '*', $filters, $startRow, $itemsPerPage);
        }

        echo "<br>";
        // preformat($incidents);

        // Fetch the total number of rows for pagination
        $totalIncidents = countData(TB_ADMIN_INCIDENT);  // Fetch all records to count total
        $totalPages = ceil($totalIncidents / $itemsPerPage);  // Calculate total pages

        echo '<table>
        <thead>
            <tr>
                <th hidden>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Date Time</th>
                <th>Location</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($incidents as $incident) {
            $id = $incident['incident_ID'];

            echo '<tr>';
            echo "<td hidden>$id</td>";
            echo "<td>{$incident['incident_Name']}</td>";
            echo "<td>{$incident['incident_Type']}</td>";
            echo "<td>{$incident['incident_DateTime']}</td>";
            echo "<td>{$incident['incident_Location']}</td>";
            echo "<td>{$incident['incident_Status']}</td>";

            // Add the "Review" button in the Actions column
            echo "<td>";
            echo '
                <form action="/incidents/overview?review=true" method="post">
                    <input type="hidden" name="incident_ID" value="' . $id . '">
                    <input type="hidden" name="incident_Name" value="' . $incident['incident_Name'] . '">
                    <input type="hidden" name="incident_Type" value="' . $incident['incident_Type'] . '">
                    <input type="hidden" name="incident_DateTime" value="' . $incident['incident_DateTime'] . '">
                    <input type="hidden" name="incident_Location" value="' . $incident['incident_Location'] . '">
                    <input type="hidden" name="incident_Status" value="' . $incident['incident_Status'] . '">
                    <input type="hidden" name="incident_Description" value="' . $incident['incident_Description'] . '">
                    <button class="review-btn" type="submit">Review</button>
                </form>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</tbody>
        </table>';

        if ($filters == null) {
            $this->renderPaginationControls($currentPage, $totalPages, $totalIncidents);
        }
    }
    #endregion
}
