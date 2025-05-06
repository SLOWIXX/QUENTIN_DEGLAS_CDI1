document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.carte');
    const houses = document.querySelectorAll('.maison-container');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();

        cards.forEach(card => {
            const cardName = card.getAttribute('data-name');
            if (cardName.includes(query)) {
                card.style.display = ''; 
            } else {
                card.style.display = 'none'; 
            }
        });

        // Vérifier chaque maison pour voir si elle contient des cartes visibles
        houses.forEach(house => {
            const visibleCards = house.querySelectorAll('.carte:not([style*="display: none"])');
            if (visibleCards.length === 0) {
                house.style.display = 'none'; // Masquer la maison si aucune carte n'est visible
            } else {
                house.style.display = ''; // Afficher la maison si elle contient des cartes visibles
            }
        });
    });
});