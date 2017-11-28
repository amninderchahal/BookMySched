<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $street
 * @property string $city
 * @property string $country
 * @property string $postal_code
 * @property string $phone_number
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property OrganizationAddress[] $organizationAddresses
 */
class Address extends Model
{
    use SoftDeletes;
    /**
     * @var array
     */
    protected $fillable = ['street', 'city', 'country', 'postal_code', 'phone_number'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizationAddresses()
    {
        return $this->hasMany('App\OrganizationAddress');
    }
}
