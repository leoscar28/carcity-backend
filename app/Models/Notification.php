<?php

namespace App\Models;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\NotificationContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;
    protected $fillable =   NotificationContract::FILLABLE;

    public function completions(): BelongsTo
    {
        return $this->belongsTo(CompletionDate::class,MainContract::COMPLETION_ID,MainContract::ID);
    }

    public function applications(): BelongsTo
    {
        return $this->belongsTo(ApplicationDate::class,MainContract::APPLICATION_ID,MainContract::ID);
    }

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(InvoiceDate::class,MainContract::INVOICE_ID,MainContract::ID);
    }

    public function banners(): BelongsTo
    {
        return $this->belongsTo(UserBanner::class,MainContract::USER_BANNER_ID,MainContract::ID);
    }

    public function reviews(): BelongsTo
    {
        return $this->belongsTo(UserReview::class,MainContract::USER_REVIEW_ID,MainContract::ID);
    }

    public function requests(): BelongsTo
    {
        return $this->belongsTo(UserRequest::class,MainContract::USER_REQUEST_ID,MainContract::ID);
    }

    public function feedbacks(): BelongsTo
    {
        return $this->belongsTo(FeedbackRequest::class,MainContract::FEEDBACK_REQUEST_ID,MainContract::ID);
    }
}
