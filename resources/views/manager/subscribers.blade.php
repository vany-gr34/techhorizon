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
                    <tr>
                        <td>{{ $subscriber->name }}</td>
                        <td>{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->created_at?->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('subscribers.destroy', $subscriber->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection