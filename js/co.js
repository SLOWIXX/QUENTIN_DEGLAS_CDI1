document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById("registerForm");
    const loginForm = document.getElementById("loginForm");
  
    // Gestion du formulaire d'inscription
    registerForm.addEventListener("submit", async (event) => {
      event.preventDefault(); // Empêche le rafraîchissement de la page
  
      const formData = new FormData(registerForm);
      const response = await fetch("register.php", {
        method: "POST",
        body: formData,
      });
  
      const result = await response.json();
  
      // Réinitialiser les messages d'erreur
      document.getElementById("registerUsernameError").textContent = "";
      document.getElementById("registerEmailError").textContent = "";
      document.getElementById("registerPasswordError").textContent = "";
  
      if (result.success) {
        window.location.href = "index.php";
      } else {
        // Afficher les erreurs sous les champs correspondants
        if (result.errors.username) {
          document.getElementById("registerUsernameError").textContent = result.errors.username;
        }
        if (result.errors.email) {
          document.getElementById("registerEmailError").textContent = result.errors.email;
        }
        if (result.errors.password) {
          document.getElementById("registerPasswordError").textContent = result.errors.password;
        }
      }
    });
  
    // Gestion du formulaire de connexion
    loginForm.addEventListener("submit", async (event) => {
      event.preventDefault(); // Empêche le rafraîchissement de la page
  
      const formData = new FormData(loginForm);
      const response = await fetch("register.php", {
        method: "POST",
        body: formData,
      });
  
      const result = await response.json();
  
      // Réinitialiser les messages d'erreur
      document.getElementById("loginEmailError").textContent = "";
      document.getElementById("loginPasswordError").textContent = "";
  
      if (result.success) {
        window.location.href = "index.php";
      } else {
        // Afficher les erreurs sous les champs correspondants
        if (result.errors.email) {
          document.getElementById("loginEmailError").textContent = result.errors.email;
        }
        if (result.errors.password) {
          document.getElementById("loginPasswordError").textContent = result.errors.password;
        }
      }
    });
  });