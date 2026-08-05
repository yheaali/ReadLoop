<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Dashboard</h1>
    </x-slot>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <p class="mb-2">You are logged in.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">Browse books</a>
        </div>
    </div>
</x-app-layout>
