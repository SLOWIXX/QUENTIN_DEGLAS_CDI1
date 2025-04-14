document.addEventListener("DOMContentLoaded", function () {
    const boutonRegister = document.getElementById("showRegisterForm");
    const boutonLogin = document.getElementById("showLoginForm");
  
    // Initialisation : définir le bouton actif au chargement
    boutonRegister.classList.add("active"); // Par défaut, "S'inscrire" est actif
    boutonLogin.classList.remove("active");
  
    // Appliquer les styles initiaux
    updateButtonStyles();
  
    // Ajouter les événements de clic
    boutonRegister.addEventListener("click", function () {
      boutonRegister.classList.add("active");
      boutonLogin.classList.remove("active");
      updateButtonStyles();
    });
  
    boutonLogin.addEventListener("click", function () {
      boutonLogin.classList.add("active");
      boutonRegister.classList.remove("active");
      updateButtonStyles();
    });
  
    // Fonction pour mettre à jour les styles des boutons
    function updateButtonStyles() {
      if (boutonRegister.classList.contains("active")) {
        boutonRegister.style.backgroundColor = "blue";
        boutonRegister.style.color = "white";
        boutonLogin.style.backgroundColor = "white";
        boutonLogin.style.color = "black";
      } else {
        boutonLogin.style.backgroundColor = "blue";
        boutonLogin.style.color = "white";
        boutonRegister.style.backgroundColor = "white";
        boutonRegister.style.color = "black";
      }
    }
  });