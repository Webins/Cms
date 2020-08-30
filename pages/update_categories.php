<?php
check_login();
require_once("Db/CategoryDb.php");
$bad = false;
global $obj;
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $category = new Category();
    $arr = $category->search($_GET["id"]);
    $obj = $arr[0];
} else {
    $bad = true;
}
?>


<header class="bg-dark text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit" style="color:#27aae1;"></i> Update Category</h1>
            </div>
        </div>
    </div>
</header>
<section class="container-fluid py-2 mb-4">
    <?php
    if ($bad) {

        echo "
        <center>
        <div style=\"display:inherit;\" id=\"display-msg\" class=\"container alert alert-danger col-lg-8\">
        The category doesn't exist
        </div>
        </center>
        ";
    } else {
    ?>
        <center>
            <div id="display-msg">
            </div>
        </center>

        </div>
        <div class="row mt-4">
            <div class="col offset-lg-2 col-lg-8">
                <form id="form" method="post">
                    <div class="card bg-dark">
                        <div class="card-header badge-secondary">
                            <h1 class="new-category ">Edit Category</h1>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title"><span class="text-warning">
                                        <p>Category Title</p>
                                    </span></label>
                                <input id="input" class="form-control" value="<?php echo $obj->get_title(); ?>" type="text" name="title" placeholder="title" required />
                                <div class="row">
                                    <div class="col lg-6 mt-2">
                                        <a href="cms.php?pages=categories" class="mt-2 btn btn-danger btn-block">
                                            <p><i class="fas fa-arrow-left"></i>Back to Categories</p>
                                        </a href="">
                                    </div>
                                    <div class="col lg-6 mt-2">
                                        <button id="submit" type="submit" name="submit" class="mt-2 btn btn-success btn-block">
                                            <p>Edit <i class="fas fa-edit"></i></p>
                                        </button href="">
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
    }
?>
<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["title"]) && strlen($_POST["title"]) > 2 && strlen($_POST["title"]) <= 30) {
        $obj->set_title($_POST["title"]);
        $obj->set_author($_SESSION["username"]);
        $obj->set_date(get_time());
        $obj->update($obj);
    } else {
        echo "<script>
            const msg = document.getElementById(\"display-msg\");
            msg.className=\"container-fluid alert alert-danger col-lg-8\";
            msg.textContent = \"Please enter a category between a range of 3 and 30 characters\";
            msg.style.display =\"inherit\";
        </script>";
    }
}
?>