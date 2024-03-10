<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\{QuestionEndsRule, SameQuestionRule};
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index(): View
    {

        return view('question.index', [
            'questions'         => Auth::user()->questions,
            'archivedQuestions' => Auth::user()->questions()->onlyTrashed()->get(),
        ]);
    }

    public function store(): RedirectResponse
    {

        request()->validate([
            'question' => [
                'required',
                'min:10',
                new QuestionEndsRule(),
                new SameQuestionRule(),
            ],
        ]);

        Auth::user()->questions()
            ->create([
                'question' => request()->question,
                'draft'    => true,
            ]);

        return back();
    }

    public function edit(Question $question): View
    {

        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {

        $this->authorize('update', $question);

        request()->validate([
            'question' => [
                'required',
                'min:10',
                new QuestionEndsRule(),
                new SameQuestionRule(),
            ],
        ]);

        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }

    public function restore(int $id): RedirectResponse
    {

        $question = Question::withTrashed()->find($id);
        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('archive', $question);

        $question->delete();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }
}
