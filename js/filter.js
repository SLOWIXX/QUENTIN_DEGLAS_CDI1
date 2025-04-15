document.addEventListener('DOMContentLoaded', function() {
  const houseTitles = document.querySelectorAll('.house-title h2');
  const houseContainers = document.querySelectorAll('.maison-container');
  const resetContainer = document.querySelector('.reset-container');
  const resetButton = document.getElementById('resetButton');
  let currentVisible = null;

  houseTitles.forEach(title => {
    title.addEventListener('click', () => {
      const clickedHouseId = title.parentElement.parentElement.id;

      if (currentVisible === clickedHouseId) {
        // Si on reclique sur la même maison, on réaffiche tout
        houseContainers.forEach(container => container.style.display = 'block');
        currentVisible = null;
        resetContainer.style.display = 'none'; // On masque le bouton
      } else {
        // Sinon, on affiche uniquement la maison cliquée
        houseContainers.forEach(container => {
          container.style.display = (container.id === clickedHouseId) ? 'block' : 'none';
        });
        currentVisible = clickedHouseId;
        resetContainer.style.display = 'block'; // On affiche le bouton
      }
    });
  });

  // Fonction du bouton reset
  resetButton.addEventListener('click', () => {
    houseContainers.forEach(container => container.style.display = 'block');
    currentVisible = null;
    resetContainer.style.display = 'none'; // On cache le bouton après reset
  });
});
