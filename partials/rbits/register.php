<?php

if (!defined("bitmaster"))
    die();

if (!isset($error))
    $error = false;

/*if (isset($_POST['rfid'])) {
    $error = false;
    $rfid = mysqli_real_escape_string($db, $_POST['rfid']);
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $balance = mysqli_real_escape_string($db, $_POST['balance']);

    if ($result = mysqli_query($db, "INSERT INTO users (rfid_tag, admin, cashier, balance, fullname) VALUES ('" . $rfid . "', 0, 0, '" . $balance . "', '" . $name . "');")) {
        echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Gebruiker is geregistreerd, RFID gelinkt</div>';
        $log->log("USER", "Registered user " . $name . " with RFID " . $rfid . " with " . $balance);
    } else {
        $error = true;
        echo '<div class="notice error"><span class="glyphicon glyphicon-remove"></span> Gebruiker is NIET geregistreerd. Bestaat de RFID kaart al?</div>';
        $log->log("ERROR", "Failed to register " . $rfid . " with " . $balance . " already exists");
    }
}*/

if (isset($_POST['rfid'])) {
    $error = false;
    $rfid = $_POST['rfid'];
    $name = $_POST['name'];
    $balance = $_POST['balance'];

    $newUser = $db2->getDbObject()->prepare("INSERT INTO users (rfid_tag, admin, cashier, balance, fullname) VALUES (?, 0, 0, ?, ?);");
    if ($newUser->execute(array($rfid, $balance, $name))) {
        echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Gebruiker is geregistreerd, RFID gelinkt</div>';
        $log->log("USER", "Registered user " . $name . " with RFID " . $rfid . " with " . $balance);
    } else {
        $error = true;
        echo '<div class="notice error"><span class="glyphicon glyphicon-remove"></span> Gebruiker is NIET geregistreerd. Bestaat de RFID kaart al?</div>';
        $log->log("ERROR", "Failed to register " . $rfid . " with " . $balance . " already exists");
    }
}

?>

<form id="registrationForm" method="post">
    <div class="form-group">
        <label for="name">Naam</label>
        <input type="text" class="form-control" name="name"
               id="name" <?php if ($error) echo "value='" . strip_tags($_POST['name']) . "'" ?> />
    </div>
    <div class="form-group">
        <label for="balance">Balans</label>
        <input type="number" class="form-control" name="balance" id="balance" value="0"
               onchange="alert('Misbruik wordt gelogd!')"/>
    </div>
    <div class="form-group">
        <label for="rfid">RFID</label>
        <input type="text" class="form-control" name="rfid" id="rfid"/>
    </div>
    <input type="submit" class="btn-block" value="Complete registration">
</form>

<script>
    $(function() {
        $( "#name" ).autocomplete({
            source: 'api.php?act=getNames'
        });
    });
</script>
