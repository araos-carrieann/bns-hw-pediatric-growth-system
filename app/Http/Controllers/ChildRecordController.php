<?php

namespace App\Http\Controllers;

use App\Models\ChildRecord;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ChildRecordController extends Controller
{
    public function index()
    {
        $children = ChildRecord::all();

        Log::info('Retrieved all child records');

        return view('children.index', ['children' => $children]);
    }

    public function create()
    {
        Log::info('Viewed create form for child record');

        return view('children.create');
    }

    public function store(Request $request)
    {
        $healthWorkerId = session('userId'); // Retrieve health worker ID from the session
    
        $data = $request->all();
        $data['health_worker_id'] = $healthWorkerId; // Add health worker ID to the data
    
        ChildRecord::create($data);
    
        Log::info('Created a new child record');
    
        return redirect()->back()->with('success', 'Data inserted successfully!');
    }
    

    public function edit($id)
    {
        $child = ChildRecord::findOrFail($id);

        Log::info('Viewed edit form for child record with ID: ' . $id);

        return view('children.edit', ['child' => $child]);
    }

    public function update(Request $request, $id)
    {
        $child = ChildRecord::findOrFail($id);

        $child->update($request->all());

        Log::info('Updated child record with ID: ' . $id);

        return redirect()->route('children.index')->with('success', 'Child record updated successfully!');
    }
}
