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

function jsonify($array)
{
    return json_encode($array);
}

function message($message, $error = 0)
{
    if ($error)
        return jsonify(array("Error", $message));

    return jsonify(array("OK", $message));
}

include("lib/db.php");
include("lib/user.php");
include("lib/pos.php");
include("class/Database.class.php");

$db2 = new \pos\Database("localhost", "root", "root", "ehackb_pos");

if (!isset($_SESSION['authenticated']) || $_SESSION['cashier'] == 0)
    die(jsonify(array("Error", "Access denied")));

if (!isset($_GET['act']))
    $_GET['act'] = "";

switch ($_GET['act']) {
    case 'checkbal':
        $rfid = $_GET['id'];

        $account = $db2->getDbObject()->prepare("SELECT balance FROM users WHERE rfid_tag = ?;");
        if ($account->execute(array($rfid))) {
            if ($account->rowCount() == 0) {
                echo message("Unknown ID", 1);
                return;
            }

            echo jsonify(array("Balance", $account->fetchAll()[0]['balance']));
        }
        break;

    case 'register':
        $rfid = $_GET['rfid'];

        $register = $db2->getDbObject()->prepare("INSERT INTO users (rfid_tag, admin, cashier, balance) VALUES (?, '0', '0', '0');");
        if (!$register->execute(array($rfid)))
            echo message("Duplicate", true);
        else
            echo message("Badge registered in system");

        break;

    case 'getNames':
        $name = '%' . $_GET['term'] . '%';

        $getNames = $db2->getDbObject()->prepare("SELECT concat(firstName, ' ', lastName) name FROM externalUsers WHERE lower(firstName) LIKE lower(?) OR lower(lastName) LIKE lower(?) OR lower(email) LIKE lower(?);");
        $getNames->execute(array($name, $name, $name));

        $output = array();

        foreach($getNames->fetchAll() as $user)
            array_push($output, $user['name']);

        echo json_encode($output);

        break;

    case 'getSales':
        $salesByHour = $db->getDbObject()->query("SELECT HOUR(purchasedate), SUM(amount) FROM sales GROUP BY HOUR(purchasedate)")->fetchAll();
        $output = array();

        foreach($salesByHour as $hour) {
            array_push($output, array($hour[0] => $hour[1]));
        }

        echo json_encode($output);

        break;

    case 'md5':
        echo jsonify("md5", md5(sha1($_GET['md5'])));
        break;

    default:
        echo message("Invalid call", 1);
        break;
}
