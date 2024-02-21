<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'total'
    ];


    /**
     * The subscribers that belong to the CategorySubscriber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'category_subscribers_subscribers', 'category_subscriber_id', 'subscriber_id');
    }

    /**
     * The campaigns that belong to the CategorySubscriber
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'campaigns_categories', 'category_id', 'campaign_id');
    }
}
