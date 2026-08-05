<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function show(string $path): BinaryFileResponse
    {
        abort_unless(
            str_starts_with($path, 'covers/')
            || str_starts_with($path, 'books/'),
            404
        );

        $filePath = storage_path('app/public/'.$path);
        abort_unless(is_file($filePath), 404);

        return response()->file($filePath);
    }
}
