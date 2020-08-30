<?php
check_login();
require_once("Db/PostDb.php");
require_once("Db/AdminsDb.php");
require_once("Db/CommentsDb.php");
require_once("Db/CategoryDb.php");
$query = "SELECT * FROM Posts";
$posts = new Post();
$arr = $posts->search($query);
?>
<link rel="stylesheet" href="css/dashboard.css" />
<header class="bg-dark text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard <i class="fas fa-cog" style="color:#27aae1;"></i></h1>
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
    <?php
    if (isset($_GET["user_log"]) && $_GET["user_log"] == true) {
        if (isset($_SESSION["username"]) && $_SESSION["password"]) {
            echo "<script>
                        const msg = document.getElementById(\"display-msg\")
                        msg.style.display=\"inherit\"
                        msg.className=\"container-fluid alert alert-success col-lg-8\"
                        const h2 = document.createElement(\"h2\");
                        h2.textContent=\"Welcome Back ${_SESSION["username"]}\"
                        msg.appendChild(h2);
                        window.setTimeout(()=> msg.style.display=\"none\", 10000);
                    </script>
                    ";
        }
    }
    ?>
<div class="container">
   <div class="row">
       <div class="col-lg-2 d-none d-md-block">
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="badge badge-info">Posts</h1>
                    <h2 class="display-5"><i class="fab fa-readme">
                    <?php 
                        $post_count = new Post();
                        $query = "SELECT * FROM Posts";
                        $arr = $post_count->search($query);
                        echo count($arr);
                    ?>
                    </i></h2>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="badge badge-info">Categories</h1>
                    <h2 class="display-5"><i class="fas fa-folder">
                    <?php 
                        $cat_count = new Category();
                        $arr = $cat_count->search();
                        echo count($arr);
                    ?>  
                    </i></h2>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="badge badge-info">Admin</h1>
                    <h2 class="display-5"><i class="fas fa-users">
                    <?php 
                        $admin_count = new Admin();
                        $query = "SELECT * FROM Admins";
                        $arr = $admin_count->search($query);
                        echo count($arr);
                    ?>  
                    </i></h2>
                </div>
            </div>
            <div class="card text-center bg-dark text-white mb-3">
                <div class="card-body">
                    <h1 class="badge badge-info">Comments</h1>
                    <h2 class="display-5"><i class="fas fa-comment"> 
                    <?php 
                        $comments_count = new Comment();
                        $query = "SELECT * FROM Comments";
                        $arr = $comments_count->search($query);
                        echo count($arr);
                    ?>  

                    </i></h2>
                </div>
            </div>
       </div>
       <div class="col-lg-10 ">
            <center><h1 class="badge-info mb-2 font-weight-bold">Top Posts</h1></center>
            <table class="table table-stripped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>
                    <h2 class="font-weight-bold"><center>No</center></h2>
                </th>
                <th>
                    <h2 class="font-weight-bold"><center>Title</center></h2>
                </th>
                <th>
                    <h2 class="font-weight-bold"><center>Author</center></h2>
                </th>
                <th>
                    <h2 class="font-weight-bold"><center>Comments</center></h2>
                </th>
                <th>
                    <h2 class="font-weight-bold"><center>Date</center></h2>
                </th>
                <th>
                    <h2 class="font-weight-bold"><center>Details</center></h2>
                </th>
            </tr>
            <?php
            $post = new Post();
            $query = "SELECT * FROM Posts";
            $arr = $post->search($query);
            $i = 1;
            foreach ($arr as $post) {
                $id = $post->get_id();
                $query_approved = "SELECT * FROM Comments WHERE post_id=${id} AND status =1";
                $query_unaprrovved = "SELECT * FROM Comments WHERE post_id=${id} AND status =0";
                $comment_a = new Comment();
                $comment_u = new Comment();
                $arr_a = $comment_a->search($query_approved);
                $arr_u = $comment_u->search($query_unaprrovved);
                $count_a = count($arr_a);
                $count_u = count($arr_u);    
                echo "<tr>";
                echo "<td class=\"td-table number\"><p>${i} </p></td>";
                echo "<td class=\"td-table title\"><p><center>" . $post->get_title() . "</center></p></td>";
                echo "<td class=\"td-table author\"><p><center>" . $post->get_author() . "</center></p></td>";
                echo "<td class=\"td-table comments\">
                <center>
                <p class=\"badge badge-info\">${count_a}</p>
                <p class=\"badge badge-danger\">${count_u}</p>
                </center>
                </td>";
                echo "<td class=\"td-table date\"><p><center>" . $post->get_date() . "</center></p></td>";
                echo "<td class=\"td-table details\">
                <center>
                <a href=\"index.php?pages=post_description&id=$id\"><span class=\"btn btn-success\"></p>Live<p></span></a>
                </center>
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
       </div>
   </div>
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