<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public $data = [];

    public function index()
    {
        $this->data['title'] = 'Data Student';
        return view('students.index', $this->data);
    }

    public function store(Request $request)
    {
        if($request->ajax()){
            return response()->json([
                'status' => 400,
                'message' => ['request' => 'Bad Request']
            ]);
        }

        $validator = Validator::make($request->all(), [
            'student_full_name' => 'required|string|max:191',
            'student_email' => 'required|email|unique:students,student_email',
            'student_phone' => 'required|digits:10',
            'student_course' => 'required|string|max:191',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }

        $student = new Student();
        $student->student_full_name = $request->input('student_full_name');
        $student->student_email = $request->input('student_email');
        $student->student_phone = $request->input('student_phone');
        $student->student_course = $request->input('student_course');
        if(!$student->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully',
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Internal Server Error',
        ]);
    }
}
