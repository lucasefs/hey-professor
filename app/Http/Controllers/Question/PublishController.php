<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;

use function back;

use Illuminate\Http\{RedirectResponse, Request};

class PublishController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {

        $this->authorize('publish', $question);

        $question->update(['draft' => false]);

        return back();
    }
}
