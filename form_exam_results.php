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

$sql = "SELECT 
                    c.admission_ControlNumber,
                    i.admission_Program
                FROM 
                    tb_admission_control AS c
                INNER JOIN 
                    tb_admission_info AS i
                ON 
                    c.admission_ID = i.admission_ID
                WHERE
                    c.admission_Result = 'PASSED';";

// $sql = "SELECT * FROM tb_admission_user;";

$results = runQuery($sql);

date_default_timezone_set('Asia/Manila');

$html = file_get_contents("form_exam_results.html");

$rowsHtml = '';
foreach ($results as $row) {
    $controlNumber = str_pad($row['admission_ControlNumber'], 5, '0', STR_PAD_LEFT);
    $rowsHtml .= "<tr>
                    <td class='results-table' style='text-align: center;'>" . $controlNumber . "</td>
                    <td class='results-table'>" . $row['admission_Program'] . "</td>
                  </tr>";

    // $id = str_pad($row['admission_ID'], 5, '0', STR_PAD_LEFT);
    // $rowsHtml .= "<tr>
    //                 <td class='results-table' style='text-align: center;'>" . $id . "</td>
    //                 <td class='results-table'>" . $row['admission_Email'] . "</td>
    //               </tr>";
}
$sy = date("Y") . '-' . (date("Y") + 1);

$html = str_replace([
    "{{ sy }}",
    "{{ rows }}"
], [
    $sy,
    $rowsHtml
], $html);

$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->addInfo("Title", $_SESSION['admission_LastName'] . ', ' . $_SESSION['admission_FirstName'] . ' ' . $_SESSION['admission_MiddleName'] . ' ' . $_SESSION['admission_Suffix'] . ' - Application Form');
$dompdf->stream("CvSU_Application_Form.pdf", [
    "Attachment" => false,
]);
