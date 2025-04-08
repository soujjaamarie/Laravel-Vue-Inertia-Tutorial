<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentsRequest;
use App\Http\Requests\UpdateStudentsRequest;
use App\Http\Resources\ClassesResources;
use App\Http\Resources\SectionsResources;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Http\Resources\StudentsResources;
use App\Models\Classes;
use App\Models\Sections;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StudentsController extends Controller

{
    public function index(Request $request)
{
    $studentQuery = Students::query();
    $this->applySearch($studentQuery, $request->input('search'));

    $classes = ClassesResources::collection(Classes::all());

    return inertia('Students/Index', [
        'students' => StudentsResources::collection(
            $studentQuery->paginate(5)
        ),
        'classes' => $classes,
        'search' => $request->input('search', '')
    ]);
}


    protected function applySearch(Builder $query, $search)
    {
        return $query->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }
    public function create()
    {

        $classes = ClassesResources::collection(Classes::all());

        return inertia('Students/Create', [
            'classes' => $classes,
        ]);
    }


    public function store(StoreStudentsRequest $request)
    {
        Students::create($request->validated());


        return redirect()->route('Students.index');
    }



    public function edit($student_id)
    {
        $student = Students::findOrFail($student_id);
    
        $classes = Classes::all();
        $transformedClasses = ClassesResources::collection($classes)->toArray(request());
    
        // 🟡 Fetch sections that belong to the student's class_id
        $sections = Sections::where('class_id', $student->class_id)->get();
    
        return inertia('Students/Edit', [
            'student' => $student,
            'Classes' => $transformedClasses,
            'sections' => $sections,
        ]);
    }
    


    public function update(UpdateStudentsRequest $request, $id)
    {
        $student = Students::findOrFail($id); // Find the students or return 404
        $student->update($request->validated()); // Update with validated data
       
        return redirect()->route('Students.index')->with('success', 'Students updated successfully!');
        
    }

    public function destroy($id)
    {
        $student = Students::findOrFail($id);
        $student->delete();
    
        return redirect()->route('Students.index')->with('success', 'Students deleted successfully!');
    }
    

    





}
