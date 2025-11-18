<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class DeleteAllUsers extends Command
{
    /**
     * Назва команди для artisan.
     *
     * Виклик: php artisan users:clear
     */
    protected $signature = 'users:clear {--force : Пропустити підтвердження}';

    /**
     * Опис команди.
     */
    protected $description = 'Видалити всіх користувачів з бази даних';

    /**
     * Логіка команди.
     */
    public function handle()
    {
        if (!$this->option('force')) {
            if (!$this->confirm('⚠️ Увага! Це видалить усіх користувачів. Продовжити?')) {
                $this->info('Операцію скасовано.');
                return Command::SUCCESS;
            }
        }

        $count = User::count();
        User::truncate();

        $this->info("✅ Усі користувачі видалені (всього: {$count}).");
        return Command::SUCCESS;
    }
}
