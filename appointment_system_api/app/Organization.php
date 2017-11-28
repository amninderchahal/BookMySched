<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property OrganizationAddress[] $organizationAddresses
 * @property Person[] $persons
 * @property Service[] $services
 */
class Organization extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['name'];

    protected $hidden = ['updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizationAddresses()
    {
        return $this->hasMany('App\OrganizationAddress');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function persons()
    {
        return $this->hasMany('App\Person');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany('App\Service');
    }
}
