<form method="post">
    <label for="usernameField"></label>
    <input id="usernameField" name="username" type="text" class="input-field" placeholder="Nom d'utilisateur">
    <label for="passwordField"></label>
    <input id="passwordField" name="password" type="password" class="input-field" placeholder="Mot de passe">
    <label for="adminCheckBox">Admin</label>
    <input id="adminCheckBox" name="adminCheckBox" type="checkbox">
    <button id="loginButton" name="button" class="login-button" type="submit" ><?php echo(isset($_GET['action']) && $_GET['action'] === 'create' ? 'Créer un utilisateur' : "Modifier utilisateur"); ?> </button>
</form>