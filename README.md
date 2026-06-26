# OSAS Enrollment System

A comprehensive web-based enrollment and admission management system designed for Cavite State University (CvSU) Silang Campus. The system streamlines the application process for incoming students and provides administrators with robust tools to track, verify, and evaluate applications.

---

## Public Interface (Student Portal)

The public-facing portal is designed to guide prospective students through the university's admission process from start to finish.

### Core Features
* **Campus News:** Displays the latest announcements, news, and updates regarding CvSU Silang.
* **Application Tutorial:** A dedicated guide providing step-by-step instructions on the admission process.
* **Course Offerings:** A directory of academic programs currently available at the branch.

### Student Enrollment Workflow
1.  **Authentication:** The applicant signs into the system.
2.  **Data Entry:** The applicant completes the admission forms, which are categorized into Personal, Family, Educational, and Medical information.
3.  **Schedule Generation:** Upon successful form completion, the system provisions a unique **Control Number** and assigns a physical **Submission Schedule**.
4.  **Document Verification:** The applicant visits the campus on their designated schedule to submit required physical documents (e.g., application form).
5.  **Examination Phase:** The applicant is assigned an exam date and takes the entrance examination.
6.  **Results:** The applicant checks the portal for their final admission status (Passed/Failed).

---

## Administrator Interface

The admin side provides university staff with the necessary backend controls to manage the entire enrollment lifecycle efficiently.

### Admin Modules

| Module | Functionality Description |
| :--- | :--- |
| **Main Dashboard** | Provides a high-level overview of current enrollment metrics and system activities. |
| **Admission Tracking** | Displays a real-time list of applicants and the current status of their admission process. |
| **Requirements Management** | Allows staff to search for an applicant via their Control Number and manually update the system once physical documents are received. |
| **Examination Scheduling** | Enables admins to create exam dates, set venue capacities, and distribute schedules to verified applicants. |
| **Results Encoding** | The module where administrators input and update the final exam results for each student. |
| **Incident Reporting** | A logging functionality used to document and track any operational or system incidents that occur during the enrollment period. |
