<?php

namespace App;

//use Illuminate\Auth\Authenticatable;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
//use Laravel\Lumen\Auth\Authorizable;

class Land extends Model 
{
    //use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'land_number','Gramaseva_division', 'District', 'Owership','Size','Crop','NIC'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
