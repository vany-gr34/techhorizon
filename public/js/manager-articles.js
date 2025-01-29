document.addEventListener('DOMContentLoaded', function() {
    // Sélectionnez tous les formulaires d'action
    const actionForms = document.querySelectorAll('.actions form');

    actionForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche la soumission normale du formulaire

            const formData = new FormData(form);
            const action = formData.get('action');
            const articleId = form.getAttribute('action').split('/').pop(); // Extrait l'ID de l'article de l'URL

            // Envoyer une requête AJAX
            fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': formData.get('_token'), // Inclure le token CSRF
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: action,
                    _token: formData.get('_token')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour l'interface utilisateur ou afficher un message de succès
                    alert('Action réussie: ' + action);
                    // Vous pouvez également recharger la page ou mettre à jour le statut de l'article dynamiquement
                    window.location.reload();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur s\'est produite lors de la mise à jour du statut de l\'article.');
            });
        });
    });
});