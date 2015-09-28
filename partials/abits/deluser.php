<?php

if (!defined("bitmaster"))
    die();

function buildSelect($db)
{
    if ($users = $db->getDbObject()->query("SELECT * FROM users WHERE admin = 0 AND fullname != 'Unauthenticated';")) {
        echo '<select class="form-control" name="users" id="users">';
        foreach ($users as $user) {
            echo '<option value="' . $user['id'] . '">' . $user['fullname'] . '</option>';
        }
        echo '</select>';
    }
}

/*if (isset($_POST['users'])) {
    $id = mysqli_real_escape_string($db, $_POST['users']);

    if ($result = mysqli_query($db, "DELETE FROM users WHERE id = '" . $id . "';")) {
        echo '<div class="alert alert-success">De gebruiker is verwijderd</div>';
        $log->log("ERROR", "DELETED USER ID " . $id);
    } else
        echo '<div class=alert alert-danger">De gebruiker werd niet verwijderd..</div>';
}*/

if (isset($_POST['users'])) {
    $id = $_POST['users'];

    $delete = $db2->getDbObject()->prepare("DELETE FROM users WHERE id = ?;");
    if ($delete->execute(array($id))) {
        echo '<div class="alert alert-success">De gebruiker is verwijderd</div>';
        $log->log("ERROR", "DELETED USER ID " . $id);
    } else
        echo '<div class=alert alert-danger">De gebruiker werd niet verwijderd..</div>';
}
?>

<form method="post" name="delete">
    <div class="form-group">
        <label for="users">Gebruikers</label>
        <?php buildSelect($db2); ?>
    </div>

    <input type="submit" style="btn btn-submit btn-danger btn-lrg"/>
</form>