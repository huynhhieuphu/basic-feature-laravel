<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentFormRequest;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    public $data = [];

    public function index()
    {
        $this->data['title'] = 'Student Form Request Validation';
        $this->data['students'] = Student::all();
        return view('students.index', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Add Student with Form Request Validation';
        return view('students.create', $this->data);
    }

    public function store(StudentFormRequest $request)
    {
        $data = $request->validated();

        //upload file
        if ($request->hasFile('student_avatar')) {
            $file = $data['student_avatar'];
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $newFile = time().'-'.$fileName;
                $file->move('app/uploads/', $newFile); //path: public/app/uploads/
                $data['student_avatar'] = $newFile;
            }
        }
        $data['student_created_at'] = time();

        try {
            Student::create($data);
            return redirect()->route('student.index')->with('msg', 'Added Successfully');
        } catch (\Exception $ex) {
            return redirect()->route('student.create')->with('msg', 'Some went wrong '.$ex);
        }
    }

    public function show(Student $student)
    {
        $this->data['title'] = 'Show Student with Form Request Validation';
        $this->data['student'] = $student;
        return view('students.show', $this->data);
    }

    public function edit(Student $student)
    {
        $this->data['title'] = 'Edit Student with Form Request Validation';
        $this->data['student'] = $student;
        return view('students.edit', $this->data);
    }

    public function update(StudentFormRequest $request, Student $student)
    {

        $data = $request->validated();
        //upload file
        if ($request->hasFile('student_avatar')) {

            // delete old file
            $destination =  'app/uploads/'.$student->student_avatar;
            if(File::exists($destination)) {
                File::delete($destination);
            }

            $file = $data['student_avatar'];
            if ($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $newFile = time().'-'.$fileName;
                $file->move('app/uploads/', $newFile); //path: public/app/uploads/
                $data['student_avatar'] = $newFile;
            }
        }

        $data['student_updated_at'] = time();
        try {
            $student->fill($data);
            $student->save();
            return redirect()->route('student.index')->with('msg', 'Updated Successfully');
        } catch (\Exception $ex) {
            return redirect()->route('student.create')->with('msg', 'Some went wrong '.$ex);
        }
    }

    public function destroy(Student $student)
    {
        try {
            // delete old file
            $destination =  'app/uploads/'.$student->student_avatar;
            if(File::exists($destination)) {
                File::delete($destination);
            }

            $student->delete();
            return redirect()->back()->with('msg', 'Deleted Successfully');
        } catch (\Exception $ex) {
            return redirect()->route('student.create')->with('msg', 'Some went wrong '.$ex);
        }
    }
}
