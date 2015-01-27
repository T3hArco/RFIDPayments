<?php

if(!defined("bitmaster"))
  die();

function buildSelect($db) {
  if($result = mysqli_query($db, "SELECT * FROM users WHERE admin = 0;")) {
    echo '<select class="form-control" name="users" id="users">';
    while($row = mysqli_fetch_assoc($result)) {
      echo '<option value="' . $row['id'] . '">' . $row['fullname'] . '</option>';
    }
    echo '</select>';
  }
}

if(isset($_POST['users'])) { 
  $id = mysqli_real_escape_string($db, $_POST['users']);

  if($result = mysqli_query($db, "DELETE FROM users WHERE id = '" . $id . "';"))
    echo '<div class="alert alert-success">De gebruiker is verwijderd</div>';
  else
    echo '<div class=alert alert-danger">De gebruiker werd niet verwijderd..</div>';
}
?>

<form method="post" name="delete">
  <div class="form-group">
    <label for="users">Gebruikers</label>
    <?php buildSelect($db); ?>
  </div>

  <input type="submit" style="btn btn-submit btn-danger btn-lrg" />
</form>