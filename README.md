# Integration Laravel-BX24

Packages for integration Laravel with Bitrix24

## Installation

Go to the BITRIX24 and create local application with this url's
```php
https:://your_url/integrations/index // default handler application
https:://your_url/integrations/install // install handler
```
After create application you should copy "client_id" and "client_secret" in your .env file like this:

```bash
MIND4ME_HOST=https://URL_TO_YOUR_BITRIX
MIND4ME_CLIENT_ID=local.60f43109e2342342.297444147
MIND4ME_CLIENT_SECRET=Fqplr9gyyjdY6usdfsdfmlnsdfjngGyfgfgTdeEcqEaGdix
MIND4ME_USER_LOGIN=Login
MIND4ME_USER_PASSWORD=Password
```

Then go to console, in path for your laravel project and enter this command

```bash
composer require mind4me/bx24_integration
```
In file config/app.php insert in 'providers' => [

```bash
\Mind4me\Bx24_integration\IntegrationServiceProvider::class
```

Then enter this artisan command in console

```bash
php artisan vendor:publish --provider="Mind4me\Bx24_integration\IntegrationServiceProvider"
php artisan integration:install
php artisan cache:clear
php artisan config:clear
```



## Usage
In app/Console/Kernel.php add command for integration with the time that you need for integration! When cron begin working you see result in database

```php
$schedule->command('integration:get-users')->hourly(); // for users
$schedule->command('integration:get-events')->everyFiveMinutes(); // for deals, companies, leads..
```

## License
[Mind4.me](https://mind4.me/)
