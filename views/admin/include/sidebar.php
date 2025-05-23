<head>
    <link rel="stylesheet" href="../../../assets/css/admin_sidebar.css">
</head>

<aside id="sidebar">
    <!-- <div id="sidebar-header">
        <img src="../assets/img/logo.png" alt="logo">
        <h2>H</h2>
    </div> -->
    <ul id="sidebar-links">
        <h4>
            <span>Main Menu</span>
            <div class="menu-separator"></div>
        </h4>
        <li>
            <a href="/admin/home" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">dashboard</span>
                Dashboard
            </a>
        </li>
        <li>
            <a href="/admin/news" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">breaking_news</span>
                News
            </a>
        </li>
        <h4>
            <span>Admissions</span>
            <div class="menu-separator"></div>
        </h4>
        <li>
            <a href="/admissions/overview" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">person_book</span>
                Overview
            </a>
        </li>
        <li>
            <a href="/admissions/requirements" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">checklist</span>
                Requirements
            </a>
        </li>
        <li>
            <a href="/admissions/examinations" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">assignment</span>
                Examinations
            </a>
        </li>
        <li>
            <a href="/incidents/overview" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">gavel</span>
                Incidents
            </a>
        </li>
        <li>
            <a href="#" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">calendar_month</span>
                Events
            </a>
        </li>
        <h4>
            <span>Account</span>
            <div class="menu-separator"></div>
        </h4>
        <li>
            <a href="home_profile.php" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">account_circle</span>
                Profile
            </a>
        </li>
        <li>
            <a href="#" class="font-teko">
                <span class="font-MaterialSymbolsOutlined">approval_delegation</span>
                Requests
            </a>
        </li>
        <li>
            <a href="#" class="font-teko" id="btn-logout">
                <span class="font-MaterialSymbolsOutlined">logout</span>
                Logout
            </a>
        </li>
    </ul>
    <div id="sidebar-user-account">
        <!-- <div id="sidebar-user-profile">
            <img src="data:image/png;base64,<?php echo $_SESSION['user_Picture']; ?>" id="sidebar-profile" alt="Profile Picture">
            <div id="sidebar-user-detail">
                <h4 class="font-teko"><?php echo $_SESSION['user_FullName']; ?></h4>
                <p class="font-teko"><?php echo $_SESSION['user_Email']; ?></p>
            </div>
        </div> -->
    </div>
</aside>

<script type="text/javascript">
    document.getElementById("btn-logout").addEventListener("click", function(event) {
        event.preventDefault();

        const userConfirmed = confirm("Are you sure you want to log out?");

        if (userConfirmed) {
            window.location.href = "/admin/logout";
        } else {
            return false;
        }
    });
</script>