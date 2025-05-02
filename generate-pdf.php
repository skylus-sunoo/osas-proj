<?php
session_start();
require __DIR__ . "/vendor/autoload.php";

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
    $_SESSION['admission_ControlNumber'],
    $_SESSION['admission_Branch'],
    $_SESSION['admission_Entry'],
    $_SESSION['admission_TypeStudent'],
    $_SESSION['admission_TypeApplicant'],
    $_SESSION['admission_Strand'],
    $_SESSION['admission_LRN'],
    $_SESSION['admission_Program'],
    $_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_LastName'] . ' ' . $_SESSION['admission_Suffix'],
    $_SESSION['admission_Sex'],
    'Region' . $_SESSION['admission_Region'] . ' ' . $_SESSION['admission_Province'],
    $_SESSION['admission_Email'],
    $_SESSION['admission_ContactNumber'] . ' ' . $_SESSION['admission_LandlineNumber'],
    $_SESSION['admission_BirthDate'],
    $_SESSION['admission_TypeApplicant'],
    $_SESSION['admission_CivilStatus'],
    $_SESSION['admission_PWD'],
    $_SESSION['admission_Indigenous'],
    $_SESSION['admission_FatherName'],
    $_SESSION['admission_FatherNumber'],
    $_SESSION['admission_FatherOccupation'],
    $_SESSION['admission_MotherName'],
    $_SESSION['admission_MotherNumber'],
    $_SESSION['admission_MotherOccupation'],
    $_SESSION['admission_GuardianName'],
    $_SESSION['admission_GuardianNumber'],
    $_SESSION['admission_GuardianOccupation'],
    $_SESSION['admission_ElementaryName'],
    $_SESSION['admission_ElementaryAddress'],
    $_SESSION['admission_ElementaryYear'],
    $_SESSION['admission_ElementaryType'],
    $_SESSION['admission_HighschoolName'],
    $_SESSION['admission_HighschoolAddress'],
    $_SESSION['admission_HighschoolYear'],
    $_SESSION['admission_HighschoolType'],
    $_SESSION['admission_SeniorName'],
    $_SESSION['admission_SeniorAddress'],
    $_SESSION['admission_SeniorYear'],
    $_SESSION['admission_SeniorType'],
    $_SESSION['admission_VocationalName'],
    $_SESSION['admission_VocationalAddress'],
    $_SESSION['admission_VocationalYear'],
    $_SESSION['admission_VocationalType'],
    $_SESSION['admission_Medication'],
    $conditions,
], $html);

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->addInfo("Title", "Application Form");
$dompdf->stream("file.pdf", [
    "Attachment" => false,
]);
