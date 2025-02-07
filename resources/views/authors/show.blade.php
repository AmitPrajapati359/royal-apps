@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Authors Detail - {{ $author['first_name'] ?? '' }} - Books ({{ count($author['books']) }}) </h3>

    <a href="{{ route('authors.index') }}">Back to Authors</a>
    @if(count($author['books']) <= 0)
        <a href="javascript:void(0);" data-url="{{  route('authors.destroy', [  'id' => $author['id'] ]) }}"  class="btn btn-danger btnDelete" data-title="Author"  title="Delete">Delete Author</a>

    @endif
    <h2>Books</h2>

        <table  class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Release Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($author['books'] as $book)
                <tr>
                    <td>{{ $book['title'] }}</td>
                    <td>{{ isset($book['release_date']) ?  \Carbon\Carbon::parse($book['release_date'])->format('d M Y') : 'N/A' }}</td>
                    <td>

                     <a href="javascript:void(0);" data-url="{{  route('books.destroy', [  'id' => $book['id'] ]) }}"  class="btn btn-danger btnDelete" data-title="Book"  title="Delete">Delete Book</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection
