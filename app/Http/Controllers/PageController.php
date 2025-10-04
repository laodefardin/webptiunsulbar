<?php

namespace App\Http\Controllers;

use Filament\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PageController extends Controller
{
        // Kita tambahkan \App\Models\ di depan Page untuk menghilangkan ambiguitas
    public function show(\App\Models\Page $page)
    {
        return view('pages.show', compact('page'));
    }
}
