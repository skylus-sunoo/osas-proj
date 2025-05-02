<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission</title>
    <link rel="stylesheet" href="../../../assets/css/public_admission.css">
</head>

<body class="admission-body">
    <main class="public-main">
        <header class="public-header">
            <h2>FIRST SEMESTER SY 2025-2026 APPLICATION FOR ADMISSION</h2>
            <h4><i>ADMISSION >> FIRST SEMESTER SY 2025-2026 APPLICATION FOR ADMISSION</i></h4>
            <hr>
        </header>

        <div class="container">
            <img src="../../../assets/img/application_for_admission_1.png" alt="application for admission">
            <img src="../../../assets/img/application_for_admission_2.png" alt="application for admission">
            <div class="font-NotoSans">
                <h2> <b> APPLICATION FOR ADMISSION for FIRST SEMESTER S.Y. 2025-2026 in CAVITE STATE UNIVERSITY
                        begins on NOVEMBER 18, 2024. SCAN THE QR CODE OR FOLLOW THE LINK TO APPLY
                        <br> <br>
                        Start of Application: November 18, 2024. <br> <br>
                        CvSU MAIN CAMPUS: </b> </h2>
                <p> <a href="https://admission.cvsu.edu.ph/"> https://admission.cvsu.edu.ph/ </a> <br> <br>
                    For more information, please read and follow the instructions in the photos provided.
                    To know more about Frequently Asked Questions, check this link below:
                    <a href="https://www.facebook.com/CaviteStateU/posts/pfbid035fkefvY6sxfFLyEpA8m3F7XqZLQV936fzsixdZ1tn5jB1q8kv8G8pDur1eypa5aVl">https://www.facebook.com/CaviteStateU</a>
                    <br> <br>
                </p>
                <h4>
                    <a href="/admission/enrollment"><button type="submit" class="primary-button" onclick="handleEnrollClick()"><b>ENROLL NOW!</b></button></a>
                </h4>
            </div>
        </div>

        <!-- <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3>Please log in first</h3>
                <p>You need to be logged in to continue with the enrollment.</p>
                <a href="/login"><button>Login</button></a>
            </div>
        </div> -->

        <script>
            function handleEnrollClick() {
                var isLoggedIn = <?php echo json_encode($loggedIn); ?>;
                if (isLoggedIn) {
                    document.getElementById('enrollForm').submit();
                } else {
                    document.getElementById('loginModal').style.display = 'block';
                }
            }

            function closeModal() {
                document.getElementById('loginModal').style.display = 'none';
            }

            // Optional: Close modal on click outside
            window.onclick = function(event) {
                var modal = document.getElementById('loginModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
    </main>
</body>

</html>