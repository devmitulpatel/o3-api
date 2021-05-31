<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Reversible;

class ReversibleLog extends Model
{
    use HasFactory;
    use Reversible;

    protected $guarded = [];


}
