<?php 
check_login();
require_once("Db/CategoryDb.php");
require_once("Db/PostDb.php");
    $search_category = new Category();
    $arr = $search_category->search();
?>

<header class="bg-dark text-white header" style="padding:2rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>Add a new Post</h1>
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
                            <label for="title"><span class="text-warning"> Post Title: </span></label>
                            <input class="form-control" type="text"  name="title" placeholder="Title" required/>
                        </div>
                        <div class="form-group">
                            <label for="category"><span class="text-warning">Choose Category: </span></label>
                            <select class="custom-select" name="category" required>
                                <option selected disabled >Select a category</option>
                                <?php  
                                    foreach($arr as $obj){
                                        $title = $obj->get_title();
                                        echo "<option value=\"${title}\"> ${title} </option>";
                                    }
                                ?>
                            </select>
                        </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <label id="label-img" class="custom-file-label" for="image"><span class="text-info" >Select Image</span></label>
                                    <input id="img-input" accept="image/*" class="custom-file-input" type="file"  name="image" id="imageSelect" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description"><span class="text-warning"> Description: </span></label>
                                <textarea class="form-control" type="textarea" name="description" placeholder="Enter a description" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col lg-6 mt-2">
                                    <a href="cms.php?pages=dashboard.php" class="mt-2 btn btn-danger btn-block"><i class="fas fa-arrow-left"></i>Back to dashboard</a href="">
                                </div>
                                <div class="col lg-6 mt-2">
                                    <button type="submit" name="submit" class="mt-2 btn btn-success btn-block">Post<i class="fas fa-check"></i></button href="">
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
global $title_error;
global $description_error;

    if(isset($_POST["submit"])){
        if(strlen($_POST["title"]) <=5 || strlen($_POST["title"]) >300){
            $title_error = "The title must have at least 5 characters and a maximum of 300 characters";
        }else  $title_error = false;
        if(strlen($_POST["description"]) <= 20 || strlen($_POST["description"]) >3000){
            $description_error = "The description must have at least 20 characters and a maximum of 3000 characters";
        }else $description_error=false;
        if($title_error == false && $description_error == false){
            $post = new Post($_POST["title"], $_POST["category"], $_SESSION["username"], $_FILES["image"]["name"], $_POST["description"], get_time());
            $post->insert();
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