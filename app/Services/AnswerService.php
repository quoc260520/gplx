<?php

namespace App\Services;

use App\Models\Answer;
use App\Models\Question;
use App\Services\Service;
use Flasher\Laravel\Http\Request;
use Illuminate\Support\Arr;

class AnswerService extends Service
{

    public function getListQuestions()
    {
        $data = Question::all();
        return $data;
    }
    public function create($request, $id)
    {
        $data = $request->all();
        $question = Question::where('id', $id)->first();
        for ($x = 1; $x <= $question->number_of_answers; $x++) {
            Answer::create([
                'question_id' => $id,
                'answer' => $data['question' . $x],
            ]);
        }
    }

    public function update(Question $question, $request)
    {
        $answers = $question->answers()->pluck('id');

        for ($x = 1; $x <= $question->number_of_answers(); $x++) {
            $answer = Answer::find($answers[$x - 1]);
            $answer->update([
                'answer' => $request->get('question' . $x),
            ]);
            $answer->save();
        }
    }
}
