<?php

if(!defined("main"))
   die();

function authenticateUser($user, $pass, $rfid, $db, $log) {
    $user = $user;
    $pass = md5(sha1($pass));
    $rfid = $rfid;
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if($user == "attendee")
        return false;
    
    if(isset($_SESSION['authenticated']))
        return false;

    $isAllowed = $db->getDbObject()->prepare("SELECT * FROM allowedIps WHERE ip = ?;");
    if($isAllowed->execute(array($ip))) {
        if($isAllowed->rowCount() == 0) {
            $log->log("INTRUSION", "User IP not in table");
            return false;
        }
    }

    $accountExists = $db->getDbObject()->prepare("SELECT * FROM users WHERE (rfid_tag = ? AND username = ? AND password = ? AND username != 'attendee');");
    if($accountExists->execute(array($rfid, $user, $pass))) {
        if($accountExists->rowCount() == 0) {
            $log->log("FAILEDLOG", "IP whitelisted, user/pass wrong");
            return false;
        }

        $data = $accountExists->fetchAll()[0];
        $_SESSION['root'] = $data['root'];
        $_SESSION['admin'] = $data['admin'];
        $_SESSION['cashier'] = $data['cashier'];
        $_SESSION['registration'] = $data['registration'];
        $_SESSION['authenticated'] = true;
        $_SESSION['fullname'] = $data['fullname'];
        $_SESSION['id'] = $data['id'];

        header("Location: index.php?page=home");
    }

    return true;
}