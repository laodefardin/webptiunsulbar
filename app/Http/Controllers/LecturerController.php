<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lecturer;

class LecturerController extends Controller
{
        /**
     * Menampilkan daftar semua dosen dan staff.
     */
    public function index()
    {
        $lecturers = Lecturer::orderBy('name', 'asc')->get();

        return view('lecturers.index', [
            'lecturers' => $lecturers,
        ]);
    }
}
