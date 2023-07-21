<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Validator;

class AnnouncementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $announcements = Announcement::all();
        return view('backend.announcements.index', [
            'announcements' => $announcements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->campus == 'All'){
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'content' => ['required'],
            ]);  
        }
        else{
            $validator = Validator::make($request->all(), [
                'campus' => ['required'],
                'shift' => ['required'],
                'student_id' => ['required', 'array'],
                'class_id' => ['required'],
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'content' => ['required'],
            ]);            
        }
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $student_id = $request->student_id;
        $student_ids = 0; 

        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            } 
        }  
		$create = Announcement::create([
            'campus' => $request->campus, 
            'shift' => $request->shift,
            'class_id' => $request->class_id,
            'section' => $request->section, 
            'student_id' => $student_ids,
			'title' => $request->title,
			'content' => $request->content,
		]);
		if ($create) {
			toastr()->success(__('Created Successfully'));
			return redirect()->route('admin.announcements.index');
		}
		else {
            toastr()->error(__('Create error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('backend.announcements.edit', ['announcement' => $announcement]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        if($request->campus == 'All'){
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'content' => ['required'],
            ]);  
        }
        else{
            $validator = Validator::make($request->all(), [
                'campus' => ['required'],
                'shift' => ['required'],
                //'student_id' => ['required', 'array'],
                'class_id' => ['required'],
                'title' => ['required', 'string', 'max:255', 'min:2'],
                'content' => ['required'],
            ]);            
        }
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $student_id = $request->student_id;
        $student_ids = 0; 

        if(!empty($student_id))
        {
            if(!in_array('all', $student_id))
            {
                $student_ids = implode(',',$student_id);
            } 
        }
        $status = ($request->has('status')) ? 1 : 0;
		$update = $announcement->update([
            'campus' => $request->campus, 
            'shift' => $request->shift,
            'class_id' => $request->class_id,
            'section' => $request->section, 
            'student_id' => $student_ids,
            'title' => $request->title,
            'content' => $request->content,
            'status' => $status,
		]);
		if ($update) {
			toastr()->success(__('Updated Successfully'));
            return redirect()->route('admin.announcements.index');
		}
		return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        toastr()->success(__('Deleted Successfully'));
        return back();
    }
}
