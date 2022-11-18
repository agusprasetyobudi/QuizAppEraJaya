<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionResource;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\ReturnTypePass;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = Exam::get();
            return DataTables::of($model)
                              ->addIndexColumn()
                              ->addColumn('action',function($row){
                                $urlUpdate = route('Admin.quiz.edit',['quiz'=>$row->id]);
                                return "<a href='$urlUpdate' class='edit'><i class='fas fa-pencil-alt'></i></a> <a href='javascript:void(0)' class='delete' data-id='$row->id'><i class='fas fa-trash'></i></a>";
                              })
                              ->rawColumns(['action'])
                              ->make(true);

        }
        return view('admin.exam.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                'name'=> 'required|unique:exams',
                'duration' => 'required',
                'exam_start' => 'required|date',
                'exam_end' => 'required|date',
            ]);
            if($validate->fails()){
                return response()->json(['message'=> $validate->errors()->first()],400);

            }
            $request->merge([
                'created_by'=>auth()->user()->id,
                'exam_start' => Carbon::parse($request->exam_start)->format('Y-m-d'),
                'exam_end' => Carbon::parse($request->exam_end)->format('Y-m-d'),
            ]);
            $model = Exam::create($request->except('_token'));
            return response()->json(['message'=> 'Exam Created, Can you continue fill exam question','id'=>$model->id],200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       try {
        $model = Exam::find($id);
        return view('admin.exam.update',['exam'=>$model,'id'=>$id]);
       } catch (\Throwable $th) {
        //throw $th;
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            Exam::find($id)->fill($request->except('_token'))->save();
            return response()->json(['message'=>'Exam Head Has Update'],200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $model = Exam::find($id);
            $model->getQuestion()->delete();
            $model->delete();
            return response()->json(['message'=>'Exam Has Deleted'],200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
