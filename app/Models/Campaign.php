<?php

namespace App\Models;

ini_set('memory_limit', '1024M');


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'subject',
        'from_email',
        'is_html',
        'message',
        'message_without_template',
        'start_send_at',
        'status',
        'executed',
        'template_id',
        'created_by'
    ];

    /**
     * Get the template that owns the Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the created_by that owns the Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The categories that belong to the Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(CategorySubscriber::class, 'campaigns_categories', 'campaign_id', 'category_id');
    }

    /**
     * Get all of the logs for the Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(EmailLog::class, 'campaign_id');
    }

    public function scopeWithStatusCounts($query)
    {
        $query->withCount([
            'logs as total_pending' => function ($query) {
                $query->where('status', 'pending');
            },
            'logs as total_queue' => function ($query) {
                $query->where('status', 'queued');
            },
            'logs as total_sent' => function ($query) {
                $query->where('status', 'sent');
            },
            'logs as total_failed' => function ($query) {
                $query->where('status', 'failed');
            },
        ]);
    }

    /**
     * Get all of the attachments for the Campaign
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(CampaignAttachment::class, 'campaign_id');
    }
}
