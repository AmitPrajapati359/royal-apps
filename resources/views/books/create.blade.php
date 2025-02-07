@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Book</h2>

    <form method="POST" action="{{ route('books.store') }}">
        @csrf

        <div class="form-group">
            <label>Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Author:</label>
            <select name="author_id" class="form-control" required>
                <option value="">Select an Author</option>
                @foreach($authors as $author)
                    <option value="{{ $author['id'] }}">{{ $author['first_name'] }} {{ $author['last_name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Release Date:</label>
            <input type="date" name="release_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label>ISBN:</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Format:</label>
            <select name="format" class="form-control" required>
                <option value="">Select Format</option>
                <option value="Hardcover">Hardcover</option>
                <option value="Paperback">Paperback</option>
                <option value="Ebook">Ebook</option>
                <option value="Audiobook">Audiobook</option>
            </select>
        </div>

        <div class="form-group">
            <label>Number of Pages:</label>
            <input type="number" name="number_of_pages" class="form-control" required>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Add Book</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
