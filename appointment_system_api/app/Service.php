<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $organization_id
 * @property string $name
 * @property boolean $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Organization $organization
 * @property Appointment[] $appointments
 */
class Service extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['organization_id', 'name', 'description'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

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
