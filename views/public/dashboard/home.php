<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVSU Silang - Admissions and News</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #005c2a, #a1d68b);
            margin: 0;
            padding: 20px;
            color: #ffffff;
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .admissions {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            flex: 2;
        }
        .news {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            flex: 1;
        }
        .admission-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .news h2 {
            margin-top: 0;
            color: #ffffff; 
            font-size: 18px;
            font-weight: bold;
            border-bottom: 2px solid #ffffff; 
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 0;
            color:white;
            font-size: 18px;
            font-weight: bold;
        }
        .admission-card h3 {
            margin-top: 0;
        }
        .admission-card p {
            font-size: 14px;
            line-height: 1.6;
        }
        .read-more {
            background: #ffcc00;
            color: #000;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
        }
        .news-item {
            margin-bottom: 20px;
            text-align: left;
        }
        .news-item img {
            width: 100%;
            height: auto;
            border-radius: 5px;
            display: block;
            margin-bottom: 10px;
        }
        .news-item h4 {
            margin-left: 0;
            margin-right: 0;
            padding: 0;
            text-align: left;
            font-size: 16px;
            margin: 5px 0;
            color:white;
            font-weight: bold;
        }
        .news-item p {
            margin-left: 0;
            margin-right: 0;
            padding: 0;
            text-align: left;
            font-size: 14px;
            line-height: 1.5;
            color:white;
            margin: 0;
        }
        .button-container{
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="admissions">
        <div class="admission-card">
            <h3>Admission Requirements and Procedures</h3>
            <p>
                ADMISSION PROCEDURES: Senior high graduate and ALS passers undergo online application using the link
                (<a href="https://registrar.cvsu.edu.ph/osas/" target="_blank" style="color:#ffcc00;">https://registrar.cvsu.edu.ph/osas/</a>)
                to encode completely the needed information in the application form. Print the accomplished form in...
            </p>
            <div class="button-container">
            <a class="read-more" href="#">READ MORE</a>
            </div>
        </div>

        <div class="admission-card">
            <h3>Admission Requirements and Procedures</h3>
            <p>
                ADMISSION PROCEDURES: Senior high graduate and ALS passers undergo online application using the link
                (<a href="https://registrar.cvsu.edu.ph/osas/" target="_blank" style="color:#ffcc00;">https://registrar.cvsu.edu.ph/osas/</a>)
                to encode completely the needed information in the application form. Print the accomplished form in...
            </p>
            <div class="button-container">
            <a class="read-more" href="#">READ MORE</a>
            </div>
        </div>
    </div>

    <div class="news">
        <h2>Latest News</h2>

        <div class="news-item">
            <img src="news.png" alt="News Image">
            <h4>CVSU reaps fourth ITSO Platinum Award</h4>
            <p>For the fourth consecutive year, Cavite State University (CvSU) - Innovation and Technology Support Office (ITSO) received the prestigious P</p>
        </div>

        <div class="news-item">
            <img src="news.png" alt="News Image">
            <h4>CVSU reaps fourth ITSO Platinum Award</h4>
            <p>For the fourth consecutive year, Cavite State University (CvSU) - Innovation and Technology Support Office (ITSO) received the prestigious Platinum Award during the 2025 ITSO Presidents’</p>
        </div>
    </div>
</div>
    
</body>
</html>