<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function show($id)
    {
        $image = Image::find($id);
        return response()->file("uploads/".$image->filename);
    }

    public function store(Request $request)
    {

    }
}
