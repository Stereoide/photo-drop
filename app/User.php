<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'token', 'tos_accepted',
    ];

    /* Relationships */

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    /* Scopes */

    public function scopeTosAccepted($query)
    {
        return $query->where('tos_accepted', true);
    }
}
