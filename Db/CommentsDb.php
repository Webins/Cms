<?php
$GLOBALS["dsn"] =  "mysql:host=127.0.0.1;dbname=cms";
$GLOBALS["username"] = "wherever";
$GLOBALS["password"] = "password";

class Comment
{
    private $id;
    private $post_id;
    private $name;
    private $email;
    private $comment;
    private $approved_by;
    private $status;
    private $date;
    function __construct($post_id = "", $name = "", $email = "", $comment = "", $approved_by = "nobody", $status = false, $date = "")
    {
        $this->post_id = $post_id;
        $this->name = ucfirst(strtolower($name));
        $this->email = $email;
        $this->comment = ucfirst(strtolower($comment));
        $this->approved_by = $approved_by;
        $this->status = $status;
        $this->date = $date;
    }
    public function construct($id = "", $post_id = "", $name = "", $email = "", $comment = "", $approved_by = "nobody", $status = false, $date = "")
    {
        $this->id = $id;
        $this->post_id = $post_id;
        $this->name = ucfirst(strtolower($name));
        $this->email = $email;
        $this->comment = ucfirst(strtolower($comment));
        $this->approved_by = $approved_by;
        $this->status = $status;
        $this->date = $date;
    }
    public function insert()
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO `Comments`(`post_id`, `name`, `email`, `comment`, `approved_by`, `status`, `date`)
                    VALUES(:post_id, :name, :email, :comment, :approved_by, :status, :date);";

        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':post_id', $this->post_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':comment', $this->comment);
        $stmt->bindParam(':approved_by', $this->approved_by);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':date', $this->date);
        $exec = $stmt->execute();
        $this->id = $connect->lastInsertId();
        global $getMsg;
        global $class;
        if ($exec) {
            $getMsg = "The Comment was submitted, you need to wait for an admin to approve it";
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



    public function update($query, $status, $who)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $time = get_time();
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':approved_by', $who);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':date', $time);
        $exec = $stmt->execute();
        if ($exec) {
            $getMsg = "The Comment was edited succesfully";
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
    public function delete($id)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $query = "DELETE FROM Comments WHERE id=:id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id);
        $exec = $stmt->execute();
        $connect = null;
    }
    static function search($query)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username"], $GLOBALS["password"], null);
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
            $act_comment = new Comment();
            $act_comment->construct(
                $data_rows["id"],
                $data_rows["post_id"],
                $data_rows["name"],
                $data_rows["email"],
                $data_rows["comment"],
                $data_rows["approved_by"],
                $data_rows["status"],
                $data_rows["date"]
            );
            array_push($arr, $act_comment);
        }
        $connect = NULL;
        return $arr;
    }

    public function get_post_id()
    {
        return $this->post_id;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_email()
    {
        return $this->email;
    }
    public function get_comment()
    {
        return $this->comment;
    }
    public function get_approved_by()
    {
        return $this->approved_by;
    }
    public function get_status()
    {
        return $this->status;
    }

    public function get_date()
    {
        return $this->date;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function set_post_id($post_id)
    {
        $this->post_id = $post_id;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
    public function set_email($email)
    {
        $this->email = $email;
    }
    public function set_comment($comment)
    {
        $this->comment = $comment;
    }
    public function set_approved_by($approved_by)
    {
        $this->approved_by = $approved_by;
    }
    public function set_status($status)
    {
        $this->status = $status;
    }
    public function set_date($date)
    {
        $this->date = $date;
    }
}
