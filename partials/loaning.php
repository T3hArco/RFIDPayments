<?php

define("bitmaster", true);

if (!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['loaner'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

if (isset($_POST['rfid'])) {
    $rfid = $_POST['rfid'];
    $loaner = $_SESSION['id'];
    $item = strip_tags($_POST['item']);
    $userId = -1;

    $userIdQuery = $db2->getDbObject()->prepare("SELECT id FROM users WHERE rfid_tag = ?");
    if ($userIdQuery->execute(array($rfid))) {
        $userId = @$userIdQuery->fetchAll()[0]['id'];

        $loan = $db2->getDbObject()->prepare("INSERT INTO loans (item, loanerId, staffId) VALUES (?, ?, ?);");
        if (!$loan->execute(array($item, $userId, $loaner))) {
            echo '<div class="alert alert-danger">User not loaned, radio Arnaud.. (or duplicate??)</div>';
            $log->log("ERROR", "Failed user registration " . $rfid);
        } else {
            echo '<div class="alert alert-success">Object werd uitgeleend</div>';
            $log->log("USER", "Loaned to user " . $rfid);
        }
    } else {
        echo '<div class="alert alert-danger">User not loaned, radio Arnaud.. (or duplicate??)</div>';
        $log->log("ERROR", "Failed user loan " . $rfid);
    }
}

if(isset($_GET['loan']))
{
    switch($_GET['loan'])
    {
        case "success":
            echo sprintf('<div class="alert alert-success">%s</div>', "Item updated");
            break;

        default:
        case "error":
            echo sprintf('<div class="alert alert-danger">%s</div>', "Item niet updated");
            break;
    }
}

?>

<h1>EhackB Uitleendienst</h1>
<form id="loanForm" method="post" action="?page=loaning">
    <div class="form-group">
        <label for="rfid">RFID</label>
        <input type="text" class="form-control" name="rfid" id="rfid"/>
    </div>

    <div class="form-group">
        <label for="item">Item</label>
        <input type="text" class="form-control" name="item" id="item"/>
    </div>

    <input type="submit" class="btn-block" value="Maak aan">
</form>

<hr/>

<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Item</th>
        <th>Bezoeker</th>
        <th>Crew</th>
        <th>Acties</th>
    </tr>
    </thead>

    <tbody>
    <?php
    $loansQ = $db2->getDbObject()
        ->prepare("SELECT l.id id, l.item item, u1.fullname loanerName, u2.fullname staffName, l.returned returned FROM loans l 
                            JOIN users u1 ON(l.loanerId = u1.id) 
                            JOIN users u2 ON(l.staffId = u2.id)
                            ORDER BY l.returned, l.id DESC;");

    $loansQ->execute();
    $loans = $loansQ->fetchAll();

    foreach ($loans as $loan) {
        if ($loan["returned"] == "1") {
            $button = sprintf('<a href="?page=loaning&return=%s" class="btn btn-danger" role="button">Undo</a>', $loan["id"]);
        } else {
            $button = sprintf('<a href="?page=loaning&return=%s" class="btn btn-default" role="button">Return</a>', $loan["id"]);
        }

        echo sprintf(
            '<tr><th scope="row">%s</th><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',
            $loan["id"],
            $loan["item"],
            $loan["loanerName"],
            $loan["staffName"],
            $button
        );
    }

    ?>
    </tbody>
</table>