<?php if(isset($_SESSION["username"])) 
    echo "<script>location.href=\"index.php\"</script>";
?>


<header class="bg-dark text-white header" style="padding:2rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-users" style="color:#27aae1;"></i>Manage Admins</h1>
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
        <div class="col offset-lg-2 col-lg-8">
            <form id ="form" method="post">
                <div class="card bg-dark">
                    <div class="card-header badge-secondary">
                        <h1 class="new-category">Sign up!</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title"><span class="text-warning"><p>Username</p></span></label>
                            <input id="input" class="form-control" type="text"  name="username" placeholder="Username" required/>
                            <label for="title"><span class="text-warning"><p>Name</p></span></label>
                            <input id="input" class="form-control" type="text"  name="name" placeholder="Name"/>
                            <small style="color:whitesmoke;font-weight:bold;">(optional)</small>
                            <br>
                            <label for="title"><span class="text-warning"><p>Password</p></span></label>
                            <input id="input" class="form-control" type="password"  name="password" placeholder="Password" required/>
                            <label for="title"><span class="text-warning"><p>Confirm Passwrod</p></span></label>
                            <input id="input" class="form-control" type="password"  name="confirm" placeholder="Password again" required/>
                            <div class="row">
                                <div class="col lg-6 mt-2">
                                    <a href="cms.php?pages=dashboard.php" class="mt-2 btn btn-danger btn-block"><p><i class="fas fa-arrow-left"></i>Back to dashboard</p></a href="">
                                </div>
                                <div class="col lg-6 mt-2">
                                    <button id="submit" type="submit" name="submit" class="mt-2 btn btn-success btn-block"><p>Create admin<i class="fas fa-check"></i></p></button href="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php

if(isset($_POST["submit"])){
    if(strlen($_POST["username"]) <=2 || strlen($_POST["username"]) > 25 ){
        $name_error = "The name must have at least 2 characters and a maximum of 25 characters";
    }else  $name_error = false;
    if(!preg_match($pattern, $_POST["password"])){
        $password_error = "The password must have at least 8 characters, one upper case, one lower case, one special character, one numerical and a maximun of 15 characters";
    }else $password_error=false;
    if($_POST["confirm"] != $_POST["password"]){
        $confirm_error= "The password are not equal";
    }else $confirm_error=false;
    $username = $_POST["username"];
    $query = "SELECT * FROM Admins WHERE username=\"${username}\"";
    $check_admin = new Admin();
    $check = $check_admin->search($query);
    if($check != null) $username_error = "The username already exist. Choose other";
    else $username_error=false;
    if($name_error == false && $password_error == false && $confirm_error==false && $username_error==false ){
        $admin = new Admin($_POST["username"], $_POST["password"], $_POST["name"], "check", get_time());
        $admin->insert();
        echo "<script>
        const msg = document.getElementById(\"display-msg\")
        msg.className =\"container-fluid alert alert-info col-lg-8\"
        msg.textContent =\"Solicitude to become an admin send. You must wait for someone to accept you\"
        </script>";
    }
    else{
        echo "<script>
            const msg = document.getElementById(\"display-msg\");
            const p1= document.createElement(\"p\");
            const p2= document.createElement(\"p\");
            const p3= document.createElement(\"p\");
            const p4= document.createElement(\"p\");
            msg.className=\"container-fluid alert alert-danger col-lg-8 mt-2\";
            p1.textContent = \"${name_error}\";
            p2.textContent = \"${password_error}\";
            p3.textContent = \"${confirm_error}\";
            p4.textContent = \"${username_error}\";
            msg.appendChild(p1);
            msg.appendChild(p2);
            msg.appendChild(p3);
            msg.appendChild(p4);
            msg.style.display =\"inherit\";
        </script>";
    }
}
?>

<script>