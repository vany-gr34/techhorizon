document.addEventListener('DOMContentLoaded', function () {
    const articleBoxes = document.querySelectorAll('.article-box');

    articleBoxes.forEach(box => {
        // Définir l'image de fond
        const imagePath = box.getAttribute('data-image');
        box.style.setProperty('--bg-image', `url('${imagePath}')`);

        // Ajouter un écouteur d'événement pour le clic
        box.addEventListener('click', function () {
            const articleUrl = box.getAttribute('data-url');
            window.location.href = articleUrl; // Rediriger vers l'URL de l'article
        });
    });
});