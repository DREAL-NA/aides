<?php

namespace Tests;

use DrewM\MailChimp\MailChimp;
use Mockery;
use Spatie\Newsletter\Newsletter;
use Spatie\Newsletter\NewsletterListCollection;

class FakeMailchimpGateway
{
    /** @var Mockery\Mock */
    protected $mailChimp;

    /** @var \Spatie\Newsletter\Newsletter */
    protected $newsletter;

    public function __construct()
    {
        $this->mailChimp = Mockery::mock(MailChimp::class);

        $this->mailChimp->shouldReceive('success')->andReturn(true);

        $newsletterLists = NewsletterListCollection::createFromConfig(
            [
                'lists' => [
                    'list1' => ['id' => 123],
                    'list2' => ['id' => 456],
                ],
                'defaultListName' => 'list1',
            ]
        );

        $this->newsletter = new Newsletter($this->mailChimp, $newsletterLists);
    }

    public function subscribe($email, $mergeFields = [], $listName = '', $options = [])
    {
        $url = 'lists/123/members';

        $this->mailChimp->shouldReceive('post')->withArgs([
            $url,
            [
                'email_address' => $email,
                'status' => 'subscribed',
                'email_type' => 'html',
                'merge_fields' => [
                    'FNAME' => empty($mergeFields['FNAME']) ? '' : $mergeFields['FNAME'],
                    'LNAME' => empty($mergeFields['LNAME']) ? '' : $mergeFields['LNAME']
                ],
            ],
        ]);

        $this->newsletter->subscribe($email, $mergeFields, $listName, $options);
    }

    public function subscribeOrUpdate($email, $mergeFields = [], $listName = '', $options = [])
    {
        $url = 'lists/123/members';
        $subscriberHash = 'abc123';

        $this->mailChimp->shouldReceive('subscriberHash')
                        ->once()
                        ->withArgs([$email])
                        ->andReturn($subscriberHash);

        $this->mailChimp->shouldReceive('put')->withArgs([
            "{$url}/{$subscriberHash}",
            [
                'email_address' => $email,
                'status' => 'subscribed',
                'email_type' => 'html',
                'merge_fields' => [
                    'FNAME' => empty($mergeFields['FNAME']) ? '' : $mergeFields['FNAME'],
                    'LNAME' => empty($mergeFields['LNAME']) ? '' : $mergeFields['LNAME']
                ],
            ],
        ]);

        $this->newsletter->subscribeOrUpdate($email, $mergeFields, $listName, $options);
    }

    public function unsubscribe($email, $listName = '')
    {
        $url = 'lists/123/members';

        $subscriberHash = 'abc123';
        $this->mailChimp->shouldReceive('subscriberHash')
                        ->once()
                        ->withArgs([$email])
                        ->andReturn($subscriberHash);

        $this->mailChimp
            ->shouldReceive('patch')
            ->once()
            ->withArgs([
                "{$url}/{$subscriberHash}",
                [
                    'status' => 'unsubscribed',
                ],
            ]);

        $this->newsletter->unsubscribe($email, $listName);
    }

    public function getMembers($listName = '', $parameters = [])
    {
        return json_decode(file_get_contents(__DIR__ . '/Fakes/mailchimpMembers.json'), true);

        $this->mailChimp
            ->shouldReceive('get')
            ->once()
            ->withArgs(['lists/123/members', []]);

        return $this->newsletter->getMembers($listName, $parameters);
    }

    public function lastActionSucceeded()
    {
        return true;
    }

    public function getLastError()
    {
        return 'This is a fake Mailchimp error.';
    }

    public function getApi()
    {
        return $this->mailChimp;
    }

    public function createCampaign(
        string $fromName,
        string $replyTo,
        string $subject,
        string $html = '',
        string $listName = '',
        array $options = [],
        array $contentOptions = []
    ) {
        return ['id' => 'myCustomId'];
    }

    public function send($campaignId)
    {
        $this->mailChimp
            ->shouldReceive('post')
            ->withArgs(["campaigns/{$campaignId}/actions/send"]);

        $this->mailChimp->post("campaigns/{$campaignId}/actions/send");
    }
}