<?php
check_login();
require_once("Db/CategoryDb.php");
$category = new Category();
if (isset($_COOKIE["delete_category"]) && $_COOKIE["delete_category"] != null) {
    $id = $_COOKIE["delete_category"];
    setcookie("delete_category", null, 1);
    $category->delete($id);
    $_SESSION["deleted_cat"] = true;
}

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<header class="bg-dark text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit" style="color:#27aae1;"></i>Manage Categories</h1>
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
 if (isset($_SESSION["deleted_cat"]) && $_SESSION["deleted_cat"] == true) {
    $_SESSION["deleted_cat"] = null;
    echo "<script> 
    const msg = document.getElementById(\"display-msg\")
    msg.style.display=\"inherit\"
    msg.className =\"container alert alert-success col-lg-8\"
    const p = document.createElement(\"p\")
    p.textContent =\"Category deleted\"
    msg.appendChild(p)
    //setTimeOut(() => {msg.style.display=\"none\"} ,10000 )
</script>";
}
?>
    </div>
    <div class="row mt-4">
        <div class="col offset-lg-2 col-lg-8">
            <form id="form" method="post">
                <div class="card bg-dark">
                    <div class="card-header badge-secondary">
                        <h1 class="new-category ">Add a new Category</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title"><span class="text-warning">
                                    <p>Category Title</p>
                                </span></label>
                            <input id="input" class="form-control" type="text" name="title" placeholder="title" required />
                            <div class="row">
                                <div class="col lg-6 mt-2">
                                    <a href="cms.php?pages=dashboard" class="mt-2 btn btn-danger btn-block">
                                        <p><i class="fas fa-arrow-left"></i>Back to dashboard</p>
                                    </a href="">
                                </div>
                                <div class="col lg-6 mt-2">
                                    <button id="submit" type="submit" name="submit" class="mt-2 btn btn-success btn-block">
                                        <p>Publish<i class="fas fa-check"></i></p>
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
$arr = $category->search();
echo "<center><div class=\"badge badge-info\"> <h1>Existing Categories</h1> </div></center><br><hr>";
if ($arr == null) {
    echo "
        <center>
        <div style=\"display:inherit\" class=\"container alert alert-danger col-lg-8\" id=\"display-msg\">
            <h1> There are not existing categories in this moment </h1>
            </div>
            </center>
        ";
} else {
    
?>
    <center>
        <div id="display-msg" style="display:none">

        </div>
    </center>
    <div class="container-fluid">
        <table class="table table-stripped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <h2 class="font-weight-bold text-center">No.</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Category Name</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Creator</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Date&Time</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Delete</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Update</h2>
                    </th>
                </tr>
                <?php
                $arr = $category->search();
                $i = 1;
                foreach ($arr as $cat_obj) {
                    $id = $cat_obj->get_id();
                    echo "<tr>";
                    echo "<td class=\"td-table text-center number\"><p>${i} </p></td>";
                    echo "<td class=\"td-table text-center category\"><p>" . $cat_obj->get_title() . "</p></td>";
                    echo "<td class=\"td-table text-center creator\"><p>" . $cat_obj->get_author() . "</p></td>";
                    echo "<td class=\"td-table text-center date\"><p>" . $cat_obj->get_date() . "</p></td>";
                    echo "<td class=\"td-table text-center update\">
                    <a href=\"cms.php?pages=update_categories&id=${id}\" class=\"btn btn-primary\" id=\"update_cat\"><p>Update</p></a>
                    </td>";
                    echo "<td class=\"td-table text-center delete\">
                <button onclick=\"delete_category(${id})\" class =\"btn btn-danger\" id=\"delete_cat\"><p>Delete</p></button>
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




<?php
}
?>
<br>
<br>

<script src="includes/javascript.js"></script>



<?php
if (isset($_POST["submit"])) {
    if (!empty($_POST["title"]) && strlen($_POST["title"]) > 2 && strlen($_POST["title"]) <= 30) {
        $cat = new Category($_POST["title"], $_SESSION["username"], get_time());
        $cat->insert();
       
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
<script>
    function delete_category(id) {
        swal({
                title: "Do you want to delete this category?",
                text: "Once delete you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("We are going to delete this category", {
                        icon: "success"
                    })
                    document.cookie = `delete_category=${id}`
                    location.reload()
                } else {}
            });
    }
</script>