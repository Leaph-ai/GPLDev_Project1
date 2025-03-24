
<form method="post" id="userForm">
    <h3><?php echo $_GET['action'] === 'edit' ? 'Modifier l\'utilisateur '.$_GET['id'] : 'Créer un utilisateur'; ?></h3>
    <input id="usernameField" name="username" type="text" class="input-field" placeholder="Nom d'utilisateur" value="<?php echo(isset($user) && isset($user['username']) ? $user['username'] : ""); ?>">
    <input id="passwordField" name="password" type="password" class="input-field" placeholder="Mot de passe" value="">
    <div>
        <label for="adminCheckBox">Admin</label>
        <input id="adminCheckBox" name="adminCheckBox" type="checkbox" <?php echo(isset($user) && $user['admin'] === 1 ? "checked" : ""); ?>>
    </div>
    <br>
    <button name="button" class="button" type="submit" ><?php echo(isset($user) && $_GET['action'] === 'edit' ? 'Modifier l\'utilisateur' : "Créer un utilisateur"); ?> </button>
</form>