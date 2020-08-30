<?php 
check_login();
require_once("Db/AdminsDb.php");
require_once("includes/date.php");
$admin = new Admin();
if (isset($_COOKIE["delete_admin"]) && $_COOKIE["delete_admin"] != null) {
    $id = $_COOKIE["delete_admin"];
    setcookie("delete_admin", null, 1);
    $admin->delete($id);
    $_SESSION["delete_adm"] = true;
}
$query = "SELECT * FROM Admins";
$arr = $admin->search($query);
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                        <h1 class="new-category">Add new Admin</h1>
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
    <br>
    <br>
    <?php echo "<center><div class=\"badge badge-info\"> <h1>Existing Admins</h1> </div></center><br><hr>";?>
    <div class="container-fluid">
        <table class="table table-stripped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <h2 class="font-weight-bold text-center">No.</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Username</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Name</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Added By</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Date</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Delete</h2>
                    </th>
                </tr>
                <?php
                $i = 1;
                foreach ($arr as $obj) {
                    $id = $obj->get_id();
                    echo "<tr>";
                    echo "<td class=\"td-table text-center number\"><p>${i} </p></td>";
                    echo "<td class=\"td-table text-center username\"><p>" . $obj->get_username() . "</p></td>";
                    echo "<td class=\"td-table text-center name\"><p>" . $obj->get_name() . "</p></td>";
                    echo "<td class=\"td-table text-center added\"><p>" . $obj->get_added_by() . "</p></td>";
                    echo "<td class=\"td-table text-center date\"><p>" . $obj->get_date(). "</p></td>";
                    echo "<td class=\"td-table text-center delete\">
                <button onclick=\"delete_admin(${id})\" class =\"btn btn-danger\" id=\"delete_cat\"><p>Delete</p></button>
                </td>";
                    echo "</tr>";
                    $i++;
                }
                ?>

            </thead>
            <thead class="thead-dark mb-4">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
        </table>
        <hr>
    </div>
<br>
<br>
</section>
<script src="includes/javascript.js"></script>

<?php 
    if(isset($_SESSION["delete_adm"]) && $_SESSION["delete_adm"] == true){
        $_SESSION["delete_adm"] = null;
        ?><script>
            const msg= document.getElementById("display-msg")
            msg.className="container-fluid alert alert-success col-lg-8 mt-2"
            const p = document.createElement("p")
            p.textContent = "Admin deleted Succesfully"
            msg.appendChild(p)
            msg.style.display="inherit"
        </script>
        <?php
    }
?>

<?php 
$pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W\_])[a-zA-Z0-9\W\_]{8,15}$/";
$pattern_name = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
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
            $admin = new Admin($_POST["username"], $_POST["password"], $_POST["name"], $_SESSION["username"], get_time());
            $admin->insert();
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
    function delete_admin(id) {
        swal({
                title: "Do you want to delete this admin?",
                text: "Once delete you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("We are going to delete this admin", {
                        icon: "success"
                    })
                    document.cookie = `delete_admin=${id}`
                    location.reload()
                } else {}
            });
    }
</script>