<?php

namespace App\Models;

use App\Traits\Searchable;
use App\Filters\UserFilters;
use App\Traits\HasSocialAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Nova\Actions\Actionable;
use Plank\Metable\Metable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens, HasRoles, HasSocialAccounts, Actionable, Searchable,Metable;

    protected $fillable = [
        'first_name','last_name', 'email', 'avatar', 'locale', 'active', 'password','email_verified_at'
    ];

    public static $searchable = [
        'name', 'email',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active'            => 'boolean',
    ];

    protected $dates=[
        'email_verified_at'
    ];

    /*public function getAvatarAttribute($value)
    {
        return $value
            ? asset($value)
            : "https://ui-avatars.com/api?name={$this->name}&rounded=true&bold=true&format=svg";
    }*/

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? Storage::url($this->avatar) : null;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFilter($query)
    {
        return resolve(UserFilters::class)->apply($query);
    }

    public function activate()
    {
        $this->update(['active' => true]);
    }

    public function deactivate()
    {
        $this->update(['active' => false]);
    }

    public function createAccessToken($device = null)
    {
        return $this->createToken($device ?: str_random(8))->plainTextToken;
    }
    public function devices(){
        return $this->hasMany(Device::class);
    }

    public function getNameAttribute($key)
    {
        return implode(" ",[$this->first_name,$this->last_name]);
    }

    public static function findOrCreate($data,$key=null)
    {
        if($key!==null)$key=(array_key_exists('email',$data))?'email':'id';
        $obj = static::where($key,$data[$key])->get()->first();
        return $obj ?: (new static)->fill(['password'=>bcrypt('password')]);
    }

    public function company(){
        return $this->belongsToMany(Company::class);
    }

    public function companyAssociates(){
        return $this->belongsToMany(Company::class,'company_associates','user_id','company_id');
    }


}
