<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordStore extends Model
{
    use HasFactory;

    protected $table = "passwords";

    protected $fillable = [
        'title',
        'description',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
