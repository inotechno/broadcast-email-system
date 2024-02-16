<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'email',
        'name',
        'phone_number',
        'active'
    ];

    /**
     * The categories that belong to the Subscriber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(CategorySubscriber::class, 'category_subscribers_subscribers', 'subscriber_id', 'category_subscriber_id');
    }
}
