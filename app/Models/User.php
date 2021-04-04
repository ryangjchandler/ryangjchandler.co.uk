<?php

namespace App\Models;

use Filament\Models\Concerns\IsFilamentUser;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Orbit\Concerns\Orbital;

class User extends Authenticatable implements FilamentUser
{
    use Orbital;
    use IsFilamentUser;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $timestamps = false;

    public static function schema(Blueprint $table)
    {
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->boolean('is_admin')->default(false);
        $table->rememberToken();
    }

    public function getKeyName()
    {
        return 'email';
    }

    public function getIncrementing()
    {
        return false;
    }

    public static function getFilamentAdminColumn()
    {
        return 'is_admin';
    }
}
