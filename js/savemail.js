document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById("mailLogin");
  
    // Charger l'adresse e-mail depuis le localStorage au chargement de la page
    const savedEmail = localStorage.getItem("savedEmail");
    if (savedEmail) {
      emailInput.value = savedEmail;
    }
  
    // Sauvegarder l'adresse e-mail dans le localStorage à chaque saisie
    emailInput.addEventListener("input", () => {
      localStorage.setItem("savedEmail", emailInput.value);
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    // Gestion du formulaire de connexion
    const emailLoginInput = document.getElementById("mailLogin");
    const savedEmailLogin = localStorage.getItem("savedEmailLogin");
    if (savedEmailLogin) {
      emailLoginInput.value = savedEmailLogin;
    }
    emailLoginInput.addEventListener("input", () => {
      localStorage.setItem("savedEmailLogin", emailLoginInput.value);
    });
  
    // Gestion du formulaire d'inscription
    const emailRegisterInput = document.getElementById("mailRegister");
    const usernameRegisterInput = document.getElementById("usernameRegister");
  
    const savedEmailRegister = localStorage.getItem("savedEmailRegister");
    const savedUsernameRegister = localStorage.getItem("savedUsernameRegister");
  
    if (savedEmailRegister) {
      emailRegisterInput.value = savedEmailRegister;
    }
    if (savedUsernameRegister) {
      usernameRegisterInput.value = savedUsernameRegister;
    }
  
    emailRegisterInput.addEventListener("input", () => {
      localStorage.setItem("savedEmailRegister", emailRegisterInput.value);
    });
  
    usernameRegisterInput.addEventListener("input", () => {
      localStorage.setItem("savedUsernameRegister", usernameRegisterInput.value);
    });
  });