<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $added_by
 * @property integer $organization_id
 * @property string $firstname
 * @property string $lastname
 * @property string $phone_number
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Person $person
 * @property Organization $organization
 * @property Appointment[] $appointments
 */
class Client extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['added_by', 'organization_id', 'firstname', 'lastname', 'phone_number', 'email'];

    protected $hidden = ['updated_at', 'deleted_at'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'added_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }
}
