<?php

if(!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['cashier'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

if(isset($_POST['rfid'])) {
    $total = $_POST['totaal'];
    $rfid = $_POST['rfid'];
    $user = $_SESSION['id'];

    if($total < 0)
        die("Het totaal kan /niet/ negatief zijn..");

    $balance = $db2->getDbObject()->prepare("SELECT balance FROM users WHERE rfid_tag = ?;");
    if($balance->execute(array($rfid))) {
        $balance = ($balance->fetchAll()[0]['balance'] - $total);

        if($balance < 0) {
            echo("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> De balans van deze gebruiker zou bij deze actie onder nul gaan.</div>");
        } else {
            $updateBalance = $db2->getDbObject()->prepare("UPDATE users SET balance = balance - ? WHERE rfid_tag = ?;");
            $makeTransaction = $db2->getDbObject()->prepare("INSERT INTO sales(user, amount, purchasedate) VALUES(?, ?, NOW())");
            if($updateBalance->execute(array($total, $rfid)) && $makeTransaction->execute(array($user, $total))) {
                echo '<div class="alert alert-success"><strong>OK!</strong> Aankoop geregistreerd. Nieuwe balans: <strong>' . $balance . '</strong></div>';
                $log->log("SALE", "Made sale to " . $rfid . " for " . $balance);
            }
        }
    }
}

?>

<div id="result"></div>

<div class="row">
    <div class="col-md-8">
        <? echo $pos->buildProductList() ?>
    </div>
    
    <div class="col-md-4">
        <div><a href="#" class="thumbnail" onclick="return clearPos();"><div class="thumbnail"><img src="assets/food/clear.png" alt="Clear" style="height:64px;"></div><div class="caption"><h3>Begin opnieuw</h3><p>Reset het winkelmandje</p></div></a></div>
        <div class="well">
            <form class="form-horizontal" role="form" id="cashierForm" name="cashierForm" method="post">
                <div class="form-group" id="cashierForm">
                    <label for="total" class="col-sm-2 control-label">Totaal</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="total" name="totaal" placeholder="Totaal" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label for="total" class="col-sm-2 control-label">RFID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rfid" name="rfid" placeholder="RFID">
                    </div>
                </div>

                <input type="hidden" id="tf">

                <hr>

                <input type="submit" class="btn btn-block" id="paybutton" value="Maak betaling!" id="cash-submit">
            </form>

            <hr>

            <table class="table table-striped" id="receipt">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Prijs</th>
                <tr>
                </thead>
            </table>
        </div>
    </div>

    <br class="clear" />
</div>