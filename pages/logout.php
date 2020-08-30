<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php 
    if(isset($_COOKIE["delete_user"]) && $_COOKIE["delete_user"] == true){
        $_SESSION["username"] = null;
        $_SESSION["password"] = null;
        $_SESSION["id"] = null;
        session_destroy();
        setcookie("delete_user", false, 1);
        echo "<script>
            location.href=\"index.php?pages=home\";
            </script>";
    }else{
        $user = $_SESSION["username"];
    }

?>

<script>
    swal({
        title: "Do you want to exit?",
        text: "Select one of the options",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
            .then((willDelete) => {
            if (willDelete) {
               document.cookie="delete_user=true"
               location.reload();
            }else{
               history.back(); 
            } 
            });
</script>


<?php ?>