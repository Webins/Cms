<?php 
    function get_time(){
        date_default_timezone_set("Etc/GMT+4");
        $time = time();
        $time = strftime("%Y-%m-%d %H:%M:%S",$time);
        return $time;
    }
?>