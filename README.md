# Documentation Of Commodity

### About

-   Filament (v3) Admin panel with Raw, Receipt, Price, User, Order and many other resources to manage the commodity system
-   REST API for all the resources, Validation Requests, Services, Controllers, Traits, Policies and etc.
-   Used 3rd party libraries like: spatie/larave-activitylog, spatie/laravel-permission, spatie/laravel-query-builder and livewire components

### Server Requirements

1. PHP (ver >= 8.2)
2. Composer (ver >= 2.2.0)
3. Git
4. MySQL (ver >= 8)

### Installation and Configuration

1. `git clone https://github.com/CommodityApp/backend` - clone the project

2. `$ cp .env.example .env` - copy .env.example to .env file inside root folder

3. `$ php artisan key:generate` - generate key.

4. `$ composer install` - installing composer packages.

5. Create a database in mysql and update DB credentials in .env

6. (Optional for Filament) Add these two credentials to .env

```
ADMIN_EMAIL='test@mail.ru'
ADMIN_PASSWORD='12345678'
```

### Quick Usage

`$ php artisan migrate --seed` - migrates all tables with dump data

You can now run server and go to {url}/admin
