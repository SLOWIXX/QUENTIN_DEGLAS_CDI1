document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.carte');
    const houses = document.querySelectorAll('.maison-container');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.toLowerCase();

        cards.forEach(card => {
            const cardName = card.getAttribute('data-name');
            const cardActor = card.getAttribute('data-actor');

            if (cardName.includes(query) || cardActor.includes(query)) {
                card.style.display = ''; 
            } else {
                card.style.display = 'none'; 
            }
        });

        houses.forEach(house => {
            const visibleCards = house.querySelectorAll('.carte:not([style*="display: none"])');
            if (visibleCards.length === 0) {
                house.style.display = 'none'; 
            } else {
                house.style.display = '';
            }
        });
    });
});