<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'file_url',
        'file_name',
        'file_ext',
        'file_size',
        'file_mime'
    ];

    /**
     * Get the campaign that owns the CampaignAttachment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
