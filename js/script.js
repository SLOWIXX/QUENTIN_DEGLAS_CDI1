document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.carte');

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
    });
  });