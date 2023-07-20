<?php

namespace App\Services;

use App\Models\Question;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class QuestionService extends Service
{
    public function index()
    {
        $data = Question::paginate('20');
        return $data;
    }
    public function create(Request $request)
    {
        $data = $request->all();
        return Question::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'number_of_answers' => $data['number_of_answers'],
            'difficulty' => $data['difficulty'],
            'answer' => 'A',
            'note' => $data['note'],
        ]);
    }

    public function delete(Question $question)
    {
        $question->delete();
    }
}
