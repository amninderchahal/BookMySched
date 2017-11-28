<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $organization_id
 * @property integer $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Organization $organization
 */
class Default_schedule extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['organization_id', 'day_of_week', 'start_time', 'end_time'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}
