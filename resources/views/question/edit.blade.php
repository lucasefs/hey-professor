<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Question') }} :: {{ $question->id }}
        </x-header>
    </x-slot>

    <x-container>
        <x-form :action="route('question.update', $question)" put>
            <x-textarea label="Question" name="question" :value="$question->question"/>

            <x-btn.primary>Save</x-btn.primary>
            <x-a.cancel :href="route('question.index')">
                Cancel
            </x-a.cancel>
        </x-form>
    </x-container>
</x-app-layout>
