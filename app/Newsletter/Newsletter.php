<?php

namespace App\Newsletter;

class Newsletter extends \Spatie\Newsletter\Newsletter
{
    public function send($campaignId)
    {
        $response = $this->mailChimp->post("campaigns/{$campaignId}/actions/send");

        if (!$this->lastActionSucceeded()) {
            return false;
        }

        return $response;
    }
}