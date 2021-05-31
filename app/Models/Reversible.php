<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Reversible as ReversibleTrait;
class Reversible extends Model
{
    use HasFactory;
    use ReversibleTrait;

    protected $guarded = [];

    protected $fillable= ['reversible_type','reversible_id','data','user_id','company_id'];
}
