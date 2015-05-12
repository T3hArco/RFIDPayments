<?php

if(!defined("main"))
    die();

$host = "63.143.48.153";
$user = "ehackb_rfid";
$pass = "A6Smv2NjUVDWwd2N";
$data = "ehackb_rfid";

$db = new mysqli($host, $user, $pass, $data);

if($db->connect_error)
    die("Connection failed: " . $db->connect_error);