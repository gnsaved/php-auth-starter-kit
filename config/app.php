<?php

declare(strict_types=1);

/**
 * Application Configuration
 *
 * Fill in your database and SMTP credentials below.
 * Database: create the database and user in cPanel > MySQL Databases
 * SMTP: use your email provider's SMTP settings
 */

return [

    'name' => 'My App',
    'url'  => 'https://yourdomain.com',
    'env'  => 'production',
    'key'  => 'change-this-to-a-random-32-char-string',

    /*
    |--------------------------------------------------------------------------
    | Database (MySQL)
    |--------------------------------------------------------------------------
    | Create these in cPanel → MySQL Databases.
    | Remember to add the user to the database with ALL PRIVILEGES.
    */
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'name' => 'your_dbname',
        'user' => 'your_dbuser',
        'pass' => 'your_dbpassword',
    ],

    /*
    |--------------------------------------------------------------------------
    | SMTP Mail
    |--------------------------------------------------------------------------
    | Your outgoing mail server settings.
    | Gmail example: host=smtp.gmail.com, port=587, encryption=tls
    | Use an App Password if you have 2FA enabled on Gmail.
    */
    'smtp' => [
        'host'       => 'smtp.gmail.com',
        'port'       => 587,
        'user'       => 'you@gmail.com',
        'pass'       => 'your-app-password',
        'from_email' => 'you@gmail.com',
        'from_name'  => 'My App',
        'encryption' => 'tls',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session
    |--------------------------------------------------------------------------
    */
    'session' => [
        'lifetime' => 120,
        'secure'   => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    'rate_limit' => [
        'login'    => 5,
        'register' => 3,
        'reset'    => 3,
        'window'   => 900,
    ],

];
