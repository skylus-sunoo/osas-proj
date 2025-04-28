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
        <h4> <i> ADMISSION >> ENROLLMENT FORM </i> </h4>
        <hr>
    </div>

    <div>
        <form action="" method="POST">
            <div>
                <h3> Preferred Course </h3> <!--campus na napili */-->
                <input type="text" id="submittedBranch" name="submittedBranch" value="CAMPUS NA NAPILI" readonly> <a href="enrollment1.php"> Change Branch </a>
                <br> <br>
                <h4> Entry </h4>
                <select name="entry" id="entry">
                    <option value=""></option>
                    <option value="New">New</option>
                    <option value="Transferee  ">Transferee </option>
                    <option value="2nd Courser">2nd Courser</option>
                    <option value="TCP ">TCP</option>
                </select>
                <h4> SHS Strand </h4>
                <select name="shsStrand" id="shsStrand">
                    <option value=""></option>
                    <option value="STEM">New</option>
                    <option value="ICT  ">Transferee </option>
                    <option value="HUMSS">2nd Courser</option>
                    <option value="GAS">TCP</option>
                    <option value="ABM">TCP</option>
                    <option value="HE">TCP</option>
                </select>
            </div>
            <div>
                <h4> Type of New Student </h4>
                <input type="text" id="studentType" name="studentType" value="STUDENT TYPE DEPENDE SA ENTRY" readonly>
                <h4> Learner Reference Number </h4>
                <input type="text" id="LRN" name="LRN">
            </div>
            <div>
                <h4> Applicant Type </h4>
                <select name="entry" id="entry">
                    <option value=""></option>
                    <option value="ALS">Alternative Learning System (ALS) Passer</option>
                    <option value="Fore  ">Foreign Undergraduate Student Applicant </option>
                    <option value="2nd Courser">Senior High School Graduate </option>
                    <option value="TCP ">Currently Enrolled Grade 12 Student</option>
                    <option value="TCP ">Bachelor's Degree Graduate </option>
                    <option value="TCP ">Teacher Certificate Program Applicant</option>
                    <option value="TCP ">Transferee</option>
                    <option value="TCP ">Diploma/Certificate/Associate/Vocational Graduate</option>
                </select>
            </div>




            <br> <br>

            <h3> Preffered Course </h3> <!--dapat kung anong course lang meron ung campus */-->
            <h4> Program Name </h4>

            <select name="entry" id="entry">
                <option value=""></option>
                <option value="New">New</option>
                <option value="Transferee  ">Transferee </option>
                <option value="2nd Courser">2nd Courser</option>
                <option value="TCP ">TCP</option>
            </select>

        </form>

    </div>


</body>

</html>