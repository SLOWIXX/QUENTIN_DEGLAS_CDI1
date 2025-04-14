<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/register.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"
      rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>

  <body id="register-body">
    <script src="js/toggleLoginForm.js"></script>
    <div class="positionLogin">
      <div class="login">
        <div class="toggleForm">
          <button class="boutonRegister" id="showRegisterForm">
            S'inscrire
          </button>
          <button class="boutonLogin" id="showLoginForm">Se connecter</button>
        </div>
        <script src="toggleform.js"></script>
        <form id="registerForm">
          <div class="formInput">
            <label for="usernameRegister">Username</label>
            <input id="usernameRegister" class="input-register" type="text">
            <div id="usernameMessage"></div>
          </div>
          <div class="formInput">
            <label for="mailRegister">E-mail</label>
            <input id="mailRegister" class="input-register" type="text">
            <div id="emailMessage"></div>
          </div>
          <div class="formInput password-container">
            <label for="passwordRegister">Password</label>
            <input
              id="passwordRegister"
              class="input-register"
              type="password">
            <button
              type="button"
              id="togglePasswordRegister"
              onclick="togglePasswordVisibility('passwordRegister', 'togglePasswordRegister')"
            >
              <i class="fa fa-eye"></i>
            </button>

            <div id="passwordMessage"></div>
          </div>
          <button type="submit" id="submitRegisterForm">Register</button>
        </form>

        <!-- login form -->
        <form id="loginForm" style="display: none">
          <div class="formInput">
            <label for="mailLogin">E-mail</label>
            <input id="mailLogin" class="input-register" type="text">
            <div id="emailMessageLogin"></div>
          </div>
          <div class="formInput password-container">
            <label for="passwordLogin">Password</label>
            <input id="passwordLogin" class="input-register" type="password">
            <button
              type="button"
              id="togglePasswordLogin"
              onclick="togglePasswordVisibility('passwordLogin', 'togglePasswordLogin')"
            >
              <i class="fa fa-eye"></i>
            </button>
            <div id="passwordMessageLogin"></div>
          </div>
          <button type="submit" id="submitLoginForm">Login</button>
        </form>
      </div>
    </div>

    <script src="js/connexion.js"></script>
    <script src="js/obligationConnexion.js"></script>
    <script>
      checkLogin();
    </script>
  </body>
</html>
