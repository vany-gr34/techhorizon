@extends('manager.layout')

@section('title', 'Subscribers')

@section('header-title', 'Subscribers')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/subscribers.css') }}">

    <div class="subscribers-list">

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscription Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscribers as $subscriber)
                    @if ($subscriber->user_id) <!-- Vérifier si l'utilisateur existe -->
                        <tr>
                            <td>{{ $subscriber->user->name }}</td>
                            <td>{{ $subscriber->user->email }}</td>
                            <td>{{ $subscriber->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form action="{{ route('manager.subscribers.destroy', ['userId' => $subscriber->user->id, 'category' => $subscriber->category_id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection