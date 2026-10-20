# SPST Erasmus

Webová aplikace pro správu výběrového řízení Erasmus+ na SPŠ Třebíč.
Backend je Laravel 13, databáze MySQL, šablony Blade, přihlášení Laravel Breeze.

Kód aplikace je ve složce `tmp-laravel`.

## Požadavky

- PHP 8.3+
- Composer
- Node.js a npm
- MySQL 8+

## První spuštění

```bash
cd tmp-laravel
composer install
npm install
cp .env.example .env
php artisan key:generate