<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserAttemptLog
 *
 * @property int $id
 * @property string $email
 * @property string $ip_address
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Database\Factories\UserAttemptLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttemptLog whereIpAddress($value)
 * @mixin \Eloquent
 */
class UserAttemptLog extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'email',
        'ip_address',
        'success',
    ];
}
