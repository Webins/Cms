<?php
require_once("../Db/AdminsDb.php");
session_start();
if (isset($_SESSION["username"])) {
    echo "<script> history.back(); </script>";
}
if (isset($_SESSION["no_log"]) && $_SESSION["no_log"] == true) {
    $no_log = true;
}
?>
<?php
global $bad;
if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $query = "SELECT * FROM Admins  WHERE BINARY username=\"$username\" AND BINARY password=\"$password\"";
    $adm = new Admin();
    $exists = $adm->search($query);
    if ($exists != null) {
        session_start();
        $_SESSION["username"] = $exists[0]->get_username();
        $_SESSION["password"] = $exists[0]->get_password();
        $_SESSION["id"] = $exists[0]->get_id();
        unset($exists);
        echo "<script>
        const a = document.createElement(\"a\")
        a.href=\"../cms.php?pages=dashboard&user_log=true\";
        a.click();
        </script>";
        unset($_POST["submit"]);
    } else {
        $bad = true;
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
    <link rel="stylesheet" href="../css/index.css" />
    <link rel="stylesheet" href="../css/categories.css" />
    <title>Login</title>
</head>

<body>

    <nav class="navbar nab navbar-expand-lg bg-dark navbar-dark navbar-navbar">
        <a class="pl-2 navbar-brand" href="index.php">
        <h1 class="home-title">CMS <i class="fas fa-copyright"></i></h1>
        </a>
    </nav>


    <header class="bg-dark text-white header" style="padding:2rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1>Login <i class="fas fa-sign-in-alt" style="color:#27aae1;"></i></h1>
                </div>
            </div>
        </div>
    </header>




    <section class="container-fluid py-2 mb-4">
        <center>
            <div id="display-msg">
            </div>
        </center>

        </div>
        <div class="row mt-4">
            <div class="col offset-lg-3 col-lg-6">
                <form id="form" method="post">
                    <div class="card bg-dark">
                        <div class="card-header badge-secondary">
                            <h1 class="new-category ">Welcome Back!</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title"><span class="text-warning">
                                        <p>Username</p>
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <small class="input-group-text text-white bg-info"><i class="fas fa-user"></i></small>
                                    </div>
                                    <input id="input" class="form-control" type="text" name="username" placeholder="Username" required />
                                </div>
                                <label for="title"><span class="text-warning">
                                        <p>Password</p>
                                    </span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <small class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></small>
                                    </div>
                                    <input id="input" class="form-control" type="password" name="password" placeholder="Password" required />

                                    <button type="submit" name="submit" class="mt-3 btn btn-block btn-primary">Login</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

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
    <script src="includes/javascript.js"></script>
</body>

</html>



<?php
if (isset($bad) && $bad == true) {
    echo "<script>
            const msg = document.getElementById(\"display-msg\");
            msg.className=\"container-fluid alert alert-danger col-lg-8\";
            msg.textContent = \"The username or password are incorrect\";
            msg.style.display =\"inherit\";
            </script>";
    unset($bad);
} else if (isset($no_log) && $no_log == true) {
    echo "<script>
            const msg = document.getElementById(\"display-msg\");
            msg.className=\"container-fluid alert alert-danger col-lg-8\";
            msg.textContent = \"Login first!\";
            msg.style.display =\"inherit\";
            </script>";
    unset($no_log);
}

?>