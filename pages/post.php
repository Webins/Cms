<?php
check_login();
require_once("Db/PostDb.php");
require_once("Db/CommentsDb.php");
$query = "SELECT * FROM Posts";
$posts = new Post();
$arr = $posts->search($query);
?>
<link rel="stylesheet" href="css/post.css" />
<header class="bg-dark text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>BlogSpot <i class="fas fa-blog" style="color:#27aae1;"></i></h1>
            </div>
        </div>
    </div>
</header>
<section class="bg-dark text-white container-fluid py-2 mb-4">
    <div class="row">
        <div class="mb-2 col-lg-3">
            <a href="cms.php?pages=add_post" class="btn btn-primary btn-block">
                <i class="fas fa-edit"></i>
                <p>Add New Post</p>
            </a>
        </div>
        <div class="mb-2 col-lg-3">
            <a href="cms.php?pages=categories" class="btn btn-info btn-block">
                <i class="fas fa-folder-plus"></i>
                <p>Add New category</p>
            </a>
        </div>
        <div class="mb-2 col-lg-3">
            <a href="cms.php?pages=manage_admins" class="btn btn-warning btn-block">
                <i class="fas fa-user-plus"></i>
                <p>Add new Admin</p>
            </a>
        </div>
        <div class="mb-2 col-lg-3">
            <a href="cms.php?pages=manage_comments" class="btn btn-success btn-block">
                <i class="fas fa-check"></i>
                <p>Approve Comments</p>
            </a>
        </div>
    </div> 
</section>
<center>
        <div id="display-msg">
            </div>
    </center>
<div class="container-fluid">
    <table class="table table-stripped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>
                    <h2 class="font-weight-bold text-center">#</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Title</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Category</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Date&Time</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Author</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Banner</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Comments</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Action</h2>
                </th>
                <th>
                    <h2 class="font-weight-bold text-center">Live Preview</h2>
                </th>
            </tr>
            <?php
            $i = 1;
            foreach ($arr as $post) {
                $id = $post->get_id();
                $src = "uploads/" . $post->get_image();
                $query_approved = "SELECT * FROM Comments WHERE post_id=${id} AND status =1";
                $query_unaprrovved = "SELECT * FROM Comments WHERE post_id=${id} AND status =0";
                $comment_a = new Comment();
                $comment_u = new Comment();
                $arr_a = $comment_a->search($query_approved);
                $arr_u = $comment_u->search($query_unaprrovved);
                $count_a = count($arr_a);
                $count_u = count($arr_u);    
                echo "<tr>";
                echo "<td class=\"td-table number text-center\"><p>${i} </p></td>";
                echo "<td class=\"td-table title text-center\"><p>" . $post->get_title() . "</p></td>";
                echo "<td class=\"td-table category text-center\"><p>" . $post->get_category() . "</p></td>";
                echo "<td class=\"td-table date text-center\"><p>" . $post->get_date() . "</p></td>";
                echo "<td class=\"td-table author text-center\"><p>" . $post->get_author() . "</p></td>";
                echo "<td class=\"td-table img\"><img class=\"img-fluid\" src=\"${src}\" style=\"max-width: 15vw;\"  alt=\"banner\" />";
                echo "<td class=\"td-table comment text-center\">
                <p class=\"badge badge-info\">${count_a}</p>
                <p class=\"badge badge-danger\">${count_u}</p>
                </td>";
                echo "<td class=\"td-table action text-center\">
                <a href=\"cms.php?pages=edit_post&id=$id\"><span class=\"btn btn-primary\"><p>Edit</p></span></a>
                <a href=\"cms.php?pages=delete_post&id=$id\"><span class=\"btn btn-danger\"><p>Delete</p></span></a>
                </td>";
                echo "<td class=\"td-table live text-center\">
                <a href=\"index.php?pages=post_description&id=$id\"><span class=\"btn btn-success\"></p>Live Preview<p></span></a>
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
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
    </table>
</div>
<script>
    const foot = document.getElementById("footer");
    foot.style.bottom = "-30px";
</script>


<?php 
    if(isset($_GET["class"]) && isset($_GET["msg"])){
        echo "<script>
        const msg = document.getElementById(\"display-msg\");
        const p1= document.createElement(\"p\");
        p1.style.border=\"0\"
        msg.className=\"container-fluid alert alert-success col-lg-8\";
        p1.className = \"${_GET["class"]}\";
        p1.textContent = \"${_GET["msg"]}\";
        msg.appendChild(p1);
        msg.style.display =\"inherit\";
        setTimeout(()=>{msg.style.display=\"none\"}, 15000);
        </script>";
    }
        ?>