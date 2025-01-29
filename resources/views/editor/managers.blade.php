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

<table id="managersTable">
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
                            @if ($category->manager->is_blocked)
                                <button class="btn btn-warning" onclick="toggleBlockManager('{{ $category->manager->id }}', 'unblock')">Unblock</button>
                            @else
                                <button class="btn btn-warning" onclick="toggleBlockManager('{{ $category->manager->id }}', 'block')">Block</button>
                            @endif
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
            <button type="button" onclick="addManager()">Add Manager</button>
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

    function addManager() {
    const name = document.getElementById('managerName').value;
    const email = document.getElementById('managerEmail').value;
    const password = document.getElementById('managerPassword').value;
    const categoryName = document.getElementById('categoryName').value;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    console.log({ name, email, password, categoryName }); // Debug

    fetch(`/managers/add`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({ name, email, password, categoryName })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Manager and category added successfully.');
            location.reload();
        } else {
            alert(data.message || 'An error occurred.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('A network error occurred.');
    });
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
function toggleBlockManager(managerId, action) {
    if (!managerId) {
        alert('No manager assigned to this category.');
        return;
    }

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
            alert(data.message || 'An error occurred.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    });
}


</script>
@endsection
