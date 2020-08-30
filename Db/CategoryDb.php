<?php
$GLOBALS["dsn"] =  "mysql:host=127.0.0.1;dbname=cms";
$GLOBALS["username"] = "wherever";
$GLOBALS["password"] = "password";
class Category{
    private $id;
    private $title;
    private $author;
    private $date;

    function __construct($title="", $author="admin", $date=""){
        $this->id;
        $this->title = ucfirst(strtolower($title));
        $this->author = ucfirst(strtolower($author));
        $this->date = $date;
    }

    public function construct($id = "", $title = "", $author = "", $date = "")
    {
        $this->id = $id;
        $this->title = ucfirst(strtolower($title));
        $this->author = ucfirst(strtolower($author));
        $this->date = $date;
    }

    public function insert(){
            try{
                $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Connection-Failed: " . $e->getMessage();
            }
                $sql = "INSERT INTO `Categories`(`title`, `author`, `date`)
                    VALUES(:title, :author, :date);";
                $stmt = $connect->prepare($sql);
                  $stmt->bindParam(':title', $this->title);
                  $stmt->bindParam(':author', $this->author);
                  $stmt->bindParam(':date', $this->date);
                  $exec = $stmt->execute();
                  $this->id = $connect->lastInsertId();
                  global $getMsg;
                  global $class;
                  $title_msg = $this->title;
                  if($exec){  
                      $getMsg = "The category ${title_msg} was submitted succesfully";
                      $class = "container-fluid alert alert-success col-lg-8";
                    }
                  else {
                      $getMsg= "An error with the database has ocurred, please try again later";
                      $class = "container-fluid alert alert-danger col-lg-8";
                    }
                  echo "<script type=\"text/javascript\"> 
                  
                    const msgdb = document.getElementById(\"display-msg\");
                    msgdb.className=\"${class}\";
                    msgdb.textContent= \"${getMsg}\";
                    msgdb.style.display=\"inherit\";
                  </script>";
                  $connect=NULL;
    }



    public function update($obj){
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $id = $obj->get_id();
        global $class;
        global $getMsg;
        $title = $obj->get_title();
        $author = $obj->get_author();
        $date = $obj->get_date();
        $query = "UPDATE `Categories` SET title=:title, author=:author, date=:date WHERE id=${id}";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':date', $date);
        $exec = $stmt->execute();
        if ($exec) {
            $getMsg = "The Category was edited succesfully";
            $class = "container-fluid alert alert-success col-lg-8";
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8";
        }
        echo "<script>
        const msg = document.getElementById(\"display-msg\");
        msg.className=\"${class}\";
        msg.textContent = \"${getMsg}\";
        msg.style.display =\"inherit\";
        </script>";
        $connect = NULL;
    }
    public function delete($id){
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $query = "DELETE FROM Categories WHERE id=:id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id);
        $exec = $stmt->execute();
        $connect = null;
    }
    public function search($id=null){
        try{
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Connection-Failed: " . $e->getMessage();
        }
        if(is_numeric($id)){
            $query = "SELECT * FROM Categories WHERE id=${id}";
        }else{
            $query = "SELECT * FROM Categories";
        }
        $stmt= $connect->query($query);
        $arr = array();
        while($data_rows = $stmt->fetch()){
            $act_obj = new Category();
            $id = $data_rows["id"];
            $title = $data_rows["title"];
            $author = $data_rows["author"];
            $date = $data_rows["date"];
            $act_obj->construct($id, $title, $author, $date);
            array_push($arr, $act_obj);
        } 
        $connect = NULL;
        return $arr;
    }

    public function get_id(){
        return $this->id;
    }
    public function get_author(){
        return $this->author;
    }
    public function get_title(){
        return $this->title;
    }
    public function get_date(){
        return $this->date;
    }


    public function set_author($author){
        $this->author = $author;
    }
    public function set_title($title){
        $this->title = $title;
    }
    public function set_date($date){
        $this->date = $date;
    }
}


?>