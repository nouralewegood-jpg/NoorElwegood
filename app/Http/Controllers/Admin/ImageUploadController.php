<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
     * Subir una imagen para el editor de contenido
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time() . '.' . $request->image->extension();

        // Almacenar la imagen en la carpeta de imágenes del contenido
        $request->image->storeAs('public/content-images', $imageName);

        return response()->json([
            'success' => true,
            'url' => asset('storage/content-images/' . $imageName)
        ]);
    }
}
