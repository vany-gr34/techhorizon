@foreach ($categories as $category)
<tr id="category-{{ $category->id }}">
    <td>{{ $category->manager->name ?? 'No Manager Assigned' }}</td>
    <td>{{ $category->manager->email ?? 'No Manager Assigned' }}</td>
    <td>{{ $category->name }}</td>
    <td>
        <a href="#" onclick="openAssignManagerModal('{{ $category->id }}', '{{ $category->name }}'); return false;">Assign/Change Manager</a>
    </td>
    <td>
        <a href="#" onclick="deleteCategory('{{ $category->id }}'); return false;">Delete Category</a>
    </td>
</tr>
@endforeach
