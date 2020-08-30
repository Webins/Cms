<?php
check_login();
require_once("Db/CommentsDb.php");
require_once("includes/date.php");

$unapprove_comment = new Comment();
global $deleted_unaproved;
if (isset($_COOKIE["approve_comment"]) && $_COOKIE["approve_comment"] != null) {
    $unapprove_comment_id = $_COOKIE["approve_comment"];
    setcookie("approve_comment", null, 1);
    $query_upd = "UPDATE Comments SET approved_by=:approved_by,status=:status,date=:date WHERE id=${unapprove_comment_id}";
    $unapprove_comment->update($query_upd, 1, $_SESSION["username"]);
    $_SESSION["approved_u"] = true;
}
if (isset($_COOKIE["delete_comment"]) && $_COOKIE["delete_comment"] != null) {
    $unapprove_comment_id = $_COOKIE["delete_comment"];
    setcookie("delete_comment", null, 1);
    $unapprove_comment->delete($unapprove_comment_id);
    $_SESSION["deleted_u"] = true;
}

$approved_comment = new Comment();
if (isset($_COOKIE["unnaproved_comment"]) && $_COOKIE["unnaproved_comment"] != null) {
    $approved_comment_id = $_COOKIE["unnaproved_comment"];
    setcookie("unnaproved_comment", null, 1);
    $query_upd = "UPDATE Comments SET approved_by=:approved_by,status=:status,date=:date WHERE id=${approved_comment_id}";
    $approved_comment->update($query_upd, 0, $_SESSION["username"]);
    $_SESSION["unnaproved_a"] = true;
}
if (isset($_COOKIE["delete_approved"]) && $_COOKIE["delete_approved"] != null) {
    $approved_comment_id = $_COOKIE["delete_approved"];
    setcookie("delete_approved", null, 1);
    $approved_comment->delete($approved_comment_id);
    $_SESSION["delete_a"] = true;
}
$query = "SELECT * FROM Comments WHERE status=0 ORDER BY date";
$arr = $unapprove_comment->search($query);
$query = "SELECT * FROM Comments WHERE status=1 ORDER BY date";
$arr_a = $approved_comment->search($query);

?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="css/post.css" />
<header class="bg-dark mb-3 text-white header" style="padding:2rem;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Manage Comments <i class="fas fa-comment" style="color:#27aae1;"></i></h1>
            </div>
        </div>
    </div>
