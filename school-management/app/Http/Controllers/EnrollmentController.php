<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->get(); // Carrega matrículas com alunos e cursos relacionados
        return view('enrollments.index', compact('enrollments')); // Retorna a view com as matrículas
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all(); // Carrega todos os alunos
        $courses = Course::all(); // Carrega todos os cursos
        return view('enrollments.create', compact('students', 'courses')); // Retorna o formulário de criação
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:pending,confirmed',
        ]);

        Enrollment::create($validated); // Cria a matrícula com os dados validados

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment')); // Retorna a view com os detalhes da matrícula
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::all(); // Carrega todos os alunos
        $courses = Course::all(); // Carrega todos os cursos
        return view('enrollments.edit', compact('enrollment', 'students', 'courses')); // Retorna o formulário de edição
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:pending,confirmed',
        ]);

        $enrollment->update($validated); // Atualiza a matrícula com os dados validados

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete(); // Exclui a matrícula

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}
