<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Services\AnswerService;
use App\Services\KindQuestionService;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionService;
    protected $kindQuestionService;
    protected $kinds;

    public function __construct(QuestionService $questionService, KindQuestionService $kindQuestionService)
    {
        $this->questionService = $questionService;
        $this->kindQuestionService = $kindQuestionService;
        $this->kinds = $kindQuestionService->index();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $questions = $this->questionService->index();
        return view('admin.answers.list')
            ->withKinds($this->kinds)
            ->withQuestions($questions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.answers.create')->withKinds($this->kinds);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postCreate(QuestionRequest $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        $data['title'] = 'Thông tin chi tiết';
        $data['question'] = $question;
        $data['answers'] = $question->answers();

        return view('admin.questions.show')->with(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        $data['title'] = 'Thông tin chi tiết';
        $data['question'] = $question;

        return view('admin.questions.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $data1 = $request->all();
        for ($i = 1; $i <= $question->number_of_answers; $i++) {
            if ($data1['question1'] == null) {
                toastr()->error('Không được để trống các trường');
                return back()->withInput();
            }
        }

        $question->update([
            'name' => $data1['name'],
            'type' => $data1['type'],
            'number_of_answers' => $data1['number_of_answers'],
            'difficulty' => $data1['difficulty'],
            'answer' => $data1['correct_answer'],
            'note' => $data1['note'],
        ]);

        $question->save();

        AnswerService::getInstance()->update($question, $request);
        $data['title'] = 'Câu hỏi';
        $data['questions'] = QuestionService::getInstance()->getListQuestions();
        toastr()->success('Cập nhật thành công');
        return redirect(route('questions.index'))->with(['data', $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        QuestionService::getInstance()->delete($question);
        toastr()->success('Xóa thành công');
        return redirect()->route('questions.index');
    }
}
