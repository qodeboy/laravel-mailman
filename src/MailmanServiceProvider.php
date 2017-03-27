<?php

namespace Qodeboy\Mailman;

use Illuminate\Mail\MailServiceProvider;
use Qodeboy\Mailman\Logger\MailmanDatabaseLogger;
use Qodeboy\Mailman\Logger\MailmanFilesystemLogger;
use Qodeboy\Mailman\Transport\MailmanTransport;
use Swift_Mailer;

class MailmanServiceProvider extends MailServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
          __DIR__.'/../config/mailman.php' => config_path('mailman.php'),
        ]);

        $this->publishes([
            __DIR__.'/../migrations/2016_04_12_000000_create_mailman_messages_table.php' => base_path('database/migrations/2016_04_12_000000_create_mailman_messages_table.php'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(
          __DIR__.'/../config/mailman.php', 'mailman'
        );
    }

    /**
     * Register the Swift Mailer instance.
     *
     * @return void
     */
    public function registerSwiftMailer()
    {
        if ($this->app['config']['mail.driver'] == 'mailman') {
            $this->registerMailmanSwiftMailer();
            $this->registerMailmanLogger();
        } else {
            parent::registerSwiftMailer();
        }
    }

    /**
     * Register Mailman Logger.
     */
    public function registerMailmanLogger()
    {
        $this->app->singleton('mailman.logger', function ($app) {
            $storageAdapter = $app['config']['mailman']['log']['storage'];

            if (! in_array($storageAdapter, ['database', 'filesystem'])) {
                throw new \RuntimeException("Invalid log storage adapter was supplied! Adapter \"{$storageAdapter}\" is not supported!");
            }

            switch ($storageAdapter) {
                case 'filesystem':
                    return new MailmanFilesystemLogger();

                case 'database':
                default:
                    return new MailmanDatabaseLogger();
            }
        });
    }

    /**
     * Register the Mailman Swift Mailer instance.
     *
     * @return void
     */
    protected function registerMailmanSwiftMailer()
    {
        $this->registerSwiftTransport();

        $this->app->singleton('swift.mailer', function ($app) {
            return new Swift_Mailer(
              new MailmanTransport($app)
            );
        });
    }
}
