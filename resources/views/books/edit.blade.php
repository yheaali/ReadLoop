<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Edit book</h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('books.update', $book) }}" method="post" enctype="multipart/form-data" class="card border-0 shadow-sm">
                @csrf
                @method('PUT')
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}" class="form-control @error('title') is-invalid @enderror" required maxlength="255">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" name="author" id="author" value="{{ old('author', $book->author) }}" class="form-control @error('author') is-invalid @enderror" required maxlength="255">
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" maxlength="10000">{{ old('description', $book->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Replace cover image</label>
                        <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept=".jpg,.jpeg,.png">
                        <div class="form-text">Leave empty to keep the current cover. JPEG or PNG, max 2 MB.</div>
                        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="pdf" class="form-label">Replace PDF</label>
                        <input type="file" name="pdf" id="pdf" class="form-control @error('pdf') is-invalid @enderror" accept=".pdf">
                        <div class="form-text">Leave empty to keep the current file. PDF only, max 2 MB.</div>
                        @error('pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <a href="{{ route('books.show', $book) }}" class="btn btn-link">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
