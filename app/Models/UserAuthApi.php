<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Eloquent\SoftDeletes;

/**
 * @property int $_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class UserAuthApi extends Eloquent implements Authenticatable
{
    use SoftDeletes;
    use AuthenticableTrait;

    protected $collection = 'userAuthApi';
    protected $primaryKey = '_id';

    protected $fillable = [
        'username',
        'apiToken',
    ];

    protected $hidden = [
        'apiToken',
    ];
}
