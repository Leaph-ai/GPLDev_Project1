<form id="login-form">
    <div class="login-container">
        <img src="assets/images/AR+FACADES.png" alt="Logo" class="logo">
        <input id="usernameField" name="username" type="text" class="input-field" placeholder="Nom d’utilisateur">
        <input id="passwordField" name="password" type="password" class="input-field" placeholder="Mot de passe">
        <button id="loginButton" name="button" class="login-button" >SE CONNECTER</button>
    </div>
</form>

<script src="./assets/javascript/login.js" type="module"></script>
<script type="module">
    import { login } from './assets/javascript/login.js';

    document.addEventListener('DOMContentLoaded', () => {
        const loginButton = document.getElementById('loginButton');
        loginButton.addEventListener('click', async (e) => {
            e.preventDefault();

            const formLogin = document.querySelector('#login-form');
            if (!formLogin.checkValidity()) {
                formLogin.reportValidity();
                return;
            }

            const loginResult = await login(formLogin.elements['username'].value, formLogin.elements['password'].value);

            if (loginResult.authentication === true) {
                window.location.href = 'index.php';
            } else if (loginResult.errors) {
                alert(loginResult.errors.join('\n'));
            }
        });
    });
</script>