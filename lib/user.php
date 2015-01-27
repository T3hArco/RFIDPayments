<?php

if(!defined("main"))
   die();

function authenticateUser($user, $pass, $rfid, $db) {
    $user = mysqli_real_escape_string($db, $user);
    $pass = mysqli_real_escape_string($db, md5(sha1($pass)));
    $rfid = mysqli_real_escape_String($db, $rfid);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    if($user == "attendee")
        return false;
    
    if(isset($_SESSION['authenticated']))
        return false;
    
    if($result = mysqli_query($db, "SELECT * FROM allowedIps WHERE ip = '" . $ip. "';")) {
        if(mysqli_num_rows($result) == 0) {
            echo("Debug: user IP not in table" . $_SERVER['REMOTE_ADDR']);
            return false;
        }
    }
    
    if($result = mysqli_query($db, "SELECT * FROM users WHERE (rfid_tag = '" . $rfid . "' AND username = '" . $user . "' AND password = '" . $pass . "' AND username != 'attendee');")) {
        if(mysqli_num_rows($result) == 0) {
            echo("Debug: user allowed in IP, but not in table");
            return false;
        } 
        
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['admin'] = $data['admin'];
        $_SESSION['cashier'] = $data['cashier'];
        $_SESSION['registration'] = $data['registration'];
        $_SESSION['authenticated'] = true;
        $_SESSION['fullname'] = $data['fullname'];
        echo("Debug: authenticated");
    }    
}