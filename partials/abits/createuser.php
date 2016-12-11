<?php

if (!defined("bitmaster"))
    die();

if(isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = md5(sha1($_POST['password']));
    $rfid = $_POST['rfid'];
    $fname = $_POST['fname'];
    $cashier = 0;
    $admin = 0;
    $registration = 0;
    $loaner = 0;

    if(isset($_POST['admin'])) {
        $admin = 1;
        $cashier = 1;
        $registration = 1;
        $loaner = 1;
    }

    if(isset($_POST['cashier']))
        $cashier = 1;

    if(isset($_POST['registration']))
        $registration = 1;

    if(isset($_POST['loaner']))
        $loaner = 1;

    $adduser = $db2->getDbObject()->prepare("INSERT INTO users (rfid_tag, admin, cashier, registration, balance, fullname, username, password, loaner) VALUES (?, ?, ?, ?, '0', ?, ?, ?, ?);");
    if(!$adduser->execute(array($rfid, $admin, $cashier, $registration, $fname, $username, $password, $loaner))) {
        echo '<div class="alert alert-danger">User not added, radio Arnaud.. (or duplicate??)</div>';
        $log->log("ERROR", "Failed user registration " . $rfid);
    } else {
        echo '<div class="alert alert-success">Gebruiker toegevoegd..</div>';
        $log->log("USER", "Registered user " . $rfid);
    }
}

?>

<form id="addUserForm" method="post">
    <div class="form-group">
        <label for="username">Gebruikersnaam</label>
        <input type="text" class="form-control" name="username" id="username"/>
    </div>

    <div class="form-group">
        <label for="fname">Volledige naam</label>
        <input type="text" class="form-control" name="fname" id="fname"/>
    </div>

    <div class="form-group">
        <label for="password">Wachtwoord</label>
        <input type="password" class="form-control" name="password" id="password"/>
    </div>

    <div class="form-group">
        <label>Gebruikersrechten</label>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="loaner">
                Loaner
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="cashier">
                Cashier
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="registration">
                Registration
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="admin">
                Admin
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="rfid">RFID</label>
        <input type="text" class="form-control" name="rfid" id="rfid"/>
    </div>

    <input type="submit" class="btn-block" value="Maak aan">
</form>