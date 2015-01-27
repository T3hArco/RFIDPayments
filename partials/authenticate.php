<?php
    if(!defined("main"))
        die();
?>

<div class="notice info">
    <span class="glyphicon glyphicon-flag" aria-hidden="true"></span> <strong>Afgesloten systeem!</strong> Deze website is enkel toegankelijk voor EhackB crew.
</div>

<form id="loginForm" class="well" method="post"><div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    
    <div class="form-group">
        <label>RFID Tag</label>
        <input type="text" class="form-control" name="rfid">
    </div>
    
    <input type="submit" class="btn-block" value="Authenticate">
</form>