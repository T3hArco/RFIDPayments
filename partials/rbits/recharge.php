<?php

if(!defined("bitmaster"))
  die();

if(isset($_POST['rfid'])) {
  $error = false;
  $rfid = mysqli_real_escape_string($db, $_POST['rfid']);
  $balance = mysqli_real_escape_string($db, $_POST['balance']);

  if($result = mysqli_query($db, "UPDATE users SET balance = balance + '" . $balance . "' WHERE rfid_tag = '" . $rfid . "';")) {
    $balance = mysqli_query($db, "SELECT balance FROM users WHERE rfid_tag = '" . $rfid . "';");
    $bdata = mysqli_fetch_row($balance);

    if(mysqli_num_rows($balance) == 1)
      echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Balans geregistreerd. Nieuwe balans: ' . $bdata[0] . '</div>';
    else
      echo '<div class="notice error"><span class="glyphicon glyphicon-remove"></span> Onbekende RFID.</div>';
  } else {
    $error = true;
    echo '<div class="notice error"><span class="glyphicon glyphicon-remove"></span> Geen balansupdate uitgevoerd.</div>';
  }
}

?>

<form id="reloadForm" method="post">
  <div class="form-group">
    <label for="quickselect">Snelle selectie</label><br />
    <div class="btn-group" role="group" aria-label="..." name="quickselect" id="quickselect">
      <button type="button" class="btn btn-default btn-lg btn-success" onclick="changeBalance(1)">+1</button>
      <button type="button" class="btn btn-default btn-lg btn-success" onclick="changeBalance(5)">+5</button>
      <button type="button" class="btn btn-default btn-lg btn-success" onclick="changeBalance(10)">+10</button>
      <button type="button" class="btn btn-default btn-lg btn-success" onclick="changeBalance(20)">+20</button>
    </div>
    <div class="btn-group" role="group" aria-label="..." name="quickselect" id="quickselect">
      <button type="button" class="btn btn-default btn-lg btn-warning" onclick="changeBalance(-1)">-1</button>
      <button type="button" class="btn btn-default btn-lg btn-warning" onclick="changeBalance(-5)">-5</button>
      <button type="button" class="btn btn-default btn-lg btn-warning" onclick="changeBalance(-10)">-10</button>
      <button type="button" class="btn btn-default btn-lg btn-warning" onclick="changeBalance(-20)">-20</button>
    </div>
  </div>

  <div class="form-group">
      <label for="balance">Balans</label>
      <input type="number" class="form-control" name="balance" id="balance" value="0" />
  </div>
  <div class="form-group">
      <label for="rfid">RFID</label>
      <input type="text" class="form-control" name="rfid" id="rfid" />
  </div>
  <input type="submit" class="btn-block" value="Herlaad">
</form>