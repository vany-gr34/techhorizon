function openModal(id, name, email) {
    const modal = document.getElementById('editModal');
    modal.style.display = 'flex';

    // Pré-remplir les champs avec les données
    document.getElementById('modalName').value = name;
    document.getElementById('modalEmail').value = email;

    // Mettre à jour l'action dynamique
    document.getElementById('editForm').dataset.id = id; // Stocker l'ID dans un attribut data
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Fermer la modale en cliquant en dehors
window.onclick = function (event) {
    const modal = document.getElementById('editModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Empêche le rechargement de la page

    const id = this.dataset.id; // Récupère l'ID stocké dans l'attribut data
    const name = document.getElementById('modalName').value;
    const email = document.getElementById('modalEmail').value;

    // Envoi des données via fetch
    fetch(`/editor/subscribers/${id}/edit`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          
        },
        

        body: JSON.stringify({ name, email })
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Une erreur est survenue.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Abonné modifié avec succès.');
                closeModal();

                // Optionnel : Mise à jour dynamique de la table
                document.querySelector(`#user-name-${id}`).innerText = name;
                document.querySelector(`#user-email-${id}`).innerText = email;
            } else {
                alert(data.message || 'Une erreur est survenue.');
            }
        })
        .catch(error => console.error('Erreur:', error));
});
function toggleBlockSubscriber(id, action) {
    // Demander une confirmation à l'utilisateur
    const confirmationMessage = action === 'block' ? 'Are you sure you want to block this subscriber?' : 'Are you sure you want to unblock this subscriber?';
    if (!confirm(confirmationMessage)) {
        return;
    }

    // Déterminer l'URL en fonction de l'action
    const url = `/editor/subscribers/${id}/${action}`;
    
    // Faire la requête fetch
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('An error occurred.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Afficher le message de succès
            alert(`Subscriber ${action}ed successfully.`);
            
            // Récupérer la ligne correspondant à l'abonné
            const row = document.getElementById(`subscriber-${id}`);
            if (row) {
                // Mettre à jour l'interface utilisateur en fonction de l'action
                const link = row.querySelector('td:nth-child(4) a');
                if (link) {
                    if (action === 'block') {
                        link.innerHTML = 'Unblock';
                        link.setAttribute('onclick', `toggleBlockSubscriber(${id}, 'unblock'); return false;`);
                        row.style.opacity = 0.5; // Optionnel, modifier visuellement l'état de l'abonné
                    } else if (action === 'unblock') {
                        link.innerHTML = 'Block';
                        link.setAttribute('onclick', `toggleBlockSubscriber(${id}, 'block'); return false;`);
                        row.style.opacity = 1; // Restaurer l'opacité à 1
                    }
                } else {
                    console.error(`No link found in row for subscriber-${id}`);
                }
            } else {
                console.error(`No row found for subscriber-${id}`);
            }
        } else {
            alert(data.message || 'An error occurred.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Details: ' + error.message);
    });
}
function searchSubscribers() {
    const query = document.getElementById('searchInput').value;

    fetch(`/editor/subscribers/search?q=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la recherche.');
        }
        return response.text();
    })
    .then(html => {
        // Remplacer le contenu de la table par les résultats filtrés
        document.getElementById('subscribersTable').innerHTML = html;
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
function openAddSubscriberModal() {
    document.getElementById('addSubscriberModal').style.display = 'block';
}

function closeAddSubscriberModal() {
    document.getElementById('addSubscriberModal').style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function () {
    const addSubscriberForm = document.getElementById('addSubscriberForm');
    const subscribersTable = document.getElementById('subscribersTable').getElementsByTagName('tbody')[0];

    // Gérer la soumission du formulaire d'ajout
    addSubscriberForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Empêche le rechargement de la page

        const formData = new FormData(addSubscriberForm);

        fetch(addSubscriberForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Ajouter le nouvel abonné dans la table
                    const newRow = subscribersTable.insertRow();

                    // Ajouter les cellules de la nouvelle ligne
                    const nameCell = newRow.insertCell(0);
                    const emailCell = newRow.insertCell(1);
                    const actionsCell = newRow.insertCell(2);
                    const blockCell = newRow.insertCell(3);
                    const modifyCell = newRow.insertCell(4);

                    // Remplir les cellules avec les données du nouvel abonné
                    nameCell.textContent = data.subscriber.name;
                    emailCell.textContent = data.subscriber.email;

                    // Actions (supprimer)
                    actionsCell.innerHTML = `<a href="#" onclick="deleteSubscriber(${data.subscriber.id}); return false;">Supprimer</a>`;

                    // Bloquer/Débloquer
                    blockCell.innerHTML = `<a href="#" onclick="toggleBlockSubscriber(${data.subscriber.id}, 'block'); return false;">Block</a>`;

                    // Modifier
                    modifyCell.innerHTML = `<a href="#" onclick="openModal('${data.subscriber.id}', '${data.subscriber.name}', '${data.subscriber.email}'); return false;">Modifier</a>`;

                    // Réinitialiser le formulaire et fermer la modale
                    addSubscriberForm.reset();
                    closeAddSubscriberModal();

                    alert('Subscriber added successfully!');
                    location.reload(); 
                } else {
                    alert(data.message || 'An error occurred45. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.88 Please try again.');
            });
    });
});
function deleteSubscriber(subscriberId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/editor/subscribers/delete/${subscriberId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                // Supprimer la ligne correspondante dans le tableau
                const row = document.getElementById(`subscriber-${subscriberId}`);
                if (row) {
                    row.remove();
                }
                alert('Abonné supprimé avec succès.');
                location.reload(); 
            } else {
                alert(data.message || 'Une erreur est survenue lors de la suppression.');
            }
        })
        .catch((error) => {
            console.error('Erreur lors de la suppression :', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
}
