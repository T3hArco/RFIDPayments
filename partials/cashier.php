<?php

if(!defined("main") || !isset($_SESSION['authenticated']) || $_SESSION['cashier'] != 1)
    die("<div class='notice error'><span class='glyphicon glyphicon-minus-sign'></span> <strong>Fout!</strong> Uw account heeft geen toegang tot deze module. De toegang is gelogd en geweigerd.</div>");

if(isset($_POST['rfid'])) {
    $total = mysqli_real_escape_string($db, $_POST['totaal']);
    $rfid = mysqli_real_escape_string($db, $_POST['rfid']);

    if($total < 0)
        die("Het totaal kan /niet/ negatief zijn..");

    if($result = mysqli_query($db, "SELECT balance FROM users WHERE rfid_tag = '" . $rfid . "';")) {
        $balance = (mysqli_fetch_row($result)[0] - $total);

        if($balance < 0) {
            die("That's an error..");
        } else {
            if($result = mysqli_query($db, "UPDATE users SET balance = balance - '" . $total . "' WHERE rfid_tag = '" . $rfid . "';")) {
                echo '<div class="alert alert-success"><strong>OK!</strong> Aankoop geregistreerd. Nieuwe balans: <strong>' . $balance . '</strong></div>';
            }
        }
    }
}

?>

<div id="result"></div>

<div class="row">
    <div class="col-md-8">
        <?php echo buildPosIcons($db); ?>
    </div>
    
    <div class="col-md-4">
        <div class="well">
            <form class="form-horizontal" role="form" id="cashierForm" name="cashierForm" method="post">
                <table class="table table-striped" id="receipt">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Prijs</th>
                        <tr>
                    </thead>
                </table>
                
            <hr>

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
        
            <input type="submit" class="btn-block" value="Maak betaling!" onclick="return contactCardApi();">
        </div>
    </div>
</div>