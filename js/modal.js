document.getElementById('exchange-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('user-email').value;
    const messageDiv = document.getElementById('exchange-message');
    messageDiv.textContent = "Vérification...";
    fetch('verif_email.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'email=' + encodeURIComponent(email)
    })
    .then(response => response.json())
    .then(data => {
        if(data.exists) {
            messageDiv.style.color = "green";
            messageDiv.textContent = "Demande envoyée";
        } else {
            messageDiv.style.color = "red";
            messageDiv.textContent = "L'email est incorrect.";
        }
    })
    .catch(() => {
        messageDiv.style.color = "red";
        messageDiv.textContent = "Erreur lors de la vérification.";
    });
});
