<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Menampilkan halaman detail untuk sebuah post.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        // Fitur ini disebut "Route Model Binding".
        // Laravel secara otomatis akan mencari post di database
        // yang cocok dengan 'slug' dari URL.

        // Kemudian, data post yang ditemukan ($post) dikirimkan
        // ke view 'posts.show' untuk ditampilkan.
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
