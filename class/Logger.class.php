<?php
/**
 * Created by IntelliJ IDEA.
 * User: arnaudcoel
 * Date: 28/09/15
 * Time: 14:06
 */

namespace helpers;


class Logger
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function log($type, $data) {
        if(isset($_SESSION['id']))
            $user = $_SESSION['id'];

        else
            $user = 0;

        $ip = $_SERVER['REMOTE_ADDR'];
        $page = $_SERVER['REQUEST_URI'];

        $log = $this->db->prepare("INSERT INTO log(user, datetime, type, page, ip, data) VALUES(?, NOW(), ?, ?, ?, ?)");
        $log->execute(array($user, $type, $page, $ip, $data));
    }
}