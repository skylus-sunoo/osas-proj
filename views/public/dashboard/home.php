<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CVSU Silang</title>
    <link rel="stylesheet" href="../../../assets/css/public_home.css">
    <style>
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body class="public-body font-NotoSans">
    <main class="public-main home-main">
        <div class="home-admissions">
            <div class="home-admission-card">
                <h3>Admission Requirements and Procedures</h3>

                <input type="checkbox" id="toggle-read-more-1" class="read-more-toggle">

                <p>
                    ADMISSION PROCEDURES: Senior high graduate and ALS passers undergo online application using the link
                    (<a href="https://registrar.cvsu.edu.ph/osas/" target="_blank">https://registrar.cvsu.edu.ph/osas/</a>)
                    to encode completely the needed information in the application form. Ensure that all sections are
                    <span class="dots">...</span>
                    <span class="more-text">
                        completed accurately and thoroughly. Provide all necessary details as requested, double-check for any errors or omissions, and follow any specific instructions indicated on the form. Incomplete or incorrect entries may delay the processing of your application or result in disqualification. Once the form has been properly accomplished, print the completed version on standard A4 paper. Make sure the printout is clear and legible. Prepare the printed form along with any required supporting documents, such as identification, certificates, or photographs, and follow the designated submission procedures.
                    </span>

                <div class="button-container">
                    <label for="toggle-read-more-1" class="read-more-label primary-button"></label>
                </div>

            </div>

            <div class="home-admission-card">
                <h3>Admission Requirements and Procedures</h3>

                <input type="checkbox" id="toggle-read-more-2" class="read-more-toggle">

                <p>
                    ADMISSION PROCEDURES: Senior high graduate and ALS passers undergo online application using the link
                    (<a href="https://registrar.cvsu.edu.ph/osas/" target="_blank">https://registrar.cvsu.edu.ph/osas/</a>)
                    to encode completely the needed information in the application form. Ensure that all sections are
                    <span class="dots">...</span>
                    <span class="more-text">
                        completed accurately and thoroughly. Provide all necessary details as requested, double-check for any errors or omissions, and follow any specific instructions indicated on the form. Incomplete or incorrect entries may delay the processing of your application or result in disqualification. Once the form has been properly accomplished, print the completed version on standard A4 paper. Make sure the printout is clear and legible. Prepare the printed form along with any required supporting documents, such as identification, certificates, or photographs, and follow the designated submission procedures.
                    </span>
                </p>

                <div class="button-container">
                    <label for="toggle-read-more-2" class="read-more-label primary-button"></label>
                </div>
            </div>
        </div>

        <aside class="home-news">
            <h2>LATEST NEWS</h2>

            <?php
            $controller->showLatestNews();
            ?>
        </aside>
    </main>
</body>

</html>