<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
require_once "_config.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->setChroot(__DIR__);
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper("A4", "portrait");

$conditions = '';
$conditions .= $_SESSION['admission_Allergy'] ? 'Allergy ' : '';
$conditions .= $_SESSION['admission_Scoliosis'] ? 'Scoliosis ' : '';
$conditions .= $_SESSION['admission_Asthma'] ? 'Asthma ' : '';
$conditions .= $_SESSION['admission_Hypertension'] ? 'Hypertension ' : '';
$conditions .= $_SESSION['admission_Diabetes'] ? 'Diabetes ' : '';
$conditions .= $_SESSION['admission_Insomnia'] ? 'Insomnia ' : '';
$conditions .= $_SESSION['admission_Vertigo'] ? 'Vertigo ' : '';
$conditions .= $_SESSION['admission_Others'] ? $_SESSION['admission_Others'] : '';

date_default_timezone_set('Asia/Manila');

$html = file_get_contents("template.html");
$html = str_replace([
    "{{ datetime }}",
    "{{ control_number }}",
    "{{ branch }}",
    "{{ entry }}",
    "{{ type_student }}",
    "{{ type_applicant }}",
    "{{ strand }}",
    "{{ lrn }}",
    "{{ program }}",
    "{{ name }}",
    "{{ sex }}",
    "{{ address }}",
    "{{ email }}",
    "{{ contact_number }}",
    "{{ birthdate }}",
    "{{ nationality }}",
    "{{ civil }}",
    "{{ pwd }}",
    "{{ indigenous }}",
    "{{ father }}",
    "{{ father_contact }}",
    "{{ father_occupation }}",
    "{{ mother }}",
    "{{ mother_contact }}",
    "{{ mother_occupation }}",
    "{{ guardian }}",
    "{{ guardian_contact }}",
    "{{ guardian_occupation }}",
    "{{ elementary }}",
    "{{ elementary_address }}",
    "{{ elementary_year }}",
    "{{ elementary_type }}",
    "{{ highschool }}",
    "{{ highschool_address }}",
    "{{ highschool_year }}",
    "{{ highschool_type }}",
    "{{ senior }}",
    "{{ senior_address }}",
    "{{ senior_year }}",
    "{{ senior_type }}",
    "{{ vocational }}",
    "{{ vocational_address }}",
    "{{ vocational_year }}",
    "{{ vocational_type }}",
    "{{ medication }}",
    "{{ conditions }}",
], [
    date("F j, Y - h:i:s A"),
    getAssocValueOrNA($_SESSION['admission_ControlNumber']),
    getAssocValueOrNA($_SESSION['admission_Branch']),
    getAssocValueOrNA($_SESSION['admission_Entry']),
    getAssocValueOrNA($_SESSION['admission_TypeStudent']),
    getAssocValueOrNA($_SESSION['admission_TypeApplicant']),
    getAssocValueOrNA($_SESSION['admission_Strand']),
    getAssocValueOrNA($_SESSION['admission_LRN']),
    getAssocValueOrNA($_SESSION['admission_Program']),
    getAssocValueOrNA($_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_LastName'] . ' ' . $_SESSION['admission_Suffix']),
    getAssocValueOrNA($_SESSION['admission_Sex']),
    getAssocValueOrNA('Region ' . str_replace('_', '-', $_SESSION['admission_Region']) . ' ' . $_SESSION['admission_Province']),
    getAssocValueOrNA($_SESSION['admission_Email']),
    getAssocValueOrNA($_SESSION['admission_ContactNumber'] . ' ' . $_SESSION['admission_LandlineNumber']),
    getAssocValueOrNA($_SESSION['admission_BirthDate']),
    getAssocValueOrNA($_SESSION['admission_TypeApplicant']),
    getAssocValueOrNA($_SESSION['admission_CivilStatus']),
    getAssocValueOrNA($_SESSION['admission_PWD']),
    getAssocValueOrNA($_SESSION['admission_Indigenous']),
    getAssocValueOrNA($_SESSION['admission_FatherName']),
    getAssocValueOrNA($_SESSION['admission_FatherNumber']),
    getAssocValueOrNA($_SESSION['admission_FatherOccupation']),
    getAssocValueOrNA($_SESSION['admission_MotherName']),
    getAssocValueOrNA($_SESSION['admission_MotherNumber']),
    getAssocValueOrNA($_SESSION['admission_MotherOccupation']),
    getAssocValueOrNA($_SESSION['admission_GuardianName']),
    getAssocValueOrNA($_SESSION['admission_GuardianNumber']),
    getAssocValueOrNA($_SESSION['admission_GuardianOccupation']),
    getAssocValueOrNA($_SESSION['admission_ElementaryName']),
    getAssocValueOrNA($_SESSION['admission_ElementaryAddress']),
    getAssocValueOrNA($_SESSION['admission_ElementaryYear']),
    getAssocValueOrNA($_SESSION['admission_ElementaryType']),
    getAssocValueOrNA($_SESSION['admission_HighschoolName']),
    getAssocValueOrNA($_SESSION['admission_HighschoolAddress']),
    getAssocValueOrNA($_SESSION['admission_HighschoolYear']),
    getAssocValueOrNA($_SESSION['admission_HighschoolType']),
    getAssocValueOrNA($_SESSION['admission_SeniorName']),
    getAssocValueOrNA($_SESSION['admission_SeniorAddress']),
    getAssocValueOrNA($_SESSION['admission_SeniorYear']),
    getAssocValueOrNA($_SESSION['admission_SeniorType']),
    getAssocValueOrNA($_SESSION['admission_VocationalName']),
    getAssocValueOrNA($_SESSION['admission_VocationalAddress']),
    getAssocValueOrNA($_SESSION['admission_VocationalYear']),
    getAssocValueOrNA($_SESSION['admission_VocationalType']),
    getAssocValueOrNA($_SESSION['admission_Medication']),
    $conditions,
], $html);

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->addInfo("Title", $_SESSION['admission_LastName'] . ', ' . $_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_Suffix'] . ' - Application Form');
$dompdf->stream("CvSU_Application_Form.pdf", [
    "Attachment" => false,
]);
