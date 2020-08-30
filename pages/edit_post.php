<?php
check_login(); 
require_once("includes/date.php");
require_once("Db/PostDb.php");
require_once("Db/CategoryDb.php");
global $query;
global $arr;
global $obj;
$search_category = new Category();
$query = "SELECT `title` FROM `Categories`;";
$cat_arr = $search_category->search($query);
if(isset($_GET["id"])){
    $id = $_GET["id"];
    if(is_numeric($id)){
        $query = "SELECT * FROM Posts WHERE id = $id";
        $posts = new Post();
        $arr = $posts->search($query);
        if($arr != NULL) $obj = $arr[0];
    }
}
if($arr == NULL){
    echo "
        <div class=\"alert alert-danger\" style=\"text-align:center\" role=\"alert\">
            We found an error on this post. Maybe the id is invalid check it later.
        </div>
    ";   
    include("notFound.php");
}
else { 
?>
    <header class="bg-dark text-white header" style="padding:2rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>Edit Post</h1>
                </div>
            </div>
        </div>
    </header>
<section class="container-fluid py-2 mb-4">
<center>
        <div id="display-msg">
            </div>
    </center>
    <div class="row">
        <div class="col offset-lg-2 col-lg-8">
            <form id ="form" method="post" enctype="multipart/form-data">
                <div class="card bg-dark">
                    <div class="card-body">
                        <div class="form-group">
                            <?php $obj_title = $obj->get_title(); ?>
                            <label for="title"><span class="text-warning"> Title: </span></label>
                            <input class="form-control" type="text"  name="title" placeholder="Title" required value="<?php echo $obj_title ?>" />
                        </div>
                        <div class="form-group">
                            <label for="category"><span class="text-warning">Category: </span></label>
                            <select class="custom-select" name="category" required >
                            <option selected><?php echo $obj->get_category(); ?></option>
                            <?php  
                                    foreach($arr as $obj){
                                        $title = $obj->get_title();
                                        echo "<option value=\"${title}\"> ${title} </option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <label><span class="text-warning"> Image: </span></label>
                                <div>
                                    <?php $img_path = "uploads/".$obj->get_image();?>
                                    <center><img style="width:100%; max-height:15vw;" class="img-fluid" src="<?php echo $img_path?> " alt="image"/></center>
                                </div>
                                <div class="form-group mt-2">
                                    <div class="custom-file">
                                    <label id="label-img" class="custom-file-label" for="image"><span class="text-info" ><?php echo $obj->get_image();?></span></label>
                                    <input id="img-input" accept="image/*" class="custom-file-input" type="file"  name="image" id="imageSelect"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description"><span class="text-warning"> Description: </span></label>
                                <textarea class="form-control" type="textarea" name="description" placeholder="Enter a description" required ><?php echo $obj->get_post();?></textarea>
                            </div>
                            <div class="row">
                                <div class="col lg-6 mt-2">
                                    <a href="cms.php?pages=post" class="mt-2 btn btn-danger btn-block"><i class="fas fa-arrow-left"></i>Back to dashboard</a>
                                </div>
                                <div class="col lg-6 mt-2">
                                    <button type="submit" name="submit" class="mt-2 btn btn-success btn-block">Edit Post<i class="fas fa-check"></i></button href="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script src="includes/javascript.js"></script>
<?php 
}
global $title_error;
global $description_error;

    if(isset($_POST["submit"])){
        if(strlen($_POST["title"]) <=5 || strlen($_POST["title"]) >150){
            $title_error = "The title must have at least 5 characters and a maximum of 150 characters";
        }else  $title_error = false;
        if(strlen($_POST["description"]) <= 20 || strlen($_POST["description"]) >1000){
            $description_error = "The description must have at least 20 characters and a maximum of 1000 characters";
        }else $description_error=false;
        if($title_error == false && $description_error == false){
            $obj->set_title($_POST["title"]);
            $obj->set_category($_POST["category"]);
            $obj->set_post($_POST["description"]);
            $obj->set_date(get_time());
            if(!empty($_FILES["image"]["name"])){
                $obj->set_image($_FILES["image"]["name"]);
                $obj->update($obj,true, $img_path);
            }else{
                $obj->update($obj,false);
            }
        }
        else{
            echo "<script>
                const msg = document.getElementById(\"display-msg\");
                const p1= document.createElement(\"p\");
                const p2= document.createElement(\"p\");
                msg.className=\"container-fluid alert alert-danger col-lg-8\";
                p1.textContent = \"${title_error}\";
                p2.textContent = \"${description_error}\";
                msg.appendChild(p1);
                msg.appendChild(p2);
                msg.style.display =\"inherit\";
            </script>";
        }
    }
?>