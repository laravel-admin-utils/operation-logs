<?php

namespace Elegant\Utils\OperationLog\Models;

use Elegant\Utils\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static find(int $int)
 * @method static create(array $log)
 */
class AuthLog extends Model
{
    use DefaultDatetimeFormat;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'operation',
        'path',
        'method',
        'ip',
        'input'
    ];

    public static $methodColors = [
        'GET'    => 'green',
        'POST'   => 'yellow',
        'PUT'    => 'blue',
        'DELETE' => 'red',
    ];

    public static $methods = [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH', 'LINK', 'UNLINK', 'COPY', 'HEAD', 'PURGE',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('elegant-utils.operation_log.table'));

        parent::__construct($attributes);
    }

    /**
     * Log belongs to user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('elegant-utils.admin.database.user_model'));
    }
}
