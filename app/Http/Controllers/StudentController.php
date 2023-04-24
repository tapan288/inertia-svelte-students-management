<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\ClassResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection(\App\Models\Student::all()),
        ]);
    }

    public function create()
    {
        $classes = ClassResource::collection(\App\Models\Classes::all());

        return Inertia::render('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        dd($request->all());
    }
}
