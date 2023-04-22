<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection(\App\Models\Student::all()),
        ]);
    }
}
