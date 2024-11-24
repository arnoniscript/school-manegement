<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all(); // Recupera todos os cursos
        return view('courses.index', compact('courses')); // Retorna a view com os cursos
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create'); // Retorna o formulário de criação
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            'final_date' => 'required|date|after:today',
            'type' => 'required|in:online,presencial',
        ]);

        Course::create($validated); // Cria o curso com os dados validados

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('courses.show', compact('course')); // Retorna a view com os detalhes do curso
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course')); // Retorna o formulário de edição
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
            'final_date' => 'required|date|after:today',
            'type' => 'required|in:online,presencial',
        ]);

        $course->update($validated); // Atualiza o curso com os dados validados

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete(); // Exclui o curso

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
