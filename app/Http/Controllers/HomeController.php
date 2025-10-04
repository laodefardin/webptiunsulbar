<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\Page;
use App\Models\Faq; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\HeroSlider;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::where('published_at', '<=', now())
                           ->latest('published_at')
                           ->take(3)
                           ->get();

        $upcomingEvents = \App\Models\Event::latest()
                               ->take(3)
                               ->get();

        $featuredPages = \App\Models\Page::where('is_featured', true)
                                ->take(3)
                                ->get();

        // Mengambil semua FAQ yang sudah diurutkan
        $faqs = Faq::orderBy('order', 'asc')->get();

         // Mengambil data slider dari HeroSlider
        $sliders = HeroSlider::orderBy('order', 'asc')->get();

        return view('home', [
            'posts' => $latestPosts,
            'events' => $upcomingEvents,
            'featuredPages' => $featuredPages,
            'faqs' => $faqs, // <-- Kirim data FAQ ke view
            'sliders' => $sliders,
        ]);
    }
}

