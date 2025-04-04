document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const closeBtn = document.getElementById('close-btn');
    const content = document.querySelector('.content');

    hamburger.addEventListener('click', function() {
        sidebar.classList.add('active');
        content.classList.add('shifted');
        hamburger.style.display = 'none';
        closeBtn.style.display = 'block';
    });

    closeBtn.addEventListener('click', function() {
        sidebar.classList.remove('active');
        content.classList.remove('shifted');
        hamburger.style.display = 'block';
        closeBtn.style.display = 'none';
    });
});