document.addEventListener('DOMContentLoaded', () => {
    const favorisButtons = document.querySelectorAll('.favoris-button');

    favorisButtons.forEach(button => {
        button.addEventListener('click', () => {
            const characterName = button.getAttribute('data-name');

            fetch('favoris.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `character_name=${encodeURIComponent(characterName)}`,
            })
                .then(response => response.json())
                .then(data => {
                    showNotification(data.message, data.success ? 'success' : 'error');
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Une erreur est survenue.', 'error');
                });
        });
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('fade-out');
            notification.addEventListener('transitionend', () => notification.remove());
        }, 500);
    }
});