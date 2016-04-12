<?php

namespace Qodeboy\Mailman\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MailMessageModel
 *
 * @package Qodeboy\Mailman\Models
 */
class MailmanMessageModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table;
    
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'message_id',
        'content_type',
        'status',
        'from',
        'to',
        'reply_to',
        'cc',
        'bcc',
        'subject',
        'body',
        'instance',
    ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'from'     => 'json',
        'to'       => 'json',
        'reply_to' => 'json',
        'cc'       => 'json',
        'bcc'      => 'json',
    ];
    
    /**
     * {@inheritdoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('mailman.storage.database.table');
        parent::__construct($attributes);
    }
    
    /**
     * Set instance attribute.
     *
     * @param $value
     */
    public function setInstanceAttribute($value)
    {
        $this->attributes['instance'] = serialize($value);
    }
    
    /**
     * Get instance attribute.
     *
     * @param $value
     *
     * @return mixed
     */
    public function getInstanceAttribute($value)
    {
        return unserialize($value);
    }
}