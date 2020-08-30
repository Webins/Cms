<?php 
check_login();
?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
require_once("includes/date.php");
require_once("Db/PostDb.php");
require_once("Db/CategoryDb.php");
global $query;
global $arr;
global $obj;
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (is_numeric($id)) {
        $query = "SELECT * FROM Posts WHERE id = $id";
        $posts = new Post();
        $arr = $posts->search($query);
        if ($arr != NULL) $obj = $arr[0];
    }
}
if(isset($_COOKIE["delete"]) && $_COOKIE["delete"] == true){
    setcookie("delete", false, time() + (86400 * 30));
    $obj->delete($obj);
        ?> 
    <script>
    let msg ="Post deleted successfully";
    let msg_class ="container-fluid alert alert-success col-lg-8";    
    location.assign(`cms.php?pages=post&class=${msg_class}&msg=${msg}`)
    </script>
    <?php 
}

if ($arr == NULL) {
    echo "
        <div class=\"alert alert-danger\" style=\"text-align:center\" role=\"alert\">
            We found an error on this post. Maybe the id is invalid check it later.
        </div>
    ";
    include("notFound.php");
} else {
?>
    <header class="bg-dark text-white header" style="padding:2rem;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-edit" style="color:#27aae1;"></i>Delete Post</h1>
                </div>
            </div>
        </div>
    </header>
    <section class="container-fluid py-2 mb-4">
        <div class="row">
            <div class="col offset-lg-2 col-lg-8">
                <form id="form" method="post" enctype="multipart/form-data">
                    <div class="card bg-dark">
                        <div class="card-body">
                            <div class="form-group">
                                <?php $obj_title = $obj->get_title(); ?>
                                <label for="title"><span class="text-warning"> Title: </span></label>
                                <input class="form-control" disabled type="text" name="title" value="<?php echo $obj_title ?>" />
                            </div>
                            <div class="form-group">
                                <label for="category"><span class="text-warning">Category: </span></label>
                                <select class="custom-select" name="category" disabled>
                                    <option selected disabled><?php echo $obj->get_category(); ?></option>
                                </select>
                            </div>
                            <label><span class="text-warning"> Image: </span></label>
                            <div>
                                <center><img style="width:100%; max-height:15vw;" class="img-fluid" src="<?php echo "uploads/" . $obj->get_image(); ?>" alt="image" /></center>
                            </div>
                            <div class="form-group mt-2">
                                <div class="custom-file">
                                    <label id="label-img" class="custom-file-label" for="image"><span class="text-info"><?php echo $obj->get_image(); ?></span></label>
                                    <input id="img-input" disabled accept="image/*" class="custom-file-input" type="file" name="image" id="imageSelect" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description"><span class="text-warning"> Description: </span></label>
                                <textarea class="form-control" type="textarea" name="description" disabled><?php echo $obj->get_post(); ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col lg-6 mt-2">
                                    <a href="cms.php?pages=post" class="mt-2 btn btn-success btn-block" ><i class="fas fa-arrow-left"></i> Back to dashboard</a>
                                </div>
                                <div class="col lg-6 mt-2">
                                    
                                    <button id="btn" type="submit"  name="submit" class="mt-2 btn btn-danger btn-block">Delete Post <i class="fas fa-window-close"></i></button>
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

if (isset($_POST["submit"])) {
    ?>
    <script>
    swal({
        title: "Do you want to delete this post",
        text: "Once deleted, you will not be able to recover!",
        icon: "error",
        buttons: true,
        dangerMode: true,
        })
            .then((willDelete) => {
            if (willDelete) {
                document.cookie="delete=true;";
                location.href="cms.php?pages=delete_post&id=<?php echo $id ?>"
                location.reload();
            } 
            });
    
    </script>
<?php 
} 



?>
 