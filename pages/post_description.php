<?php
require_once("includes/date.php");
require_once("Db/CommentsDb.php");
require_once("Db/PostDb.php");
require_once("Db/CategoryDb.php");
global $query;
global $arr;
global $obj;
global $post_id;
$search_category = new Category();
$arr_cat = $search_category->search();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    if (is_numeric($id)) {
        $query = "SELECT * FROM Posts WHERE id = $id";
        $posts = new Post();
        $arr = $posts->search($query);
        if ($arr != NULL){
            $obj = $arr[0];
            $id_obj = $obj->get_id();
            $query_comment = "SELECT * FROM Comments C, Posts P WHERE P.id=${id_obj} AND
            C.post_id=P.id AND C.status=1 ORDER BY C.date";
            $comments = new Comment();
            $arr_comments = $comments->search($query_comment); 
        }
    }
}
?>
<div class="container-fluid">

    <div class="row">
        <div class="offset-sm-1 col-sm-7">
            &nbsp;
            <?php
            if ($arr == NULL) {
                echo "
                        <div class=\"alert alert-danger\" style=\"text-align:center\" role=\"alert\">
                            We found an error on this post. Maybe the id is invalid check it later.
                        </div>
                    ";
                include("notFound.php");
            } else {
                $src = "uploads/" . $obj->get_image();
                $description = $obj->get_post();
                echo "
                        <div class = \"card mt-4\"> 
                        <img class=\"img-fluid\" src=\"${src}\" alt=\"img-blog\" style=\"max-height:600px;\">
                        <div class=\"card-body\">
                        <h4 class=\"card-title\">" . $obj->get_title() . "</h4>
                        <small class=\"text-muted\">Written by " . $obj->get_author() . " on " . $obj->get_date() . " </small>
                        <span class=\"badge badge-primary\" style=\"float:right;\">Comments 20</span>
                        <hr>
                        <p class=\"card-text\"> " . $description . "</p>
                        </h4>
                        </div>
                        </div>
                        ";
            }

            ?>
           
           <div class="container-fluid mt-3">
                <h1 class="badge badge-info mb-3">Comments</h1> 
            <?php 
                foreach($arr_comments as $obj_comment){
    
            ?>
               <div class="media">
                   <img class="d-block img-fluid align-self-start" width="100px" height="25px" src="assets/user.svg" alt="user">
                   <div class="media-body ml-2 alert alert-secondary" role="alert">
                        <h2><?php echo $obj_comment->get_name();?></h2>
                        <small> <?php echo $obj_comment->get_date(); ?> </small>
                        <p> <?php echo $obj_comment->get_comment(); ?> </p>
                   </div>
               </div>
               <?php } ?>
            </div>
            <center>
        <div id="display-msg" class="container-fluid">
            </div>
    </center>
            <form class="mt-4" method="POST">
                <div class="card mb-3">
                    <div class="card-header alert alert-info">
                        <h5>Share your thoughts about this Post</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="name" placeholder="Name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input class="form-control" type="email" name="email" placeholder="Email" />
                            </div>
                        </div>
                        <textarea name="comment" class="form-control" rows="6" cols="80"></textarea>
                        <button name="submit" type="submit" class="btn btn-block btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
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
                <div class="card mt-2">
                    <div class="card-header bg-info text-white">
                        <h2> Recents Pots</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        $post = new Post();
                        $newest = $post->search("SELECT * FROM Posts ORDER BY id LIMIT 0,5");
                        ?>
                        <div class="media mb-2">
                            <?php 
                                foreach($newest as $new_post){
                                    $src = "uploads/".$new_post->get_image();
                                    $title = $new_post->get_title();
                                    $id = $new_post->get_id();
                                    $date = $new_post->get_date();
                                   echo "<div>";
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
        </div>
    </div>
    </div>

</div>


<?php 
global $title_error;
global $description_error;
$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
    if(isset($_POST["submit"])){
        if(strlen($_POST["name"]) <=2 || strlen($_POST["name"]) >50){
            $title_error = "The name must have at least 5 characters and a maximum of 50 characters";
        }else  $title_error = false;
        if(!preg_match($pattern, $_POST["email"]) || empty($_POST["email"])){
            $description_error = "The email is incorrect, Can't be empty";
        }else $description_error=false;
        if(strlen($_POST["comment"]) <= 10 || strlen($_POST["comment"]) >500){
            $comment_error = "The Comments must have at least 15 characters and a maximum of 500 characters";
        }else $comment_error=false;
        if($title_error == false && $description_error == false && $comment_error==false){
            $comment = new Comment($id_obj, $_POST["name"], $_POST["email"], $_POST["comment"], "nobody", 0, get_time()) ;
            $comment->insert();
        }
        else{
            echo "<script>
                const msg = document.getElementById(\"display-msg\");
                const p1= document.createElement(\"p\");
                const p2= document.createElement(\"p\");
                const p3= document.createElement(\"p\");
                msg.className=\"container-fluid alert alert-danger col-lg-8 mt-2\";
                p1.textContent = \"${title_error}\";
                p2.textContent = \"${description_error}\";
                p3.textContent =\"${comment_error}\";
                msg.appendChild(p1);
                msg.appendChild(p2);
                msg.appendChild(p3);
                msg.style.display =\"inherit\";
            </script>";
        }
    }
?>