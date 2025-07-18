<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckAI extends Model
{
    use HasFactory;

    protected $table = 'check_ai'; // Nama tabel di database
    protected $fillable = ['created_at', 'node', 'n', 'p', 'k', 'temperature', 'ph', 'humidity', 'crop', 'result'];
}
