<?php

namespace App\Models\User;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;

    protected $table = "user";
    protected $primaryKey = "id";
    // protected $rememberTokenName = "remember_token";

    public $incrementing = TRUE;
    public $timestamps = TRUE;
    public $remember = TRUE;

    protected $fillable = [];
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token', 'api_token'];

    // public function scopeAuth($query, $data) {
    //     return $query->where('user_authority_id', '=', $data);
    // }

    // public function scopeGenerateApiToken($query) {
    //     return $query->update(['api_token' => str_random(77)]);
    // }

    // public function scopeDestroyApiToken($query) {
    //     return $query->update(['api_token' => null]);
    // }

}
