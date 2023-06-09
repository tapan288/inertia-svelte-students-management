<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\ClassResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function index()
    {
        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection(
                \App\Models\Student::paginate()
            ),
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
        $student = Student::create($request->validated());

        $student
            ->addMedia($request->avatar[0])
            ->toMediaCollection();

        return redirect()->route('students.index')
            ->with('message', 'Student created successfully');
    }
    public function edit(Student $student)
    {
        $classes = ClassResource::collection(\App\Models\Classes::all());

        return Inertia::render('Students/Edit', [
            'classes' => $classes,
            'student' => new StudentResource($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        $student
            ->addMedia($request->avatar[0])
            ->toMediaCollection();

        return redirect()->route('students.index')
            ->with('message', 'Student details updated successfully');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('message', 'Student deleted successfully');
    }
}
