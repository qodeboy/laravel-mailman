[![Travis](https://img.shields.io/travis/qodeboy/laravel-mailman.svg?maxAge=2592000?style=flat-square)](https://travis-ci.org/qodeboy/laravel-mailman)
[![Packagist](https://img.shields.io/packagist/l/qodeboy/laravel-mailman.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/qodeboy/laravel-mailman)
[![Packagist](https://img.shields.io/packagist/v/qodeboy/laravel-mailman.svg?maxAge=2592000?style=flat-square)](https://packagist.org/packages/qodeboy/laravel-mailman)
[![StyleCI](https://styleci.io/repos/56073823/shield)](https://styleci.io/repos/56073823)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/qodeboy/laravel-mailman.svg?maxAge=2592000)](https://scrutinizer-ci.com/g/qodeboy/laravel-mailman/)

"Mailman" mail driver for Laravel 5.2+ which allows email delivery to be restricted by environment but allowed for specific recipients.

## Installation

Begin by installing the package through Composer. Run the following command in your terminal:

```bash
composer require qodeboy/laravel-mailman "5.2.*"
```

Once composer is done, add the package service provider in the providers array in `config/app.php`:

```php
Qodeboy\Mailman\MailManServiceProvider::class,
```

Then publish the config file:

```bash
php artisan vendor:publish --provider="Qodeboy\Mailman\MailmanServiceProvider"
```

Change `MAIL_DRIVER` to `mailman` in your `.env` file:

```
MAIL_DRIVER=mailman
```

Finally, run migrations:

```bash
php artisan migrate
```

## How it works

For every email sent this package will:

* Check if current application environment is allowed to send emails.
* If environment if denied, check if all of recipients are in the exception list.
* Passe email through only if environment is allowed to send emails, or all of the recipients are in exception list.
* Log email to database or filesystem (if configured to do so) along with it's status (allowed/denied).
* Send email through configured "delivery" driver.

## Configuration

### Delivery driver

Delivery driver used to send emails which passed all checks is configured in `mailman.delivery.driver` option:

```php
/*
 * Driver which will be used to deliver email if email
 * is allowed to send out.
 *
 * Allowed any driver as accepted by mail.driver core
 * config parameter.
 */
'driver' => 'log',
```

You can use any driver name here (except of mailman) which Laravel is aware of.

### Allowed environments

To configure which environments are allowed to send emails, check `mailman.delivery.environments` option:

```php
/*
 * List of environments which allowed to send emails.
 */
'environments' => [
    'production'
],
```

Each environment added here is **allowed** to send emails.

### Allowed recipients

If you want to lock down environment but still allow some recipients to receive emails, add those addresses to `mailman.delivery.recipients` list:

```php
/*
 * List of recipients which are allowed to receive
 * emails even if environment forbids email delivery.
 */
'recipients' => [],
```

### Logging

By default this package will log every email which tries to go through into database. This is configured in `mailman.log` option:

```php
/*
 * Configuration for email logging.
 */
'log' => [
    
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
```

If you want to change log storage to simple filesystem log, change `mailman.log.storage` option to `filesystem`. Filesystem path where to store logs is explained below.
If you want to completely turn off logging, just change `mailman.delivery.enabled` to `false`.

### Logging storage

To customize where each logging driver is storing email logs, check `mailman.storage` option:
  
```php
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
        'path' => 'mailman'
    ]
],
```
