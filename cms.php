<?php
require_once("includes/date.php");
session_start();

function check_login(){
    if(isset($_SESSION["username"])){
        return true;
    }else{
        $_SESSION["no_log"] = true;
        echo "<script>
        location.href=\"pages/login.php\";
        </script>
        ";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="css/categories.css" />
    <link rel="stylesheet" href="css/profile.css" />
    <title>CMS</title>
</head>

<body>

    <nav class="navbar nab navbar-expand-lg bg-dark navbar-dark navbar-navbar">
        <a class="pl-2 navbar-brand" href="index.php?pages=categories">
            <h1 class="home-title">CMS <i class="fas fa-copyright"></i></h1>
        </a>
        <div class="container-fluid container-navbar">
            <button class="navbar-toggler burger-button" data-toggle="collapse" data-target="#collapse-id">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapse-id">
                <ul class="navbar-nav ul-container">
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=profile">
                            <h2>My Profile <i class="icon-a fa fa-user-circle"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=dashboard">
                            <h2>Dashboard <i class="icon-a fa fa-blog"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=post">
                            <h2>Posts <i class="icon-a fa fa-folder-plus"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=categories">
                            <h2>Categories <i class="icon-a fa fa-star"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=manage_admins">
                            <h2>Manage Admins <i class="icon-a fa fa-users"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="cms.php?pages=manage_comments">
                            <h2>Comments <i class="icon-a fa fa-comments"></i></h2>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="home-anchor navbar-link mr-auto ml-4" href="index.php?pages=home">
                            <h2>Live posts <i class="icon-a fa fa-star"></i></h2>
                        </a>
                    </li>
                   
                </ul>
                <a class="navbar-end navbar-brand ml-6" href="cms.php?pages=logout">
                    <h2 class="logout">Logout <i class="icon-a fa fa-user-times text-danger"></i></h2>
                </a>
            </div>
        </div>
    </nav>


    <?php
    if (isset($_GET["pages"])) {
        $page_name = $_GET["pages"];
        $page_directory = scandir("pages", 0);
        unset($page_directory[0], $page_directory[1]);
        if (in_array($page_name . ".php", $page_directory)) {
            include("pages/" . $page_name . ".php");
        } else {
            include("pages/notFound.php");
        }
    } else {
        include("pages/dashboard.php");
    }
    ?>

    &nbsp;
    &nbsp;
    &nbsp;
    &nbsp;
    <footer id="footer" class="bg-dark text-white">
        <div class="container-fluid">
            <div class="row mt-2 mb-3">
                <div class="col">
                    <h2 class="text-center">Theme by Webins &copy; All right reserved <span id="date"></span></h2>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="container-fluid container-footer">
                        <li class="ml-4">
                            <a href="#">
                                <h2>Twitter <i class="icon-a fa fa-facebook text-info"></i></h2>
                            </a>
                        </li>
                        <li class="ml-4">
                            <a href="#">
                                <h2>Facebook <i class="icon-a fa fa-twitter text-info"></i></h2>
                            </a>
                        </li>
                        <li class="ml-4">
                            <a href="#">
                                <h2>Google <i class="icon-a fa fa-google text-info"></i></h2>
                            </a>
                        </li>
                        <li class="ml-4">
                            <a href="#">
                                <h2>Instagram <i class="icon-a fa fa-instagram text-info"></i></h2>
                            </a>
                        </li>
                        <li class="ml-4">
                            <a href="#">
                                <h2>Github <i class="icon-a fa fa-github text-info"></i></h2>
                            </a>
                        </li>

                    </div>
                </div>
            </div>
        </div>

    </footer>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/18f2a0b626.js" crossorigin="anonymous"></script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        document.getElementById("date").textContent = (new Date()).getFullYear();
    </script>
</body>

</html>