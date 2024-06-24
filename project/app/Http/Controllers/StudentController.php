<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAddress;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'rollNumber' => 'required|integer',
            'branch' => 'required|string|max:255',
            'college' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255',
        ]);

        // Create student record
        $student = Student::create($request->only(['name', 'rollNumber', 'branch', 'college']));

        // Create student address record
        $address = new StudentAddress($request->only(['phoneNumber', 'email', 'location']));
        $address->student_id = $student->_id;
        $address->save();

        return response()->json(['message' => 'Student and address created successfully'], 201);
    }

    public function show($id)
    {
        // Fetch student with address
        $student = Student::with('address')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    public function index()
    {
        // Fetch all students with addresses
        $students = Student::with('address')->get();
        return response()->json($students);
    }
}