</header>
<br>
<br>
<?php
echo "<center><div class=\"badge badge-danger\"> <h1>Unaproved comments</h1> </div></center><br><hr>";
if ($arr == null) {
    echo "
        <center>
        <div style=\"display:inherit\" class=\"container alert alert-danger col-lg-8\" id=\"display-msg\">
            <h1> There are not unnaproved comments in this moment </h1>
            </div>
            </center>
        ";
} else {


?>
    <center>
        <div id="display-msg" style="display:none">

        </div>
    </center>
    <?php
    if (isset($_SESSION["deleted_u"]) && $_SESSION["deleted_u"] == true) {
        $_SESSION["deleted_u"] = null;
        echo "<script> 
        const msg = document.getElementById(\"display-msg\")
        msg.style.display=\"inherit\"
        msg.className =\"container alert alert-success col-lg-8\"
        const p = document.createElement(\"p\")
        p.textContent =\"Comment deleted\"
        msg.appendChild(p)
        //setTimeOut(() => {msg.style.display=\"none\"} ,10000 )
    </script>";
    }
    if (isset($_SESSION["approved_u"]) && $_SESSION["approved_u"] == true) {
        $_SESSION["approved_u"] = null;
        echo "<script> 
        const msg = document.getElementById(\"display-msg\")
        msg.style.display=\"inherit\"
        msg.className =\"container alert alert-success col-lg-8\"
        const p = document.createElement(\"p\")
        p.textContent =\"Comment approved\"
        msg.appendChild(p)
     //   setTimeOut(() => {msg.style.display=\"none\"} ,10000 )
    </script>";
    }
    ?>
    <div class="container-fluid">
        <table class="table table-stripped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <h2 class="font-weight-bold text-center">No.</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Name</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Comment</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Date&Time</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Approve</h2>
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
                foreach ($arr as $unapprove_comment_obj) {
                    $id = $unapprove_comment_obj->get_id();
                    $post_id = $unapprove_comment_obj->get_post_id();
                    echo "<tr>";
                    echo "<td class=\"td-table text-center number\"><p>${i} </p></td>";
                    echo "<td class=\"td-table text-center name\"><p>" . $unapprove_comment_obj->get_name() . "</p></td>";
                    echo "<td class=\"td-table text-center comment\"><p>" . $unapprove_comment_obj->get_comment() . "</p></td>";
                    echo "<td class=\"td-table text-center date\"><p>" . $unapprove_comment_obj->get_date() . "</p></td>";
                    echo "<td class=\"td-table text-center approve\">
                <button onclick=\"approveComment(${id})\" class =\"btn btn-primary\" id=\"approve_comment\"><p>Approve</p></button>
                </td>";
                    echo "<td class=\"td-table text-center action\">
                <button onclick=\"deleteComment(${id})\" class=\"btn btn-danger\" id=\"delete_comment\"><p>Delete</p></button>
                </td>";
                    echo "<td class=\"td-table text-center live\">
                <a href=\"index.php?pages=post_description&id=${post_id}\"><span class=\"btn btn-success\"></p>Live Preview<p></span></a>
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
<?php
echo "<center><div class=\"badge badge-info\"> <h1>Approved comments</h1> </div></center><br><hr>";
if ($arr_a == null) {
    echo "
        <center>
        <div style=\"display:inherit\" class=\"container alert alert-danger col-lg-8\" id=\"display-msg\">
            <h1> There are not approved comments in this moment </h1>
            </div>
            </center>
        ";
} else {


?>
    <center>
        <div id="display-msg">

        </div>
    </center>
    <?php
    if (isset($_SESSION["delete_a"]) && $_SESSION["delete_a"] == true) {
        $_SESSION["delete_a"] = null;
        echo "<script> 
        const msg = document.getElementById(\"display-msg\")
        msg.style.display=\"inherit\"
        msg.className =\"container alert alert-success col-lg-8\"
        const p = document.createElement(\"p\")
        p.textContent =\"Comment deleted\"
        msg.appendChild(p)
        //setTimeOut(() => {msg.style.display=\"none\"} ,10000 )
    </script>";
    }
    if (isset($_SESSION["unnaproved_a"]) && $_SESSION["unnaproved_a"] == true) {
        $_SESSION["unnaproved_a"] = null;
        echo "<script> 
        const msg = document.getElementById(\"display-msg\")
        msg.style.display=\"inherit\"
        msg.className =\"container alert alert-success col-lg-8\"
        const p = document.createElement(\"p\")
        p.textContent =\"Comment dis-approved\"
        msg.appendChild(p)
     //   setTimeOut(() => {msg.style.display=\"none\"} ,10000 )
    </script>";
    }
    ?>
    <div class="container-fluid">
        <table class="table table-stripped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <h2 class="font-weight-bold text-center">No.</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Name</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Comment</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Date&Time</h2>
                    </th>
                    <th>
                        <h2 class="font-weight-bold text-center">Dis-Approved</h2>
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
                foreach ($arr_a as $approved_comment_obj) {
                    $id = $approved_comment_obj->get_id();
                    $post_id = $approved_comment_obj->get_post_id();
                    echo "<tr>";
                    echo "<td class=\"td-table text-center number\"><p>${i} </p></td>";
                    echo "<td class=\"td-table text-center name\"><p>" . $approved_comment_obj->get_name() . "</p></td>";
                    echo "<td class=\"td-table text-center comment\"><p>" . $approved_comment_obj->get_comment() . "</p></td>";
                    echo "<td class=\"td-table text-center date\"><p>" . $approved_comment_obj->get_date() . "</p></td>";
                    echo "<td class=\"td-table text-center approve\">
                <button onclick=\"disapprovedComment(${id})\" class =\"btn btn-primary\" id=\"approve_comment\"><p>Dis-Approved</p></button>
                </td>";
                    echo "<td class=\"td-table text-center action\">
                <button onclick=\"deleteAComment(${id})\" class=\"btn btn-danger\" id=\"delete_comment\"><p>Delete</p></button>
                </td>";
                    echo "<td class=\"td-table text-center live\">
                <a href=\"index.php?pages=post_description&id=${post_id}\"><span class=\"btn btn-success\"></p>Live Preview<p></span></a>
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
                </tr>
            </thead>
        </table>
        <hr>
    </div>
<?php } ?>

<script src="includes/javascript.js"></script>
<script>
    function deleteComment(id) {
        swal({
                title: "Do you want to delete this comment?",
                text: "Once delete you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("We are going to delete this comment", {
                        icon: "success"
                    })
                    document.cookie = `delete_comment=${id}`
                    location.reload()
                } else {}
            });
    }
    function deleteAComment(id) {
        swal({
                title: "Do you want to delete this comment?",
                text: "Once delete you will not be able to recover",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("We are going to delete this comment", {
                        icon: "success"
                    })
                    document.cookie = ` delete_approved=${id}`
                    location.reload()
                } else {}
            });
    }
    function approveComment(id) {
        swal({
                title: "Do you want to approve this comment?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Comment approved", {
                        icon: "success"
                    })
                    document.cookie = `approve_comment=${id}`
                    location.reload()
                } else {}
            });
    }

    function disapprovedComment(id) {
        swal({
                title: "Do you want to dis-aprove this comment?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("comment disaproved", {
                        icon: "success"
                    })
                    document.cookie = `unnaproved_comment=${id}`
                    location.reload()
                } else {}
            });
    }
</script>