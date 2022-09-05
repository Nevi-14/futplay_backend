<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OfficeProcess extends Model
{
    use HasFactory;

    protected $table = 'office_processes';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
