<?php

if(!defined("bitmaster"))
  die();

if(isset($_POST['username'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, md5(sha1($_POST['password'])));
  $rfid = mysqli_real_escape_string($db, $_POST['rfid']);
  $fname = mysqli_real_escape_string($db, $_POST['fname']);
  $cashier = 0;
  $admin = 0;
  $registration = 0;

  if(isset($_POST['admin'])) {
    $admin = 1;
    $cashier = 1;
    $registration = 1;
  }

  if(isset($_POST['cashier']))
    $cashier = 1;

  if(isset($_POST['registration']))
    $registration = 1;


  if(!$result = mysqli_query($db, "INSERT INTO users (rfid_tag, admin, cashier, registration, balance, fullname, username, password) VALUES ('" . $rfid . "', '" . $admin . "', '" . $cashier . "', '" . $registration . "', '0', '" . $fname . "', '" . $username . "', '" . $password . "');")) {
    echo '<div class="alert alert-danger">User not added, radio Arnaud.. (or duplicate??)</div>';
  } else {
    echo '<div class="alert alert-success">Gebruiker toegevoegd..</div>';
  }
}

?>

<form id="addUserForm" method="post">
  <div class="form-group">
    <label for="username">Gebruikersnaam</label>
    <input type="text" class="form-control" name="username" id="username" />
  </div>

  <div class="form-group">
    <label for="fname">Volledige naam</label>
    <input type="text" class="form-control" name="fname" id="fname" />
  </div>

  <div class="form-group">
    <label for="password">Wachtwoord</label>
    <input type="password" class="form-control" name="password" id="password" />
  </div>

  <div class="form-group">
    <label>Gebruikersrechten</label>
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
    <input type="text" class="form-control" name="rfid" id="rfid" />
  </div>

  <input type="submit" class="btn-block" value="Maak aan">
</form>