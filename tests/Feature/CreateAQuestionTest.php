<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

beforeEach(function () {
    //Arrange :: preparar
    $user = User::factory()->create();
    actingAs($user);
});

it('should be able to create a new question bigger than 255 characters', closure: function () {

    //Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    //Assert :: verificar
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?',
    ]);
});

it('should check if ends with question mark ?', function () {

    //Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    //Assert :: verificar
    $request->assertSessionHasErrors(['question' => 'Are you sure that is a question? It is missing the question mark in the end.']);
    assertDatabaseCount('questions', 0);
});

it('should have at least 10 characters', function () {

    //Act :: agir
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 7) . '?',
    ]);

    //Assert :: verificar
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});
