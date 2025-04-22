document.addEventListener("DOMContentLoaded", () => {
  const registerForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");
  const showRegisterFormButton = document.getElementById("showRegisterForm");
  const showLoginFormButton = document.getElementById("showLoginForm");

  // Par défaut, afficher le formulaire de connexion
  loginForm.style.display = "block";
  registerForm.style.display = "none";
  showLoginFormButton.style.backgroundColor = "#1b5780";
  showRegisterFormButton.style.backgroundColor = "white";

  // Gestion du clic sur "S'inscrire"
  showRegisterFormButton.addEventListener("click", () => {
    registerForm.style.display = "block";
    loginForm.style.display = "none";
    showRegisterFormButton.style.backgroundColor = "#1b5780";
    showLoginFormButton.style.backgroundColor = "white";
  });

  // Gestion du clic sur "Se connecter"
  showLoginFormButton.addEventListener("click", () => {
    loginForm.style.display = "block";
    registerForm.style.display = "none";
    showLoginFormButton.style.backgroundColor = "#1b5780";
    showRegisterFormButton.style.backgroundColor = "white";
  });
});