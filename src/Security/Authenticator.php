<?php


namespace App\Security;


interface Authenticator
{
    public function generate(array $data = []) : string;

    public function authenticate(string $token) : array;
}