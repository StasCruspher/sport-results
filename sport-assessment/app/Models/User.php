<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    // Вказуємо, які поля можна масово заповнювати
    protected $fillable = [
        'password',
    ];

    // Ховаємо пароль, якщо виводимо модель
    protected $hidden = [
        'password',
    ];

    // Не потрібні timestamps
    public $timestamps = false;
}
