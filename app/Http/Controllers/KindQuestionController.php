<?php

namespace App\Http\Controllers;

use App\Models\KindQuestion;
use App\Services\KindQuestionService;
use Illuminate\Http\Request;

class KindQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $kindQuestionService;

    public function __construct(KindQuestionService $kindQuestionService)
    {
        $this->kindQuestionService = $kindQuestionService;
    }
    public function index()
    {
        $kinds = $this->kindQuestionService->index();
        return view('admin.kind.list')->withKinds($kinds);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:kind_questions,name',
        ]);
        $kind = $this->kindQuestionService->create($validate);
        return back()->withFlashSuccess('Thêm loại câu hỏi thành công');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KindQuestion $kindQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KindQuestion $kindQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KindQuestion $kindQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KindQuestion $kindQuestion)
    {
        //
    }
}
