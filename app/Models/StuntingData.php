<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StuntingData extends Model {
    use HasFactory;

    protected $table = 'stunting_data';
    protected $fillable = ['province', 'district', 'year', 'stunting_rate', 'target_rate'];
}
