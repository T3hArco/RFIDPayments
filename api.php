<?php

 /*************************************************************************
 * 
 * EHACKB RFID SYSTEM
 * __________________
 * 
 *  [2014] - [2015] Arnaud Coel 
 *  All Rights Reserved.
 * 
 */

header('Content-Type: application/json');
define("main", true);
session_start();

function jsonify($array) {
  return json_encode($array);
}

function message($message, $error = 0) {
  if($error)
    return jsonify(array("Error", $message));

  return jsonify(array("OK", $message));
} 

include("lib/db.php");
include("lib/user.php");
include("lib/pos.php");

if(!isset($_SESSION['authenticated']) || ($_SESSION['cashier'] == 0 || $_SESSION['admin'] == 0))
  die(jsonify(array("Error", "Access denied")));

if(!isset($_GET['act']))
  $_GET['act'] = "";

switch($_GET['act']) {
  case 'checkbal':
    $rfid = mysqli_real_escape_string($db, $_GET['id']);

    if($result = mysqli_query($db, "SELECT balance FROM users WHERE rfid_tag = '" . $rfid . "';")) {
      if(mysqli_num_rows($result) == 0) {
        echo message("Unknown ID", 1);
        return;
      }

      echo jsonify(array("Balance", mysqli_fetch_row($result)[0]));
    }
    break;

  case 'register':
    $rfid = mysqli_real_escape_string($db, $_GET['rfid']);
    if(!$result = mysqli_query($db, "INSERT INTO users (rfid_tag, admin, cashier, balance) VALUES ('" . $rfid . "', '0', '0', '0');"))
      echo message("Duplicate", true);
    else 
      echo message("Badge registered in system");

    break;

  default:
    echo message("Invalid call", 1);
    break;
}
