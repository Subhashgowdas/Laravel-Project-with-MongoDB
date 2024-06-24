<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId; 

Route::get('/studentData', function () {
    $users = DB::connection('mongodb')->collection('student_data')->get();
    return response()->json($users);
});

Route::get('/studentData/{id}', function ($id) {
    $objectId = new ObjectId($id);
    $student = DB::connection('mongodb')->collection('student_data')->where('_id', $objectId)->first();
    if ($student) {
        unset($student['_id']);
    }
    return response()->json($student);
});

Route::post('/studentData',function(Request $request){
    $request->validate([
        'rollNumber' => 'required|integer',
        'name' => 'required|string|max:255',
        'branch' => 'nullable|string|max:255',
        'college' => 'nullable|string|max:255',
    ]);
     $data=$request->only(['rollNumber','name','branch','college']);
     try {
        $insertedId = DB::connection('mongodb')->collection('student_data')->insertGetId($data);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to insert data', 'message' => $e->getMessage()], 500);
    }
    return response()->json([
        'id' => (string) $insertedId,
        'rollNumber' => $data['rollNumber'],
        'name' => $data['name'],
        'branch' => $data['branch'] ?? null,
        'college' => $data['college'] ?? null
    ]);
});

Route::get('/studentAddress', function () {
    $users = DB::connection('mongodb')->collection('student_address')->get();
    return response()->json($users);
});

Route::get('/studentAddress/{id}', function ($id) {
    $objectId = new ObjectId($id);
    $student = DB::connection('mongodb')->collection('student_address')->where('_id', $objectId)->first();
    if ($student) {
        unset($student['_id']);
    }
    return response()->json($student);
});

Route::post('/studentAddress', function (Request $request) {
    $request->validate([
        'phoneNumber' => 'nullable|string|max:20',
        'email' => 'required|email|max:255',
        'ZipCode' => 'required|integer',
        'city' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
    ]);
    $data = $request->only(['phoneNumber', 'email', 'ZipCode', 'city', 'state']);
    try {
        $insertedId = DB::connection('mongodb')->collection('student_address')->insertGetId($data);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to insert data', 'message' => $e->getMessage()], 500);
    }
    return response()->json([
        'id' => (string) $insertedId,
        'phoneNumber' => $data['phoneNumber'],
        'email' => $data['email'] ?? null,
        'ZipCode' => $data['ZipCode'] ?? null,
        'city' => $data['city'] ?? null,
        'state' => $data['state'] ?? null
    ]);
});

Route::get('/', function () {
    return 'welcome';
});