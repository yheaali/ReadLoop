<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">إضافة كتاب</h1>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data" class="card border-0 shadow-sm">
                @csrf
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الكتاب</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" required maxlength="255">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="author" class="form-label">اسم المؤلف</label>
                        <input type="text" name="author" id="author" value="{{ old('author') }}" class="form-control @error('author') is-invalid @enderror" required maxlength="255">
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف (اختياري)</label>
                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" maxlength="10000">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">صورة الغلاف</label>
                        <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" accept=".jpg,.jpeg,.png" required>
                        <div class="form-text">JPEG أو PNG، بحد أقصى 2 ميجابايت.</div>
                        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="pdf" class="form-label">ملف PDF</label>
                        <input type="file" name="pdf" id="pdf" class="form-control @error('pdf') is-invalid @enderror" accept=".pdf" required>
                        <div class="form-text">PDF فقط، بحد أقصى 2 ميجابايت.</div>
                        @error('pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">نشر الكتاب</button>
                    <a href="{{ route('books.index') }}" class="btn btn-link">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
