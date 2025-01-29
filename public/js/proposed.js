document.addEventListener('DOMContentLoaded', function () {
    const articleBoxes = document.querySelectorAll('.article-box');

    articleBoxes.forEach(box => {
        const imageUrl = box.getAttribute('data-image');
        box.style.backgroundImage = `url('${imageUrl}')`;
        box.style.backgroundSize = 'cover';
        box.style.backgroundPosition = 'center';

        // Rendre la carte cliquable
        const articleLink = box.querySelector('.article-content');
        const articleUrl = box.getAttribute('data-url');
        articleLink.addEventListener('click', () => {
            window.location.href = articleUrl;
        });
    });
});
// Recharger la page après une action
