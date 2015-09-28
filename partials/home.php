<?php
    if(!defined("main"))
        die();

    function userHasPermission($has) {
      if($has != 1)
        echo "disabled";
    }
?>

<div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign"></span> Gelieve na gebruik ALTIJD uit te loggen!</div>

<div class="well" id="adminbox">
  <div class="row">
    <div class="col-md-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <h4 class="list-group-item-heading">Kassa</h4>
          <p class="list-group-item-text">Verkoop producten</p>
        </a>
        <a href="?page=cashier" class="list-group-item <?php userHasPermission($_SESSION['cashier']) ?>"><span class="glyphicon glyphicon-barcode"></span> Point of Sale</a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <h4 class="list-group-item-heading">Registratie</h4>
          <p class="list-group-item-text">Aanmaak, herlading</p>
        </a>
        <a href="?page=registration&act=register" class="list-group-item <?php userHasPermission($_SESSION['registration']) ?>"><span class="glyphicon glyphicon-pencil"></span> Registratie</a>
        <a href="?page=registration&act=recharge" class="list-group-item <?php userHasPermission($_SESSION['registration']) ?>"><span class="glyphicon glyphicon-euro"></span> Herladen</a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <h4 class="list-group-item-heading">Administratie</h4>
          <p class="list-group-item-text">Beheer</p>
        </a>
        <a href="?page=admin&act=createuser" class="list-group-item <?php userHasPermission($_SESSION['admin']) ?>"><span class="glyphicon glyphicon-plus"></span> Gebruiker aanmaken</a>
        <a href="?page=admin&act=moduser" class="list-group-item <?php userHasPermission($_SESSION['admin']) ?>"><span class="glyphicon glyphicon-edit"></span> Gebruiker bijwerken</a>
        <a href="?page=admin&act=logfile" class="list-group-item <?php userHasPermission($_SESSION['root']) ?>"><span class="glyphicon glyphicon-eye-open"></span> Controleer logbestand</a>
        <a href="?page=admin&act=deluser" class="list-group-item list-group-item-danger <?php userHasPermission($_SESSION['admin']) ?>"><span class="glyphicon glyphicon-exclamation-sign"></span> Gebruiker verwijderen</a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">
          <h4 class="list-group-item-heading">Gebruiker</h4>
          <p class="list-group-item-text">self()</p>
        </a>
        <a href="?page=logout" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> Uitloggen</a>
      </div>
    </div>
  </div>
</div>