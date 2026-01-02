<?php

dataset('registration payloads', [
    'valid user' => [[
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'johndoe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]],
]);

describe('registration tests', function () {
    it('registers new users', function ($payloads) {
        $this->postJson('/api/auth/register', $payloads)
            ->assertCreated();
    });

    it('issues a token on register', function ($payloads) {
        $this->postJson('/api/auth/register', $payloads)
            ->assertJsonStructure(['token']);
    });
})->with('registration payloads');
