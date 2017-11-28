<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $employee_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property boolean $is_deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Person $person
 */
class Schedule extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['employee_id', 'date', 'start_time', 'end_time'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'employee_id');
    }
}
