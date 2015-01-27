<?php

if(!defined("main"))
    die();

$host = "63.143.48.153";
$user = "ehackb";
$pass = "yJdVcTjncvWwP9eK";
$data = "ehackb_rfid";

$db = new mysqli($host, $user, $pass, $data);

if($db->connect_error)
    die("Connection failed: " . $db->connect_error);