<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use App\Http\Resources\ClassResource;
use App\Http\Resources\StudentResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('student_access');

        $studentsQuery = Student::studentQuery(
            searchTerm: trim($request->searchTerm ?? ''),
            class_id: $request->class_id ?? null,
            section_id: $request->section_id ?? null,
        );

        if ($request->selectAll) {
            return StudentResource::collection(
                $studentsQuery->get()
            );
        }

        $students = StudentResource::collection(
            $studentsQuery->paginate($request->pageSize ?? 10)
        );

        return Inertia::render('Students/Index', [
            'students' => $students,
            'classes' => ClassResource::collection(\App\Models\Classes::all()),
        ]);
    }

    public function create()
    {
        $this->authorize('student_create');

        $classes = ClassResource::collection(\App\Models\Classes::all());

        return Inertia::render('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        $this->authorize('student_create');

        $student = Student::create($request->validated());

        $student
            ->addMedia($request->avatar[0])
            ->toMediaCollection();

        return redirect()->route('students.index')
            ->with('message', 'Student created successfully');
    }
    public function edit(Student $student)
    {
        $this->authorize('student_edit');

        $classes = ClassResource::collection(\App\Models\Classes::all());

        return Inertia::render('Students/Edit', [
            'classes' => $classes,
            'student' => new StudentResource($student),
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $this->authorize('student_edit');

        $student->update($request->validated());

        $student
            ->addMedia($request->avatar[0])
            ->toMediaCollection();

        return redirect()->route('students.index')
            ->with('message', 'Student details updated successfully');
    }

    public function destroy(Student $student)
    {
        $this->authorize('student_delete');

        $student->delete();

        return redirect()->route('students.index')
            ->with('message', 'Student deleted successfully');
    }

    public function massDestroy(Request $request)
    {
        $this->authorize('student_delete');

        Student::whereIn('id', $request->records)->delete();

        return redirect()->route('students.index')
            ->with('message', 'Students deleted successfully');
    }

    public function export(Request $request)
    {
        return (new StudentsExport($request->records))->download(now() . ' - students.xlsx');
    }
}
