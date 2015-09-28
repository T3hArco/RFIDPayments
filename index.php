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

ini_set("display_errors", 1);
//error_reporting("~NOTICE");

//include("lib/db.php");
include("lib/user.php");
include("lib/pos.php");

include("class/Database.class.php");
include("class/Pos.class.php");
include("class/Logger.class.php");

$db2 = new pos\Database("127.0.0.1", "root", "root", "ehackb_deve");
$pos = new pos\Pos($db2->getDbObject());
$log = new helpers\Logger($db2->getDbObject());

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rfid']))
    authenticateUser($_POST['username'], $_POST['password'], $_POST['rfid'], $db2, $log);

if (!isset($_GET['page']))
    $_GET['page'] = "";

if ($_GET['page'] == "logout") {
    session_destroy();
    header("Location: index.php?page=login");
}

if ($_GET['page'] == "authenticate" && isset($_SESSION['authenticated']))
    header("Location: ?page=home");

if (!isset($_SESSION['authenticated']) && $_GET['page'] != "authenticate")
    header("Location: ?page=authenticate");

/*
 * Page initialization
 */

include "partials/header.php";

switch ($_GET['page']) {
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