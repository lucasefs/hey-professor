<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;

use function compact;

use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse};
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        request()->validate([
            'question' => [
                'required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] != '?') {
                        $fail('Are you sure that is a question? It is missing the question mark in the end.');
                    }
                },
            ],
        ]);

        Auth::user()->questions()
            ->create([
                'question' => request()->question,
                'draft'    => true,
            ]);

        return back();
    }

    public function index(): View
    {

        return view('question.index', [
            'questions' => Auth::user()->questions,
        ]);
    }

    public function edit(Question $question): View
    {

        return view('question.edit', compact('question'));
    }

    public function destroy(Question $question): RedirectResponse
    {
        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
