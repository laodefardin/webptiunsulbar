<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CurriculumController extends Controller
{
        public function index()
    {
        // Mengambil semua semester beserta mata kuliah yang berelasi
        $semesters = Semester::with('courses')->get();

        return view('curriculum.index', [
            'semesters' => $semesters
        ]);
    }
}
