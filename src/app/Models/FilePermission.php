<?php

namespace Ie\FileManager\App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class FilePermission extends Model
{
    use  HasFactory;
    protected $table='file_user_permission';
    protected $fillable = [
        'user_id',
        'path',
        'access',
        'type',
        'has_all',
        'parents',
    ];
    protected $casts = [
        'parents' => 'array',
    ];
}
