@extends('manager.layout')
@section('header-title', 'Most Rated Articles')
@section('content')
<link href="{{ asset('css/toprated.css') }}" rel="stylesheet">
<div class="container">
    
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Note</th>
                <th>View Articles</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mostRatedArticles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>{{ number_format($article->average_rating, 2) }}</td> {{-- Affiche la moyenne des notes avec 2 décimales --}}
                    <td>
                        <a href="{{ route('manager.article.show', $article->id) }}" class="btn btn-primary btn-sm">Read it!</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection