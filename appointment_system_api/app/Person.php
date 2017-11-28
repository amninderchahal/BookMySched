<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $organization_id
 * @property integer $role_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property string $phone_number
 * @property string $street
 * @property string $city
 * @property string $country
 * @property string $postal_code
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Organization $organization
 * @property Role $role
 * @property Appointment[] $appointments
 * @property Schedule[] $schedules
 */
class Person extends Model
{
    use SoftDeletes;

    protected $table = 'person';

    /**
     * @var array
     */
    protected $fillable = ['organization_id', 'role_id', 'firstname', 'lastname', 'email', 'password', 'phone_number', 'street', 'city', 'country', 'postal_code'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['password', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment', 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules()
    {
        return $this->hasMany('App\Schedule', 'employee_id');
    }
}
