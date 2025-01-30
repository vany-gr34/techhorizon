<link rel="stylesheet" href="{{ asset('css/man.css') }}">
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
