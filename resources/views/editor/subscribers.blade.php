@extends('editor.layout')

@section('title', 'Subscribers Management')

@section('header-title', 'Manage Subscribers')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/sub.css') }}">

<div class="header-section">
    <h2>Subscribers List</h2>
    <div class="search-add">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search subscribers...">
        </div>
        <button class="btn btn-primary" onclick="searchSubscribers()">Search</button>
        <button class="btn btn-success" onclick="openAddSubscriberModal()">Add Subscriber</button>
    </div>
</div>

<table id="subscribersTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
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
</table>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h3>Edit Subscriber</h3>
        <form id="editForm">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="modalName" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="modalEmail" name="email" required>
            </div>
            <button type="submit">Update Subscriber</button>
        </form>
    </div>
</div>

<div id="addSubscriberModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddSubscriberModal()">&times;</span>
        <h3>Add New Subscriber</h3>
        <form id="addSubscriberForm" method="POST" action="{{ route('editor.subscribers.add') }}">
            @csrf
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Add Subscriber</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/sub.js') }}"></script>
@endsection

