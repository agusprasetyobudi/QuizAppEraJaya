<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'exam_id' =>$this->exam_id,
            'question' =>$this->question,
            'option' =>json_decode($this->option),
            'answer' =>$this->answer,
            'score' =>$this->score,
        ];
    }
}
