@extends('editor.layout')

@section('title', 'Categories')

@section('content')
<h1>Categories and their Managers</h1>

<table>
    <thead>
        <tr>
            <th>Category Name</th>
            <th>Manager</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->manager ? $category->manager->name : 'No manager assigned' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
