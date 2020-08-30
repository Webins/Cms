<?php
require_once("includes/date.php");
require_once("Db/PostDb.php");
require_once("Db/CommentsDb.php");
require_once("Db/CategoryDb.php");
$search_category = new Category();
$arr_cat = $search_category->search();
global $query;
global $total_post;
if (isset($_GET["search"])) {
    $search_query = "\"%" . ucfirst(strtolower($_GET["search"])) . "%\"";
    $query = "SELECT * FROM Posts 
        WHERE `date` LIKE $search_query OR
        title LIKE $search_query OR
        post LIKE $search_query OR
        category LIKE $search_query OR
        author LIKE $search_query
        ORDER BY id DESC";
    $_GET["search"] = "";
    $posts = new Post();
    $arr = $posts->search($query);
} else if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    if ($_GET["page"] <= 0) {
        $arr = null;
    } else {
        $min = (($_GET["page"] * 4) - 4);
        $count = new Post();
        if(isset($_GET["cat"])){
            $query = "SELECT * FROM Posts WHERE Category=\"${_GET["cat"]}\"";
            $query2 = "SELECT * FROM Posts WHERE Category=\"${_GET["cat"]}\" ORDER BY id DESC LIMIT ${min},4";
        }else {
            $query = "SELECT * FROM Posts";
            $query2= "SELECT * FROM Posts ORDER BY id DESC LIMIT ${min},4";
        }
        $counter = $count->search($query);
        $posts = new Post();
        $arr = $posts->search($query2);
        $total_post = (count($counter));
    }
}
else if(!isset($_GET["page"])) { 
    $_GET["page"] =1;
    $min = (($_GET["page"] * 4) - 4);
    $count = new Post();
    if(isset($_GET["cat"])){
        $query = "SELECT * FROM Posts WHERE Category=\"${_GET["cat"]}\"";
        $query2 = "SELECT * FROM Posts WHERE Category=\"${_GET["cat"]}\" ORDER BY id DESC LIMIT ${min},4";
    }else {
        $query = "SELECT * FROM Posts";
        $query2= "SELECT * FROM Posts ORDER BY id DESC LIMIT ${min},4";
    }
    $counter = $count->search($query);
    $query = $query2;
    $posts = new Post();
    $arr = $posts->search($query);
    $total_post = (count($counter));
}

?>

