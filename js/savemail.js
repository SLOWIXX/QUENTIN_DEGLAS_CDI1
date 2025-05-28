document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById("mailLogin");
  
    const savedEmail = localStorage.getItem("savedEmail");
    if (savedEmail) {
      emailInput.value = savedEmail;
    }
  
    emailInput.addEventListener("input", () => {
      localStorage.setItem("savedEmail", emailInput.value);
    });
  });

  document.addEventListener("DOMContentLoaded", () => {
    const emailLoginInput = document.getElementById("mailLogin");
    const savedEmailLogin = localStorage.getItem("savedEmailLogin");
    if (savedEmailLogin) {
      emailLoginInput.value = savedEmailLogin;
    }
    emailLoginInput.addEventListener("input", () => {
      localStorage.setItem("savedEmailLogin", emailLoginInput.value);
    });
  
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