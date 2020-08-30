<?php
$GLOBALS["dsn"] =  "mysql:host=127.0.0.1;dbname=cms";
$GLOBALS["username_db"] = "wherever";
$GLOBALS["password_db"] = "password";

class Admin
{
    private $id;
    private $username;
    private $password;
    private $name;
    private $added_by;
    private $date;
    private $image;
    private $headline;
    private $description;
    function __construct($username = "", $password = "", $name = null, $added_by = "nobody", $date = "", $image ="", $headline ="", $description="")
    {
        $this->username = $username;
        $this->password = $password;
        $name == null ? $this->name = $name : $this->name = ucfirst(strtolower($name));
        $this->added_by = $added_by;
        $this->date = $date;
        $this->image = $image;
        $this->headline = $headline;
        $this->description = $description;
    }
    public function construct($id = "", $username = "", $password = "", $name = null, $added_by = "nobody", $date = "", $image ="", $headline ="", $description="")
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $name == null ? $this->name = $name : $this->name = ucfirst(strtolower($name));
        $this->added_by = $added_by;
        $this->date = $date;
        $this->image = $image;
        $this->headline = $headline;
        $this->description = $description;
    }
    public function insert()
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO `Admins`(`username`, `password`, `name`, `added_by`, `date`, `image`, `headline`,`description`)
                    VALUES(:username, :password, :name, :added_by, :date, :image, :headline, :description);";

        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':added_by', $this->added_by);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':image', $this->image);
        $stmt->bindParam(':headline', $this->headline);
        $stmt->bindParam(':description', $this->description);
        $exec = $stmt->execute();
        $this->id = $connect->lastInsertId();
        global $getMsg;
        global $class;
        if ($exec) {
            $getMsg = "The Admin $this->username was submitted";
            $class = "container-fluid alert alert-success col-lg-8 mt-2";
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8 mt-2";
        }
        echo "<script type=\"text/javascript\"> 
                    const msgdb = document.getElementById(\"display-msg\");
                    msgdb.className=\"${class}\";
                    msgdb.textContent= \"${getMsg}\";
                    msgdb.style.display=\"inherit\";
                  </script>";
        $connect = NULL;
    }



    public function update($obj)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $id = $obj->get_id();
        global $class;
        global $getMsg;
        $username = $obj->get_username();
        $password = $obj->get_password();
        $name = $obj->get_name();
        $added_by = $obj->get_added_by();
        $date = $obj->get_date();
        $query = "UPDATE `Admins` SET username=:username, password=:password, name=:name, added_by=:added_by, 
        date=:date WHERE id=${id}";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':added_by', $added_by);
        $stmt->bindParam(':date', $date);
        $exec = $stmt->execute();
        if ($exec) {
            $getMsg = "The Admin $this->username was edited succesfully";
            $class = "container-fluid alert alert-success col-lg-8";
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8";
        }
        $connect = NULL;
        /*
        echo "<script type=\"text/javascript\">
                const a = document.createElement(\"a\");
                a.href=\"index.php?pages=&class=$class&msg=$getMsg\" 
                a.click();
                </script>";*/
    }
    public function update_profile($obj)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $id = $obj->get_id();
        global $class;
        global $getMsg;
        if(!empty($_FILES["image"]["name"])){
            $image = $obj->get_id().$obj->get_image();
        }else $image = $obj->get_image();
       
        $password = $obj->get_password();
        $name = $obj->get_name();
        $headline = $obj->get_headline();
        $description = $obj->get_description();
        $query = "UPDATE `Admins` SET password=:password, name=:name, image=:image, headline=:headline, 
        description=:description WHERE id=${id}";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':headline', $headline);
        $stmt->bindParam(':description', $description);
        $exec = $stmt->execute();
        if ($exec) {
            $test_admin = new Admin();
            $arr = $test_admin->search("SELECT * FROM Admins WHERE id=${id}");
            $obj_admin = $arr[0];
            if($name == $obj_admin->get_name() && $headline == $obj_admin->get_headline() && $description == $obj_admin->get_description()
             && $password== $obj_admin->get_password() && $image == $obj_admin->get_image()){
                $getMsg = "Nothing change";
                $class = "container-fluid alert alert-info col-lg-8";
            }else{
                $getMsg = "The Admin change were edited succesfully";
                $class = "container-fluid alert alert-success col-lg-8";
            }
            $img_path = "uploads/" . basename($image);
          if($image != null ) {
              move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
            echo "<script> location.href=\"cms.php?pages=profile\" </script>";
          }
          echo "<script> 
          const msg = document.getElementById(\"display-msg\");
          msg.className =\"$class\"
          msg.textContent=\"$getMsg\"
          msg.style.display=\"inherit\"
          </script>";
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8";
        }
        $connect = NULL;
        /*
        echo "<script type=\"text/javascript\">
                const a = document.createElement(\"a\");
                a.href=\"index.php?pages=&class=$class&msg=$getMsg\" 
                a.click();
                </script>";*/
    }
    public function delete($id)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $query = "DELETE FROM Admins WHERE id=:id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id);
        $exec = $stmt->execute();
        $connect = null;
    }
    static function search($query)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $arr = array();
        $stmt = $connect->query($query);
        if ($stmt == NULL) {
            $connect = NULL;
            return NULL;
        }
        while ($data_rows = $stmt->fetch()) {
            $act_admin = new Admin();
            $act_admin->construct(
                $data_rows["id"],
                $data_rows["username"],
                $data_rows["password"],
                $data_rows["name"],
                $data_rows["added_by"],
                $data_rows["date"],
                $data_rows["image"],
                $data_rows["headline"],
                $data_rows["description"]
            );
            array_push($arr, $act_admin);
        }
        $connect = NULL;
        return $arr;
    }

    public function get_username()
    {
        return $this->username;
    }
    public function get_password()
    {
        return $this->password;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_added_by()
    {
        return $this->added_by;
    }
    public function get_date()
    {
        return $this->date;
    }
    public function get_image()
    {
        return $this->image;
    }
    public function get_headline()
    {
        return $this->headline;
    }
    public function get_description()
    {
        return $this->description;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function set_username($username)
    {
        $this->username = $username;
    }
    public function set_password($password)
    {
        $this->password = $password;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
    public function set_added_by($added_by)
    {
        $this->added_by = $added_by;
    }
    public function set_date($date)
    {
        $this->date = $date;
    }
    
}
