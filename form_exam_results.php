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
            c.admission_Result = 'PASSED'
        ORDER BY 
            c.admission_ID DESC";

// $sql = "SELECT * FROM tb_admission_user;";

$results = runQuery($sql);

date_default_timezone_set('Asia/Manila');

$html = file_get_contents("form_exam_results.html");

$rowsHtml = '';
foreach ($results as $row) {
    $controlNumber = str_pad($row['admission_ControlNumber'], 5, '0', STR_PAD_LEFT);

    $programNames = [
        'BSCS' => 'Bachelor of Science in Computer Science',
        'BSIT' => 'Bachelor of Science in Information Technology',
        'BSCE' => 'Bachelor of Early Childhood Education',
        'BSE_ENGLISH' => 'Bachelor of Secondary Education Major in English',
        'BSE_MATH' => 'Bachelor of Secondary Education Major in Mathematics',
        'BSE_SCIENCE' => 'Bachelor of Secondary Education Major in Science',
        'BSBA_FIN' => 'Bachelor of Science in Business Administration Major in Finance',
        'BSBA_MARKETING' => 'Bachelor of Science in Business Administration Major in Marketing Management',
        'BSBA_HR' => 'Bachelor of Science in Business Administration Major in Human Resource Management',
        'BSHM' => 'Bachelor of Science in Hospitality Management',
        'BSTM' => 'Bachelor of Science in Tourism Management',
        'BSPSY' => 'Bachelor of Science in Psychology',
    ];
                                
    $row['admission_Program'] = $programNames[$row['admission_Program']] ?? 'Unknown Program';

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
$dompdf->addInfo("Title", 'LIST OF QUALIFIED APPLICANTS OF CVSU SILANG CAMPUS FOR ACADEMIC YEAR ' . $sy);
$dompdf->stream("CvSU_Application_Form.pdf", [
    "Attachment" => false,
]);
