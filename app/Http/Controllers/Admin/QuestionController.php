<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamQuestionResource;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $model = new ExamQuestion();
            $count = $model->where('exam_id',$request->exam_id)->count();
            $request->merge([
                'exam_id'=> (int)$request->exam_id,
                'option' => json_encode($request->option),
                'score'=> $this->countScore($count == 0 ?1:$count+1)
            ]);
            if($request->has('update')){
                $model->where('id',$request->id)->update($request->except('_token','update','id','score'));
                return response()->json(['message'=>'Question Has Update']);
            }else{
                $model->create($request->except('_token','update','id'));
            }
            $model->where('exam_id',$request->exam_id)->update(['score'=>$request->score]);
            return response()->json(['message'=>'Question Has Added']);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['message'=>'Error Adding Question'],400);
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
        $model = ExamQuestion::where('exam_id',$id)->get();
        return DataTables::of($model)
                          ->addIndexColumn()
                          ->addColumn('action',function($row){
                            return "<a href='javascript:void(0)' class='edit' data-id='$row->id'><i class='fas fa-pencil-alt'></i></a> <a href='javascript:void(0)' class='delete' data-id='$row->id'><i class='fas fa-trash'></i></a>";
                          })
                          ->rawColumns(['action'])
                          ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = ExamQuestion::find($id);
        return new ExamQuestionResource($model);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function countScore($question)
    {
        return 100/$question;
    }
}
