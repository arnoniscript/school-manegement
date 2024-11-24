<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all(); // Recupera todos os alunos
        return view('students.index', compact('students')); // Retorna a view com os alunos
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create'); // Retorna o formulário de criação
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'email' => 'required|email|unique:students,email',
        ]);

        Student::create($validated); // Cria o aluno com os dados validados

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student')); // Retorna a view com os detalhes do aluno
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student')); // Retorna o formulário de edição
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string|max:500',
            'email' => 'required|email|unique:students,email,' . $student->id,
        ]);

        $student->update($validated); // Atualiza os dados do aluno

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete(); // Exclui o aluno

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
