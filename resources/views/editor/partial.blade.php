
<link rel="stylesheet" href="{{ asset('css/sub.css') }}">
<tbody>
    @forelse ($subscribers as $subscriber)
        <tr id="subscriber-{{ $subscriber->id }}">
            <td>{{ $subscriber->name }}</td>
            <td>{{ $subscriber->email }}</td>
            <td>
                <a href="{{ route('editor.subscribers.delete', $subscriber->id) }}" 
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')">Supprimer</a>
            </td>
            <td>
                @if ($subscriber->is_blocked)
                    <a href="#" onclick="toggleBlockSubscriber('{{ $subscriber->id }}', 'unblock'); return false;">Unblock</a>
                @else
                    <a href="#" onclick="toggleBlockSubscriber('{{ $subscriber->id }}', 'block'); return false;">Block</a>
                @endif
            </td>
            <td>
                <a href="#" onclick="openModal('{{ $subscriber->id }}','{{ $subscriber->name }}', '{{ $subscriber->email }}')">Modifier</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">No subscribers found.</td>
        </tr>
    @endforelse
</tbody>