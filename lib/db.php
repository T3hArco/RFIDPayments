<?php

if(!defined("main"))
    die();

$host = "localhost";
$user = "root";
$pass = "root";
$data = "ehackb_pos";

$db = new mysqli($host, $user, $pass, $data);

if($db->connect_error)
    die("Connection failed: " . $db->connect_error);