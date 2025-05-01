<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="../../../assets/css/public_enrollment.css">

    <style>
        
    </style>
</head>

<body class="enrollment-body">
    <main class="public-main">
        <header class="public-header">
            <h2>ENROLLMENT</h2>
            <h4><i>ADMISSION >> CvSU CAMPUS</i></h4>
            <hr>
            <!-- <h2 style="padding-top:50px"> ADMISSION INFORMATION </h2>
            <hr> -->
        </header>

        <div class="enrollment-branch">
            <h4> SELECT A BRANCH </h4>

            <form action="/admission/enrollment" method="POST">
                <select name="branch" id="branch">
                    <option value="Silang">CvSU Silang Campus</option>
                    <option value="Indang">CvSU Indang Campus (Main Campus)</option>
                    <option value="Bacoor">CvSU Bacoor Campus</option>
                    <option value="Carmona">CvSU Carmona Campus</option>
                    <option value="Cavite City">CvSU Cavite City Campus</option>
                    <option value="Dasmarinas">CvSU Dasmarinas Campus</option>
                    <option value="General Trias">CvSU General Trias Campus</option>
                    <option value="Imus">CvSU Imus Campus</option>
                    <option value="Maragondon">CvSU Maragondon Campus</option>
                    <option value="Naic">CvSU Naic Campus</option>
                    <option value="Rosario">CvSU Rosario Campus (CCAT)</option>
                    <option value="Trece Martires">CvSU Trece Martires Campus</option>
                </select>
                <br> <br>
                <button type="submit" class="primary-button"> <b> SAVE ADMISSION INFORMATION </b></button>
            </form>
        </div>
    </main>
</body>

</html>