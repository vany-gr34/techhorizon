
<link rel="stylesheet" href="{{ asset('css/sub.css') }}">
<tbody>
@forelse ($subscribers as $subscriber)
            <tr id="subscriber-{{ $subscriber->id }}">
                <td>{{ $subscriber->name }}</td>
                <td>{{ $subscriber->email }}</td>
                <td>
                    <span class="status-indicator {{ $subscriber->is_blocked ? 'status-blocked' : 'status-active' }}"></span>
                    {{ $subscriber->is_blocked ? 'Blocked' : 'Active' }}
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary" onclick="openModal('{{ $subscriber->id }}','{{ $subscriber->name }}', '{{ $subscriber->email }}')">Edit</button>
                        <button class="btn btn-warning" onclick="toggleBlockSubscriber('{{ $subscriber->id }}', '{{ $subscriber->is_blocked ? 'unblock': 'block'}}')">
                            {{ $subscriber->is_blocked ? 'Unblock' : 'Block' }}
                        </button>
                        <button class="btn btn-danger" onclick="deleteSubscriber('{{ $subscriber->id }}')">Delete</button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No subscribers found.</td>
            </tr>
        @endforelse
</tbody>