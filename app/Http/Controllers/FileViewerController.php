<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileViewerController extends Controller
{
    public function show(Request $request)
    {
        $path = $request->query('path');
          if (!$path || str_contains($path, '..')) {
            abort(403);
        }          // e.g. attachments/xyz.pdf
        abort_unless($path && Storage::disk('public')->exists($path), 404);



        $url  = asset('storage/' . $path);
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $type = in_array($ext, ['jpg','jpeg','png','gif','webp','svg']) ? 'image'
              : ($ext === 'pdf' ? 'pdf' : 'other');

        return view('property.file-viewer', compact('url','path','type','ext'));
    }
}
