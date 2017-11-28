<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property integer $address_id
 * @property integer $organization_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Address $address
 * @property Organization $organization
 */
class Organization_address extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['address_id', 'organization_id'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
}
