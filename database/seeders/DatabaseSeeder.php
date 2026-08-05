<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /** بيانات حساب المدير (تُحدَّث عند كل تشغيل للـ seeder). */
    public const ADMIN_EMAIL = 'admin@gmail.com';

    public const ADMIN_PASSWORD = '123456654321';

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make(self::ADMIN_PASSWORD),
                'role' => 'admin',
                'email_verified_at' => now(),
                'banned_at' => null,
            ]
        );
    }
}
