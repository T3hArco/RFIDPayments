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

define("main", true);
session_start();

include("lib/db.php");
include("lib/user.php");
include("lib/pos.php");

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rfid']))
   authenticateUser($_POST['username'], $_POST['password'], $_POST['rfid'], $db);

if(!isset($_GET['page']))
    $_GET['page'] = "";

if($_GET['page'] == "logout") {
    session_destroy();
    header("Location: index.php?page=login");
}

if($_GET['page'] == "authenticate" && isset($_SESSION['authenticated'])) {
    /*if($_SESSION['cashier'] == 1 && $_SESSION['admin'] == 1)
        header("Location: ?page=admin");
    else if($_SESSION['cashier'] == 1)
        header("Location: ?page=cashier");
    else
        header("Location: ?page=registration");*/
    header("Location: ?page=home");
}

if(!isset($_SESSION['authenticated']) && $_GET['page'] != "authenticate")
    header("Location: ?page=authenticate");

/*
 * Page initialization
 */

include "partials/header.php";

switch($_GET['page']) {
    case 'authenticate':
        include "partials/authenticate.php";
        break;
    
    case 'admin':
        include "partials/admin.php";
        break;

    case 'registration':
        include "partials/registration.php";
        break;
    
    case 'cashier':
        include "partials/cashier.php";
        break;

    case 'home':
        include "partials/home.php";
        break;
    
    case 'logout':
        session_destroy();
        break;
    
    default:
        include "partials/404.php";
        break;
}

include "partials/footer.php";