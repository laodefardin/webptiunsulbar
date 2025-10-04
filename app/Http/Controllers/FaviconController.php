<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaviconController extends Controller
{
    public function __invoke()
    {
        // Ambil path favicon dari database, dengan fallback ke file default
        $faviconPath = Setting::where('key', 'site_favicon')->value('value') ?? 'settings/01K6JA6M24GF5W0XHHP27Z1F17.png';

        // Jika file tidak ada di storage, gunakan file default
        if (!Storage::disk('public')->exists($faviconPath)) {
            $faviconPath = 'settings/01K6JA6M24GF5W0XHHP27Z1F17.png'; // Pastikan Anda punya file ini di public/images
        }

        // Kembalikan file sebagai response gambar
        return Storage::disk('public')->response($faviconPath);
    }
}
