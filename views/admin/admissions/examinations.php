<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OSAS</title>

    <link rel="stylesheet" href="../../../assets/css/admin_examinations.css">
    <link rel="stylesheet" href="../../../assets/css/admin_styles.css">
    <style>
    </style>
</head>

<body class="admin-body">
    <main class="admin-main">
        <div class="admin-heading">
            <h1>Examinations</h1>
        </div>
        <hr>

        <div class="tabs">
            <button id="tab1" class="active">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">calendar_month</span>&nbsp; Exam Dates</div>
            </button>
            <button id="tab2">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">assignment_turned_in</span>&nbsp; Exam Results</div>
            </button>
            <button id="tab3">
                <div class="flex-center"><span class="font-MaterialSymbolsOutlined">description</span>&nbsp; Reports</div>
            </button>
        </div>

        <div class="tab-content admin-exam-dates" id="admin-exam-dates">
            <div class="admin-examinations-set">
                <form action="/admissions/exam_create" method="post">
                    <div class="admin-form-group" style="flex-direction: row;">
                        <input class="admin-input" type="date" name="exam_DateCalendar" required>
                        <select name="exam_DateMeridiem" class="admin-select" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        <input class="admin-input" type="number" name="exam_Capacity" placeholder="Insert capacity" required>
                        <button type="submit" class="primary-button">Set Exam Date</button>
                    </div>
                </form>
            </div>

            <?php
            $controller->renderExamTable();
            ?>
        </div>

        <div class="tab-content admin-exam-results" id="admin-exam-results">
            <div class="admin-examinations-set">
                <form action="/admissions/exam_results?results=true" method="post">
                    <div class="admin-form-group" style="flex-direction: row;">
                        <input class="admin-input" type="date" name="exam_DateCalendar" required>
                        <select name="exam_DateMeridiem" class="admin-select" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                        <button type="submit" class="primary-button">Search</button>
                    </div>
                </form>
            </div>


            <?php
            $controller->renderExamBatch();
            ?>
        </div>

        <div class="tab-content admin-exam-reports" id="admin-exam-reports">
            <div class="admin-examinations-set">
                <h3>Generate Reports</h3>
                <p class="admin-notification">PDF will include application codes and their assigned programs. Names are excluded for privacy.</p>
                <br>
                <form action="/admissions/exam_reports?download=true" method="post" target="_blank">
                    <button type="submit" class="primary-button" style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="font-MaterialSymbolsOutlined">picture_as_pdf</span>Generate PDF of Passed Students
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script>
        // JavaScript for tab switching
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tabs = [{
                    tabId: 'tab1',
                    contentId: 'admin-exam-dates'
                },
                {
                    tabId: 'tab2',
                    contentId: 'admin-exam-results',
                    condition: 'results'
                },
                {
                    tabId: 'tab3',
                    contentId: 'admin-exam-reports',
                    condition: 'reports'
                }
            ];

            // Determine active tab based on URL parameter
            const activeTab = tabs.find(tab => tab.condition && urlParams.has(tab.condition)) || tabs[0];

            function setActiveTab(selectedTabId, selectedContentId) {
                tabs.forEach(({
                    tabId,
                    contentId
                }) => {
                    document.getElementById(tabId).classList.toggle('active', tabId === selectedTabId);
                    document.getElementById(contentId).classList.toggle('active', contentId === selectedContentId);
                });
            }

            setActiveTab(activeTab.tabId, activeTab.contentId);

            // Add event listeners for tab switching
            tabs.forEach(({
                tabId,
                contentId
            }) => {
                document.getElementById(tabId).addEventListener('click', () => {
                    setActiveTab(tabId, contentId);
                });
            });
        });
    </script>

</body>

</html>