<section class="container-fluid py-2 mb-4">
    <center>
        <div id="display-msg">
        </div>
    </center>

   

    <div class="row mt-2">
        <div class="offset-sm-1 col-sm-7">
            <h1>The Complete Responsive CMS BLOG</h1>
            <h1 mb-3 class="">Using Php</h1>
            &nbsp;
            <?php
            if ($arr == NULL) {
                echo "
                        <div class=\"alert alert-danger\" style=\"text-align:center\" role=\"alert\">
                            No matches Found
                        </div>
                        <center>
                        <img style=\"max-width: 100%; height:25vw;\" src=\"./assets/sad2.png\" alt=\"error\">
                        <center>
                    ";
            } else {
                $comment = new Comment();
                foreach ($arr as $post) {
                    $id = $post->get_id();
                    $query_comments = "SELECT * FROM Comments WHERE id=${id} AND status =1";
                    $arr = $comment->search($query_comments);
                    $count_comments = count($arr);
                    $src = "uploads/" . $post->get_image();
                    $description = $post->get_post();
                    $author = $post->get_author();
                    if (strlen($description) > 150) $description = substr($description, 0, 150) . " ...";
                    echo "
                        <div class = \"card mt-4\"> 
                        <img class=\"img-fluid\"  src=\"${src}\" style=\"height:25vw\" alt=\"img-blog\">
                        <div class=\"card-body\">
                        <h1 class=\"card-title\">" . $post->get_title() . "</h1>
                        <p class=\"text-muted\">Written by <a style=\"color:#005E90\" class=\"font-weight-bold\" target=\"_blank\" href=\"cms.php?pages=profile&user=${author}\">" . $post->get_author() . "</a> on " . $post->get_date() . " 
                        <p class=\"text-muted\"> Category: " .$post->get_category(). " <p>
                        <span class=\"badge badge-primary\" style=\"float:right;\">Comments: $count_comments</span></p>
                        <hr>
                        <p class=\"card-text\"> " . $description . "</p>
                        <a class=\"btn btn-primary\" href=\"index.php?pages=post_description&id=$id\" style=\"float:right;\"> <h2>Read More</h2> </a>
                        </div>
                        </div>
                        ";
                }


            ?>
                <?php if (isset($_GET["page"]) && $_GET["page"] > 0) {
                    $max_page;
                ?>
                    <nav class="mt-3 align-self-center">
                        <center>
                            <ul class="pagination pagination-lg">
                                <a href="index.php?pages=home&page=<?php if (($_GET["page"] == 1)) echo $_GET["page"];
                        else echo ($_GET["page"] - 1); ?>" class="page-link">&laquo;
                                </a>
                                <?php for ($i = 0, $j = 1; $i < $total_post; $i += 4, $j++) {
                                    $max_page = $j;
                                ?>
                                    <li id="page_item<?php echo $j ?>" class="page-item">
                                        <a href="index.php?pages=home&page=<?php echo $j ?>" class="page-link">
                                            <?php echo $j; ?>
                                        </a>
                                    </li>
                                <?php

                                }
                                ?>
                                <a href="index.php?pages=home&page=<?php if (($_GET["page"] == $max_page)) echo $_GET["page"];
                        else echo ($_GET["page"] + 1); ?>" class="page-link">&raquo;
                                </a>
                            </ul>
                        </center>
                    </nav>
            <?php }
            if(isset($_GET["page"])){

                echo "<script>
                const act = document.getElementById(\"page_item${_GET["page"]}\")
                act.className = \"page-item active\" 
                </script>";
            }
            } ?>
        </div>

        <div class="ml-5 col-sm-3">
                <div class="card mt-4">
                    <div class="card-body">
                        <img class="d-block img-fluid" src="./assets/start_blog.jpg" alt="_blog" />
                        <div class="text-center">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe consequuntur molestiae 
                                corrupti quos deleniti perspiciatis, possimus ex voluptates laborum esse dolor amet ad 
                                iusto sed repellendus officia suscipit. Quasi, non?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header bg-dark text-light">
                        <h2 class="">sign up!</h2>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success text-center btn-block text-white"><p>Join the forum</p></button>
                        <button type="button" class="btn btn-info text-center btn-block text-white"><p>Login</p></button>
                        <div class="input-group mt-3">
                            <input type="email" class="form-control mr-2" placeholder="Enter your email" />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm text-center text-white"></p>Subscribe</p></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2">
                    <div class="card-header bg-primary text-light">
                        <h2>Categories</h2>
                        </div>
                        <div class="card-body">
                        <?php  
                                    foreach($arr_cat as $obj){
                                        $title = $obj->get_title();
                                        echo "
                                        <a href=\"index.php?pages=home&cat=${title}\">
                                        <p class=\"mt-2 font-weight-bold \" style=\"color:#005E90\">${title}</p>
                                        </a>";
                                    }
                                ?>
                        </div>
                    
                </div>
                <div class="card mt-2 mb-4">
                    <div class="card-header bg-info text-white">
                        <h2> Recents Pots</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        $newest = $post->search("SELECT * FROM Posts ORDER BY id LIMIT 0,5");
                        ?>
                        <div class="media">
                            <?php 
                                foreach($newest as $new_post){
                                    $src = "uploads/".$new_post->get_image();
                                    $title = $new_post->get_title();
                                    $id = $new_post->get_id();
                                    $date = $new_post->get_date();
                                    echo "<div class=\"mb-1\">";
                                    echo "<a style=\"color:#005E90\" class=\"font-weight-bold\" target=\"_blank\" href=\"index.php?pages=post_description&id=${id}\"><img src=\"${src}\" class=\"d-block img-fluid align-self-start\" alt=\"img-posts\" />";
                                    echo "<div class=\"media-body ml-2\"> <h2> ${title} </h2> </a>";
                                    echo "<p class=\"mt-1 font-weight-bold\"> $date </p>";
                                    echo "</div>";
                                }
                            ?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
  
</section>