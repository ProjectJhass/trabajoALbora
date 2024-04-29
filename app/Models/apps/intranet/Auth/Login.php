<?php

namespace App\Models\apps\intranet\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Login extends Model
{
    use HasFactory;

    protected static function patron()
    {
        return '/^[a-zA-Z0-9_.]+$/';
    }

    public static function username($username)
    {
        $pattern = self::patron();
        return preg_match($pattern, $username) ? true : false;
    }

    public static function auth_login($username)
    {
        return DB::table('users')->where('usuario', $username)->get();
    }

    public static function validateFields($pwd, $pwd_hash)
    {
        return password_verify($pwd, $pwd_hash) ? true : false;
    }
}
