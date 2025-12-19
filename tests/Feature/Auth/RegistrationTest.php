<?php

describe('registration tests', function () {
    it('registers new users', function () {
        registerUser()->assertCreated();
    });

    it('issues a token on register', function () {
        registerUser()->assertJsonStructure(['token']);
    });
});

function registerUser()
{
    return test()->postJson('/api/auth/register', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'johndoe',
        'email' => 'johndoe@gmail.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
}
