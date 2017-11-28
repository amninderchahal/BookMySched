<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $client_id
 * @property integer $employee_id
 * @property integer $organization_id
 * @property integer $service_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property boolean $is_canceled
 * @property string $marked_as
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Client $client
 * @property Person $person
 * @property Organization $organization
 * @property Service $service
 */
class Appointment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title','client_id', 'employee_id', 'organization_id', 'service_id', 'date', 'start_time', 'end_time', 'marked_as'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $hidden = ['updated_at', 'deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
