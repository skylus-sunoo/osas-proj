<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Offered - Information Technology Programs</title>
    <style>
    body {
      margin: 0;
      background-color: #014421; /* Dark green */
      font-family: Arial, sans-serif;
      color: white;
    }
    .header {
      text-align: left;
      padding: 20px;
    }
    .header h1 {
      color: #ffcc00; /* Yellow heading */
      margin: 0;
      font-size: 30px;
    }
    .header p {
      margin-top: 5px;
      font-style: italic;
      font-size: 14px;
      color: white;
    }
    .department {
      text-align: center;
      padding: 20px 40px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .department h2 {
      color: #ffcc00;
      margin-bottom: 10px;
    }
    .department p {
      font-size: 16px;
      line-height: 1.5;
    }
    .programs {
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 30px;
      flex-wrap: wrap; /* wrap if screen too small */
    }
    .program {
      background-color: #0b3d2e;
      display: flex;
      align-items: center;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      width: 550px; /* fixed width for card */
      min-height: 250px; /* minimum height for consistency */
    }
    .program img {
      width: 200px;
      height: 100%;
      object-fit: cover;
    }
    .program-content {
      padding: 20px;
      text-align: left;
      flex: 1;
    }
    .program-content h3 {
      color: #ffcc00;
      margin-bottom: 15px;
      font-size: 20px;
    }
    .program-content p {
      font-size: 14px;
      line-height: 1.5;
    }
    @media (max-width: 1200px) {
      .programs {
        flex-direction: column;
        align-items: center;
      }
    }
    .breadcrumb p {
      margin: 5px;
      width: 70%; 
      border-bottom: 2px solid white; 
      padding-bottom: 10px;
    }     
    </style>
</head>
<body>
<div class="header">
  <h1>COURSE OFFERED</h1>
  <div class="breadcrumb">
  <p>ADMISSION >> COURSE OFFERED</p>
  </div>
</div>

<div class="department">
  <h2>DEPARTMENT OF INFORMATION TECHNOLOGY PROGRAMS</h2>
  <p>
    BSCS and BSIT programs are both comprehensive computer courses specifically designed to equip students with the knowledge, skills, and expertise necessary to thrive in the dynamic field of technology. From programming languages to networking fundamentals, both programs offer rigorous curricula tailored to prepare students for diverse career paths in the ever-evolving digital landscape.
  </p>
</div>

<div class="programs">
  <div class="program">
    <img src="students.png" alt="Bachelor of Science in Computer Science">
    <div class="program-content">
      <h3>Bachelor of Science in Computer Science</h3>
      <p>
        BSCS covers essential computer science principles, programming languages, mathematics, and practical skills. Furthermore, graduates emerge well-prepared for careers in software development, IT consulting, and related fields.
      </p>
    </div>
  </div>

  <div class="program">
    <img src="students.png" alt="Bachelor of Science in Information Technology">
    <div class="program-content">
      <h3>Bachelor of Science in Information Technology</h3>
      <p>
        BSIT focuses on the practical applications of technology in business and organizational settings. In addition, it includes coverage areas such as programming, databases, network administration, and technology oversight. Graduates are prepared for roles in IT management, system analysis, and technology support.
      </p>
    </div>
  </div>
</div>



</body>
</html>