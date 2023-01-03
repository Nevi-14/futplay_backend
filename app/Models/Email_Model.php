<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Email_Model extends Model
{
    use HasFactory;

    protected $table = 'offices';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
