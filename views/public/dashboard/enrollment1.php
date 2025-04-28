<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="../../../assets/css/public_header.css">
</head>

<?php include_once('../include/header.php') ?>

<body>


    <div class="head">
        <h2> ENROLLMENT </h2>
        <h4> <i> ADMISSION >> CvSU CAMPUS  </i> </h4>
        <hr>
        <h2 style="padding-top:50px"> ADMISSION INFORMATION </h2>
        <hr>
    </div>

    <div class="branch white">
        <h4> BRANCH </h4>

        <form action="enrollment2.php" method="POST" style="padding-top: 30px" >
            <select name="branch" id="branch" style="width: 300px; height: 30px;">
                <option value="Indang Campus (Main Campus)">CvSU Indang Campus (Main Campus)</option>
                <option value="Bacoor Campus ">CvSU Bacoor Campus</option>
                <option value="Carmona Campus">CvSU Carmona Campus</option>
                <option value="Cavite City Campus">CvSU Cavite City Campus</option>
                <option value="Dasmarinas Campus">CvSU Dasmarinas Campus</option>
                <option value="General Trias Campus">CvSU General Trias Campus</option>
                <option value="Imus Campus">CvSU Imus Campus</option>
                <option value="Maragondon Campus">CvSU Maragondon Campus</option>
                <option value="Naic Campus">CvSUNaic Campus</option>
                <option value="Rosario Campus (CCAT)">CvSU Rosario Campus (CCAT)</option>
                <option value="Silang Campus">CvSU Silang Campus</option>
                <option value="Trece Martires Campus">CvSU Trece Martires Campus</option>
            </select>
            <br> <br>

            <button> <b> SAVE ADMISSION INFORMATION </b></button>
            
        </form>

    </div>

</body>

</html>