<?php

return [

    /*
     * Configuration for email delivery.
     */
    'delivery' => [
        /*
        * Driver which will be used to deliver email if email
        * is allowed to send out.
        *
        * Allowed any driver as accepted by mail.driver core
        * config parameter.
        */
        'driver' => 'log',

        /*
         * List of environments which allowed to send emails.
         */
        'environments' => [
            'production',
        ],

        /*
         * List of recipients which are allowed to receive
         * emails even if environment forbids email delivery.
         */
        'recipients' => [],
    ],

    /*
     * Configuration for email logging.
     */
    'log'      => [
        /*
         * Whatever email logging should be enabled or not.
         */
        'enabled' => true,

        /*
         * Storage to use for email log.
         * Possible values are 'database', 'filesystem'.
         */
        'storage' => 'database',
    ],

    /*
     * Storage configuration.
     */
    'storage' => [
        /*
         * Configuration for which database table should
         * be used for email logging.
         */
        'database' => [
            'table' => 'mailman_messages',
        ],

        /*
         * Configuration for where to store logged email messages.
         * Relative to the storage_path().
         */
        'filesystem' => [
            'path' => 'mailman',
        ],
    ],
];
