<?php
namespace App\DataFixtures;

class Data
{
    const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@lord.fr',
            'password' => '0000',
            'roles' => ['ROLE_ADMIN']
        ],
        [
            'username' => 'user',
            'email' => 'user@lord.fr',
            'password' => '0000',
            'roles' => ['ROLE_USER']
        ]
    ];
}