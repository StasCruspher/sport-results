<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    protected $signature = 'user:create {password}';
    protected $description = 'Створює користувача з паролем';

    public function handle()
    {
        $password = $this->argument('password');

        User::create([
            'password' => Hash::make($password),
        ]);

        $this->info('Користувача створено успішно!');
    }
}
