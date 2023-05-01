<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

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
        $validator = Validator::make($request->all(), [
            'student_full_name' => 'required|string|max:191',
            'student_email' => 'required|email|unique:students,student_email',
            'student_phone' => 'required|digits:10',
            'student_course' => 'required|string|max:191',
            'student_avatar' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
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

        if($request->hasFile('student_avatar')) {
            $file = $request->file('student_avatar');
            if($file->isValid()) {
                $fileName = $file->getClientOriginalName();
                $newFile = time() . '-' . $fileName;
                $file->move('app/uploads/', $newFile);
                $student->student_avatar = $newFile;
            }
        }

        $student->student_created_at = time();

        if ($student->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Added Successfully',
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => ['System Error']
        ]);
    }

    public function fetch()
    {
        $data = Student::all();

        if (!empty($data)) {
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);

        }

        return response()->json([
            'status' => 400,
            'message' => 'No data'
        ]);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if (!empty($student)) {
            return response()->json([
                'status' => 200,
                'data' => $student
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'No found'
        ]);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'student_full_name' => 'required|string|max:191',
            'student_email' => 'required|email|unique:students,student_email,'.$id.',student_id',
            'student_phone' => 'required|digits:10',
            'student_course' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        }

        $student = Student::find($id);

        if ($student) {
            $student->student_full_name = $request->input('student_full_name');
            $student->student_email = $request->input('student_email');
            $student->student_phone = $request->input('student_phone');
            $student->student_course = $request->input('student_course');
            $student->student_updated_at = time();

            if ($student->update()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Updated Successfully',
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => ['System Error']
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => ['Not found']
        ]);
    }

    public function delete($id)
    {
        $student = Student::find($id);

        if (!empty($student)) {
            return response()->json([
                'status' => 200,
                'data' => $student
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'No found'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $student = Student::find($id);
        if (!empty($student)) {

            $destination =  'app/uploads/'.$student->student_avatar;
            if(File::exists($destination)) {
                File::delete($destination);
            }

            if ($student->delete()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Deleted Successfully',
                ]);
            }

            return response()->json([
                'status' => 400,
                'message' => 'System Error',
            ]);

        }
        return response()->json([
            'status' => 400,
            'message' => 'Not found'
        ]);
    }
}
