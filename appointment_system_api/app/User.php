<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $api_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'remember_token', 'api_token'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['password', 'created_at', 'updated_at', 'deleted_at'];
}
