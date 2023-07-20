<?php

namespace App\Services;

use App\Models\KindQuestion;
use App\Services\Service;
use Illuminate\Support\Facades\Request;

class KindQuestionService extends Service
{
    public function index()
    {
        $data = KindQuestion::all();
        return $data;
    }
    public function create($data)
    {
        return KindQuestion::create($data);
    }
    public function update($data)
    {
        return KindQuestion::create($data);
    }

    public function delete(Question $question)
    {
        $question->delete();
    }
}
