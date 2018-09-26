<?php

namespace App\Providers;

use App\Newsletter\Commands as Commands;
use App\Newsletter\Newsletter;
use DrewM\MailChimp\MailChimp;
use Illuminate\Support\ServiceProvider;
use Spatie\Newsletter\NewsletterListCollection;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            Commands\ImportSubscribers::class,
            Commands\SynchronizeSubscribers::class,
            Commands\CreateAndSendCampaign::class
        ]);

        $this->app->singleton(Newsletter::class, function () {
            $mailChimp = new Mailchimp(config('newsletter.apiKey'));
            $mailChimp->verify_ssl = config('newsletter.ssl', true);
            $configuredLists = NewsletterListCollection::createFromConfig(config('newsletter'));

            return new Newsletter($mailChimp, $configuredLists);
        });

        $this->app->alias(Newsletter::class, 'newsletter');
    }
}
