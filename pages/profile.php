<?php
check_login();
require_once("Db/AdminsDb.php");
require_once("Db/PostDb.php");
require_once("Db/CommentsDb.php");
require_once("includes/date.php");
global $user;
if (isset($_GET["user"])) {
    $user = $_GET["user"];
} else {
    $user = $_SESSION["username"];
}
$admin = new Admin();
$query = "SELECT * FROM Admins WHERE username=\"${user}\"";
$arr = $admin->search($query);
$date = $arr[0]->get_date();
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<header class="bg-dark text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_GET["user"])) {
                ?>
                    <h1><i class="fas fa-users" style="color:#27aae1;"></i> Profile</h1>
                <?php } else { ?>
                    <h1><i class="fas fa-users" style="color:#27aae1;"></i> My profile</h1>
                <?php } ?>
            </div>
        </div>
    </div>
</header>
<section class="container-fluid py-2 mb-4">
    <center>
        <div id="display-msg">
        </div>
    </center>
    <?php
    if ($arr == null) {
        echo "<script>
        const msg = document.getElementById(\"display-msg\");
        const p1= document.createElement(\"p\");
        msg.className=\"container-fluid alert alert-danger col-lg-8 mt-2\";
        p1.textContent = \"There is not user named ${user}\";
        msg.appendChild(p1);
        msg.style.display =\"inherit\";
        </script>";
    }
    ?>
    </div>
    <div class="row mt-4">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header bg-dark text-light float-">
                    <h1><?php echo $user; ?></h1>
                </div>
                <div class="card-body">
                    <?php if ($arr[0]->get_image() != null) {
                        $src = "./uploads/".$arr[0]->get_image();
                    } else $src = "assets/user.svg";
                    if ($arr[0]->get_description() != null) {
                        $description_src = $arr[0]->get_description();
                    } else $description_src = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem enim esse unde
                illo ducimus eius aspernatur error ipsam magnam dolorem mollitia velit recusandae facere ab
                vitae quos, et voluptatem dolorum.";
                    ?>
                    <img class="block mb-3 img-fluid" src="<?php echo $src; ?>" alt="user" />
                   
                    <div class="container">
                        <?php if ($arr[0]->get_headline() != null) {
                        echo "<h1 class=\"badge badge info\" style=\"font-size:1.2vw;\">".$arr[0]->get_headline()."</h1>";
                    } ?>
                        <p>
                            <?php echo $description_src; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($_GET["user"]) && $arr != null) {
        ?>

            <div class="col col-lg-8 my-auto">
                <div class="alert alert-dark bg-dark text-center">
                    <h1 class="text-white" >
                    Profile 
                    
                    <i class="fas fa-user" ></i></div>
                </h1>
                <div class="row" style="margin-top:2rem;">
                    <div class="col-lg-6">
                        <div class="card text-center bg-primary text-white">
                            <div class="card-body my-auto">
                                <h1 style="font-size:1.6vw; line-height:4rem;" class="badge badge-pill">Posts Added
                                    <h1 style="font-size:3vw;" class=""><i class="fab fa-readme">
                                            <?php
                                            $post_count = new Post();
                                            $query = "SELECT * FROM Posts WHERE author=\"${user}\"";
                                            $arr = $post_count->search($query);
                                            $arr == null ?  $var = "0" : $var = count($arr);
                                            echo $var;
                                            ?>
                                        </i></h1>
                                </h1>

                                <br><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body my-auto  ">
                                <h1 style="font-size:1.6vw; line-height:4rem;" class="badge badge-pill">Comments Approved
                                    <h1 style="font-size:3vw;" class=""><i class="fas fa-comment">
                                            <?php
                                            $comments_count = new Comment();
                                            $query = "SELECT * FROM Comments WHERE approved_by=\"${user}\"";
                                            $arr = $comments_count->search($query);
                                            $arr == null ?  $var = "0" : $var = count($arr);
                                            echo $var;
                                            ?>

                                        </i></h1>
                                </h1>

                                <br><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center " style="margin-top:4rem;">
                        <h1 class="badge badge-info" style="font-size:1.6vw;"> Registered in <?php echo $date; ?></h1>
                    </div>
                </div>
            <?php } else {
            ?>
                <div class="col col-lg-8 my-auto">
                    <form id="form" method="post" enctype="multipart/form-data">
                        <div class="card bg-dark">
                            <div class="card-header badge-secondary">
                                <h1 class="new-category">Edit profile <i class="fas fa-user"></i></h1>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title"><span class="text-warning">
                                            <p>Name</p>
                                        </span></label>
                                    <input id="input" class="form-control" type="text" value="<?php echo $arr[0]->get_name()!=null?htmlentities($arr[0]->get_name()):""; ?>" name="name" placeholder="Name" />
                                    <br>
                                    <label for="title"><span class="text-warning">
                                            <p>Headline</p>
                                        </span></label>
                                    <input id="" class="form-control" type="text" name="headline" value="<?php echo $arr[0]->get_headline()!=null?htmlentities($arr[0]->get_headline()):""; ?>" placeholder="Headline" />

                                    <label for="title"><span class="text-warning">
                                            <p>Description</p>
                                        </span></label>
                                    <textarea id="" class="form-control" type="text" name="description"  placeholder="Description"><?php echo $arr[0]->get_description()!=null?htmlentities($arr[0]->get_description()):""; ?></textarea>

                                    <label for="title"><span class="text-warning">
                                            <p>Old password</p>
                                        </span></label>
                                    <input id="" class="form-control" type="password" name="old_pass" placeholder="Old password" />
                                    <label for="title"><span class="text-warning">
                                            <p>New Password</p>
                                        </span></label>
                                    <input id="" class="form-control" type="password" name="new_pass" placeholder="New password" />
                                    <label for="title"><span class="text-warning">
                                            <p>Confirm Password</p>
                                        </span></label>
                                    <input id="" class="form-control" type="password" name="confirm" placeholder="Confirm password" />

                                    <div class="form-group mt-4">
                                        <label for="title"><span class="text-warning">
                                                <p>Profile picture</p>
                                            </span></label>
                                        <div class="custom-file">
                                            <label id="label-img" class="custom-file-label" for="image"><span class="text-info"><?php echo $arr[0]->get_image()!=null?htmlentities($arr[0]->get_image()):"Select Image"; ?></span></label>
                                            <input id="img-input" accept="image/*" class="custom-file-input" type="file" name="image" id="imageSelect" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col lg-6 mt-2">
                                            <a href="cms.php?pages=dashboard.php" class="mt-2 btn btn-danger btn-block">
                                                <p><i class="fas fa-arrow-left"></i>Back to dashboard</p>
                                            </a href="">
                                        </div>
                                        <div class="col lg-6 mt-2">
                                            <button id="submit" type="submit" name="submit" class="mt-2 btn btn-success btn-block">
                                                <p>Edit<i class="fas fa-check"></i></p>
                                            </button href="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


            <?php } ?>
</section>
<script src="includes/javascript.js"></script>

<?php
$pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W\_])[a-zA-Z0-9\W\_]{8,15}$/";
$pattern_name = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
if (isset($_POST["submit"])) {
$obj = $arr[0];
    $password_error=false;
    $confirm_error=false;
    $old =false;
    $password = $obj->get_password();
    $name =null;
    $headline = null;
    $description=null;
    if(!empty($_POST["new_pass"]) && !empty($_POST["confirm"]) && !empty($_POST["old_pass"])) {
        if (!preg_match($pattern, $_POST["new_pass"])) {
            $password_error = "The password must have at least 8 characters, one upper case, one lower case, one special character, one numerical and a maximun of 15 characters";
        } else $password_error = false;
        if ($_POST["old_pass"] != $obj->get_password()) {
            $old = "The old password and the new password are not the same";
        } else $old = false;
        if ($_POST["confirm"] != $_POST["new_pass"]) {
            $confirm_error = "The password are not equal";
        } else $confirm_error = false;
        if ($confirm_error == false && $old == false && $password_error == false) $password = $_POST["new_pass"];
    }
    if (!isset($_FILES["image"]) || empty($_FILES["image"]["name"])) {
        $image = $obj->get_image();
        echo "IMAGE: ".$image;
    } else {
        $image = $_FILES["image"]["name"];
    }
    if (!isset($_POST["name"]) && !empty($_POST["name"])) {
        $name_error = false;
        $name = $obj->get_name();
    } else {
        $name_error = false;
        $name = $_POST["name"];
    }
    if (!isset($_POST["headline"]) && !isset($_POST["description"])) {
        $headline_error = false;
        $description_error = false;
        $headline = $obj->get_headline();
        $description = $obj->get_description();
    } else {
        if (strlen($_POST["headline"]) >= 50) {
            $headline_error = "The headline can't have more than 50 characters";
        } else {
            $headline= $_POST["headline"];
            $headline_error= false;
        }
        if (strlen($_POST["description"]) >= 300) {
            $description_error = "The description can't have more than 300 characters";
        } else {
            $description_error = false;
            $description = $_POST["description"];
        }
    }
    if ($name_error == false && $password_error == false && $confirm_error == false && $old == false
        && $headline_error == false && $description_error == false) {
        $new_admin = new Admin();
        $new_admin->construct($obj->get_id(), $_SESSION["username"], $password,  $name,  null, null, $image, $headline, $description);
        $obj->update_profile($new_admin);
    } else {
        echo "<script>
                const msg = document.getElementById(\"display-msg\");
                const p1= document.createElement(\"p\");
                const p2= document.createElement(\"p\");
                const p3= document.createElement(\"p\");
                const p4= document.createElement(\"p\");
                const p5= document.createElement(\"p\");
                const p6= document.createElement(\"p\");
                msg.className=\"container-fluid alert alert-danger col-lg-8 mt-2\";
                p1.textContent = \"${name_error}\";
                p2.textContent = \"${password_error}\";
                p3.textContent = \"${confirm_error}\";
                p4.textContent = \"${old}\"
                p5.textContent = \"${headline_error}\";
                p6.textContent = \"${description_error}\";
                msg.appendChild(p1);
                msg.appendChild(p2);
                msg.appendChild(p3);
                msg.appendChild(p4);
                msg.appendChild(p5);
                msg.appendChild(p6);
                msg.style.display =\"inherit\";
            </script>";
    }
}
?>