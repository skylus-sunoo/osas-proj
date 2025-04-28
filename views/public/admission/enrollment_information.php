<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment</title>
    <link rel="stylesheet" href="../../../assets/css/public_enrollment.css">
</head>

<body class="enrollment-body">
    <main class="public-main">
        <header class="public-header">
            <h2>ENROLLMENT</h2>
            <h4><i>ADMISSION >> ENROLLMENT FORM</i></h4>
            <hr>
        </header>

        <div class="enrollment-information">
            <div class="enrollment-information-branch">
                <h1><?= $_SESSION['branch'] ?></h1>
                <form action="/admission/enrollment" method="POST">
                    <input type="hidden" name="branchReset" value="true">
                    <button type="submit">Change Branch</button>
                </form>
            </div>

            <form action="" method="POST">
                <br> <br>

                <div class="enrollement-information-entry">
                    <h4> Entry </h4>
                    <select name="enrollement-information-entry" class="">
                        <option value=""></option>
                        <option value="New">New</option>
                        <option value="Transferee">Transferee</option>
                        <option value="2nd Courser">2nd Courser</option>
                        <option value="TCP ">TCP</option>
                    </select>
                </div>

                <div class="entry-new enrollement-information-strand">
                    <h4> SHS Strand </h4>
                    <select name="enrollement-information-strand">
                        <option value=""></option>
                        <option value="STEM">STEM</option>
                        <option value="ICT">ICT </option>
                        <option value="HUMSS">HUMSS</option>
                        <option value="GAS">GAS</option>
                        <option value="ABM">ABM</option>
                        <option value="HE">HE</option>
                    </select>
                </div>

                <div class="entry-new enrollement-information-typeStudent">
                    <h4> Type of New Student </h4>
                    <select name="enrollement-information-typeStudent">
                        <option value=""></option>
                        <option value="GR12">Grade 12 Student</option>
                        <option value="SHS">SHS Graduate</option>
                        <option value="ALS">ALS Passer</option>
                        <option value="DEGREE">Associate Certificate, Vocational, or Diploma Degree Holder</option>
                    </select>
                </div>

                <div class="entry-new enrollement-information-LRN">
                    <h4> Learner Reference Number </h4>
                    <input type="number" name="enrollement-information-LRN">
                </div>


                <div class="enrollement-information-typeApplicant">
                    <h4> Applicant Type </h4>
                    <select name="enrollement-information-typeApplicant">
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

    </main>
</body>

</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entrySelect = document.querySelector('select[name="enrollement-information-entry"]');
        const entryNewDivs = document.querySelectorAll('.entry-new');
        const typeStudentInput = document.querySelector('select[name="enrollement-information-typeStudent"]');

        function toggleEntryNewFields() {
            const entryValue = entrySelect.value;

            // Show/hide .entry-new sections
            entryNewDivs.forEach(div => {
                const shouldShow = entryValue === "New" || entryValue === "";
                div.style.display = shouldShow ? 'block' : 'none';

                if (!shouldShow) {
                    // Clear all input/select/textarea fields inside the hidden div
                    const inputs = div.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        if (input.type === 'checkbox' || input.type === 'radio') {
                            input.checked = false;
                        } else {
                            input.value = "";
                        }
                    });
                }
            });

            // Set value and disable input if value is empty
            if (entryValue === "") {
                typeStudentInput.value = "";
                typeStudentInput.setAttribute('disabled', 'disabled');
            } else {
                typeStudentInput.removeAttribute('disabled');
            }
        }

        toggleEntryNewFields();

        entrySelect.addEventListener('change', toggleEntryNewFields);
    });
</script>