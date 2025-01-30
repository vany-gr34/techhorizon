@extends('editor.layout')

@section('title', 'Managers and Categories Management')

@section('header-title', 'Manage Managers and Categories')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/man.css') }}">

<div class="header-section">
    <h2>Managers & Categories</h2>
</div>

<div class="search-add-container">
    <input type="text" id="searchInput" placeholder="Search for a manager or category">
    <input type="button" value="search" onclick="searchManagers()">
    <input type="button" value="Add Manager" onclick="openAddManagerModal()">
</div>

<table id="ManagersTable">
    <thead>
        <tr>
            <th>Manager Name</th>
            <th>Manager Email</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr id="category-{{ $category->id }}">
                <td>{{ $category->manager->name ?? 'No Manager Assigned' }}</td>
                <td>{{ $category->manager->email ?? 'No Manager Assigned' }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <div class="action-buttons">
                        @if ($category->manager)
                           
                        <button class="btn btn-warning" 
    onclick="toggleBlockManager('{{ $category->manager->id }}', '{{ $category->manager->is_blocked ? 'unblock' : 'block' }}')">
    {{ $category->manager->is_blocked ? 'Unblock' : 'Block' }}
</button>
                        @endif
                        <button class="btn btn-danger" onclick="deleteCategory('{{ $category->id }}')">Delete Category</button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div id="addManagerModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddManagerModal()">&times;</span>
        <h3>Add New Manager</h3>
        <form id="addManagerForm">
            <div class="form-group">
                <label for="managerName">Name:</label>
                <input type="text" name="name" id="managerName" required>
            </div>
            <div class="form-group">
                <label for="managerEmail">Email:</label>
                <input type="email" name="email" id="managerEmail" required>
            </div>
            <div class="form-group">
                <label for="managerPassword">Password:</label>
                <input type="password" name="password" id="managerPassword" required>
            </div>
            <div class="form-group">
                <label for="categoryName">Category Name:</label>
                <input type="text" id="categoryName" required>
            </div>
            <button type="submit" >Add Manager</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/man.js') }}"></script>



<script>
  


function deleteCategory(categoryId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette catégorie, son manager et ses posts ?')) {
        return;
    }

    fetch(`/categories/${categoryId}/delete`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur lors de la suppression45.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Retirer la catégorie supprimée de la table
            document.getElementById(`category-${categoryId}`).remove();
            alert('La catégorie, son manager et ses posts ont été supprimés.');
        } else {
            alert('Une erreur est survenue lors de la suppression78.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de la suppression99.');
    });
}

    function openAddManagerModal() {
        document.getElementById('addManagerModal').style.display = 'block';
    }

    function closeAddManagerModal() {
        document.getElementById('addManagerModal').style.display = 'none';
    }




   
    function searchManagers() {
    const query = document.getElementById('searchInput').value;

    fetch(`/categories/search-manager?q=${encodeURIComponent(query)}`, {
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
        document.getElementById('managersTable').innerHTML = html;
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const addSubscriberForm = document.getElementById('addManagerForm');
    const ManagersTable = document.getElementById('ManagersTable').getElementsByTagName('tbody')[0];

    addSubscriberForm.addEventListener('submit', function (e) {
        e.preventDefault(); 

        const formData = new FormData(addSubscriberForm);
        console.log("Sending data:", Object.fromEntries(formData)); 

        fetch(`/managers/add`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            console.log("Server response:", data);

            if (data.success) {
                const newRow = ManagersTable.insertRow();
                const nameCell = newRow.insertCell(0);
                const emailCell = newRow.insertCell(1);
                const catcell=newRow.insertCell(2)
                const actionsCell = newRow.insertCell(3);
                const blockCell = newRow.insertCell(4);

                nameCell.textContent = data.manager.name;
                emailCell.textContent = data.manager.email;
                catcell.textContent=data.manager.category;
                actionsCell.innerHTML = `<a href="#" onclick="deleteManager(${data.manager.id}); return false;">Supprimer</a>`;
                blockCell.innerHTML = `<a href="#" onclick="toggleBlockManager(${data.manager.id}, 'block'); return false;">Block</a>`;

                addSubscriberForm.reset();
                closeAddManagerModal();
                alert('Manager added successfully!');
                location.reload(); 
            } else {
                alert(data.message || 'An error occurred. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
});


function toggleBlockManager(managerId, action) {
   
    
    const confirmationMessage = action === 'block' 
        ? 'Are you sure you want to block this manager?' 
        : 'Are you sure you want to unblock this manager?';

    if (!confirm(confirmationMessage)) {
        return;
    }

    const url = `/admin/managers/${managerId}/${action}`;

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
            alert(`Manager ${action}ed successfully.`);
            const row = document.getElementById(`category-${managerId}`);
            if (row) {
                const link = row.querySelector('td:nth-child(4) a');
                if (link) {
                    if (action === 'block') {
                        link.innerHTML = 'Unblock';
                        link.setAttribute('onclick', `toggleBlockManager(${managerId}, 'unblock'); return false;`);
                    } else if (action === 'unblock') {
                        link.innerHTML = 'Block';
                        link.setAttribute('onclick', `toggleBlockManager(${managerId}, 'block'); return false;`);
                    }
                }
            }
        } else {
            alert(data.message || 'An error occurred89.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    });
}


</script>
@endsection
