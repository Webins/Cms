<?php
$GLOBALS["dsn"] =  "mysql:host=127.0.0.1;dbname=cms";
$GLOBALS["username_db"] = "wherever";
$GLOBALS["password_db"] = "password";

class Post
{
    private $id;
    private $title;
    private $category;
    private $author;
    private $image;
    private $post;
    private $date;
    function __construct($title = "", $category = "", $author = "admin", $image = "", $post = "", $date = "")
    {
        $this->title = ucfirst(strtolower($title));
        $this->category = ucfirst(strtolower($category));
        $this->author = ucfirst(strtolower($author));
        $this->image = $image;
        $this->post = ucfirst(strtolower($post));
        $this->date = $date;
    }
    public function construct($id = "", $title = "", $category = "", $author = "admin", $image = "", $post = "", $date = "")
    {
        $this->id = $id;
        $this->title = ucfirst(strtolower($title));
        $this->category = ucfirst(strtolower($category));
        $this->author = ucfirst(strtolower($author));
        $this->image = $image;
        $this->post = ucfirst(strtolower($post));
        $this->date = $date;
    }
    public function insert()
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $sql = "INSERT INTO `Posts`(`title`, `category`, `author`, `image`, `post`, `date`)
                    VALUES(:title, :category, :author, :image, :post, :date);";
        $image = $this->date.$this->image;
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':post', $this->post);
        $stmt->bindParam(':date', $this->date);
        $exec = $stmt->execute();
        $this->id = $connect->lastInsertId();
        global $getMsg;
        global $class;
        $title_msg = $this->title;
        if ($exec) {
            $getMsg = "The Post ${title_msg} was added succesfully";
            $class = "container-fluid alert alert-success col-lg-8";
            $img_path = "uploads/" . basename($image);
            move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8";
        }
        echo "<script type=\"text/javascript\"> 
                    const msgdb = document.getElementById(\"display-msg\");
                    msgdb.className=\"${class}\";
                    msgdb.textContent= \"${getMsg}\";
                    msgdb.style.display=\"inherit\";
                  </script>";
        $connect = NULL;
    }



    public function update($obj, $upd_image=false, $old_path=null)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $id = $obj->get_id();
        global $title;
        global $getMsg;
        $title = $obj->get_title();
        $category = $obj->get_category();
        $author = $obj->get_author();
        $image = $obj->get_image();
        $post = $obj->get_post();
        $date = $obj->get_date();
        if($upd_image){
            $query = "UPDATE `Posts` SET title=:title, category=:category, author=:author, image=:image,
            post=:post, date=:date WHERE id=${id}";
        }else{
            $query = "UPDATE `Posts` SET title=:title, category=:category, author=:author,
            post=:post, date=:date WHERE id=${id}";
        }
        
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':author', $author);
        if($upd_image){
            $act_image = $date.$image;
            $stmt->bindParam(':image', $act_image);
        }
        $stmt->bindParam(':post', $post);
        $stmt->bindParam(':date', $date);
        $exec = $stmt->execute();
        if ($exec) {
            $getMsg = "The Post ${title} was edited succesfully";
            $class = "container-fluid alert alert-success col-lg-8";
            if($upd_image){
                unlink($old_path);
                $img_path = "uploads/" . basename($act_image);
                move_uploaded_file($_FILES["image"]["tmp_name"], $img_path);
            }
            
        } else {
            $getMsg = "An error with the database has ocurred, please try again later";
            $class = "container-fluid alert alert-danger col-lg-8";
        }
        $connect = NULL;
        echo "<script type=\"text/javascript\">
                const a = document.createElement(\"a\");
                a.href=\"cms.php?pages=post&class=$class&msg=$getMsg\" 
                a.click();
                </script>";
        
    }
    public function delete($obj)
    {
        try {
            $connect = new PDO($GLOBALS["dsn"], $GLOBALS["username_db"], $GLOBALS["password_db"], null);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection-Failed: " . $e->getMessage();
        }
        $id = $obj->get_id();
        $query = "DELETE FROM Posts WHERE id=:id";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':id', $id);
        $exec= $stmt->execute();
        if($exec){
            $path = "uploads/".$obj->get_image();
            unlink($path);
        }
        $connect=null;
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
            $act_post = new Post();
            $act_post->construct(
                $data_rows["id"],
                $data_rows["title"],
                $data_rows["category"],
                $data_rows["author"],
                $data_rows["image"],
                $data_rows["post"],
                $data_rows["date"]
            );
            array_push($arr, $act_post);
        }
        $connect = NULL;
        return $arr;
    }

    public function get_title()
    {
        return $this->title;
    }
    public function get_category()
    {
        return $this->category;
    }
    public function get_author()
    {
        return $this->author;
    }
    public function get_image()
    {
        return $this->image;
    }
    public function get_post()
    {
        return $this->post;
    }
    public function get_date()
    {
        return $this->date;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function set_title($title)
    {
        $this->title = $title;
    }
    public function set_category($category)
    {
        $this->category = $category;
    }
    public function set_author($author)
    {
        $this->author = $author;
    }
    public function set_image($image)
    {
        $this->image = $image;
    }
    public function set_post($post)
    {
        $this->post = $post;
    }
    public function set_date($date)
    {
        $this->date = $date;
    }
}
