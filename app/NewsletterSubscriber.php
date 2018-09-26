<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Newsletter;

class NewsletterSubscriber extends Model
{
    protected $fillable = ['email', 'firstname', 'lastname', 'subscribed_at'];

    protected $dates = ['created_at', 'deleted_at', 'subscribed_at'];

    protected $appends = ['status', 'mailchimp_error'];

    public function getStatusAttribute()
    {
        return $this->isSubscribed() ? 'subscribed' : 'unsubscribed';
    }

    public function setMailchimpErrorAttribute($value)
    {
        $this->attributes['mailchimp_error'] = $value;
    }

    public function getMailchimpErrorAttribute($value)
    {
        return $value;
    }

    public function isSubscribed()
    {
        return !is_null($this->subscribed_at);
    }

    public function isUnsubscribed()
    {
        return !$this->isSubscribed();
    }

    /**
     * Scope a query to get only subscribed members
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubscribed($query)
    {
        return $query->whereNotNull('subscribed_at');
    }

    /**
     * Scope a query to get only unsubscribed members
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnsubscribed($query)
    {
        return $query->whereNull('subscribed_at');
    }

    /**
     * Retireve all subscribers and group them by status.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function allByStatus()
    {
        return static::all()->groupBy('status');
    }

    /**
     * Subscribe a newsletter subscriber.
     *
     * @return $this
     */
    public function subscribe()
    {
        $this->subscribed_at = now();

        $mergeFields = ['FNAME' => '', 'LNAME' => ''];
        if (!empty($this->firstname)) {
            $mergeFields['FNAME'] = $this->firstname;
        }
        if (!empty($this->lastname)) {
            $mergeFields['LNAME'] = $this->lastname;
        }

        // Adding or subscribe user to the Mailchimp list
        Newsletter::subscribeOrUpdate($this->email, $mergeFields);

        if (Newsletter::lastActionSucceeded() === false) {
            // Unable to subscribe the user
            // Ex error : "400: john@example.com was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list."

            $this->mailchimp_error = Newsletter::getLastError();

            \Log::warning($this->mailchimp_error);

            return $this;
        }

        $this->save();

        return $this;
    }

    /**
     * Unsubscribe a newsletter subscriber.
     *
     * @return $this
     */
    public function unsubscribe()
    {
        $this->subscribed_at = null;

        $this->save();

        Newsletter::unsubscribe($this->email);

        if (Newsletter::lastActionSucceeded() === false) {
            // Unable to subscribe the user
            // Ex error : "400: john@example.com was permanently deleted and cannot be re-imported. The contact must re-subscribe to get back on the list."

            $this->mailchimp_error = Newsletter::getLastError();

            \Log::warning($this->mailchimp_error);
        }

        return $this;
    }

    public function toDatatableFormat()
    {
        return [
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'status' => __("messages.subscribers.{$this->status}"),
            'subscribeAction' => [
                'url' => route($this->isSubscribed() ? 'bko.subscriber.unsubscribe' : 'bko.subscriber.subscribe', $this),
                'text' => __("messages.subscribers.actions.{$this->status}")
            ]
        ];
    }
}
