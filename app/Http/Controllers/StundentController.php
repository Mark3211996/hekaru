<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\retrieve;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StundentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Students::all();
        //return ['timeout' => [$data->toArray()]];
        return view('teacher', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $section = $request->input('section');
        $timeIn = $request->input('timein');
        $compareTime = "10:00:00 PM"; // iyang  out 
        $startClass = "3:10:52 PM"; // startclass 
        $outime = "4:10:40 PM";
        $ctime = "5:10:52 PM";
        if (strtotime($timeIn) > strtotime($outime) && strtotime($timeIn) < strtotime($compareTime)) {
            $status = "Late";
        } else if (strtotime($timeIn) > strtotime($startClass) && strtotime($timeIn) < strtotime($outime)) {
            $status = "present";
        } else {
            $status = "absent";
        }

        $Students = Students::create([
            'firstname' => $fname,
            'lastname' => $lname,
            'section' => $section,
            'timeIn' => $timeIn,
            'timeOut' => "",
            'status' => $status

        ]);
        //return response()->json(['message' => $Students->firstname], 200);

        return redirect()->route('show', ['firstname' => $Students->firstname]);





    }
    public function addstudents(Request $request)
    {
        //
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $section = $request->input('section');
        $timeIn = $request->input('timein');
        $timeOut = $request->input('timeout');
        $Students = Students::create([
            'firstname' => $fname,
            'lastname' => $lname,
            'section' => $section,
            'timeIn' => $timeIn,
            'timeOut' => $timeOut,
            'status' => "present"

        ]);
        return "successfully created";

    }

    /**
     * Display the specified resource.
     */
    public function show($firstname)
    {
        $users = Students::where('firstname', $firstname)->get();

        return response()->json(['message' => $users], 200);

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $users = Students::where('id', $id)->get();

        return response()->json(['message' => $users], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        ////
        $id = $request->input('id');

        // Retrieve the resource by ID
        $resource = Students::findOrFail($id);
        $resource->timeOut = $request->timeOut;
        $resource->save();

        // Update the resource with new data
        return ['timeout' => [$resource->toArray()]];



    }
    public function updateinfo(Request $request)
    {
        $id = $request->input('id');
        $resource = Students::findOrFail($id);

        $resource->firstname = $request->fname;
        $resource->lastname = $request->lname;
        $resource->section = $request->section;
        $resource->timeIn = $request->timein;
        $resource->timeOut = $request->timeout;
        $resource->save();
        return "updated successfully";

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->input('id');

        $resource = Students::findOrFail($id);
        $retrieve = new retrieve();
        $retrieve->firstname = $resource->Firstname;
        $retrieve->lastname = $resource->Lastname;
        $retrieve->section = $resource->Section;
        $retrieve->timeIn = $resource->timeIn;
        $retrieve->timeOut = $resource->timeOut;
        $retrieve->status = $resource->status;
        $retrieve->save();
        $resource->delete();
        return "succesfully deleted";
    }
}