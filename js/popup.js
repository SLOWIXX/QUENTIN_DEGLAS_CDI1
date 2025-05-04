document.addEventListener('DOMContentLoaded', function () {
    console.log('Script chargé');
// Ouvrir la modale
document.getElementById('scroll-button').addEventListener('click', function () {
    console.log('Button clicked!');
    document.getElementById('random-form-modal').style.display = 'block';
  });
  
  // Fermer la modale
  document.getElementById('close-modal').addEventListener('click', function () {
    document.getElementById('random-form-modal').style.display = 'none';
  });
  
  // Fermer la modale en cliquant en dehors du contenu
  window.addEventListener('click', function (event) {
    const modal = document.getElementById('random-form-modal');
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });


});