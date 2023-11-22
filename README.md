## F&MD - Leads

![Área Administrativa](https://github.com/agenciafmd/admix-leads/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-leads.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-leads)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Keep all your leads safe

## Installation

```bash
composer require agenciafmd/admix-leads:v10.x-dev
```

Run the migrations

```bash
php artisan migrate
```

If you want to use the seeder, add on your `database/seeders/DatabaseSeeder.php`

```php
use Agenciafmd\Leads\Database\Seeders\LeadTableSeeder;

$this->call(LeadTableSeeder::class);
```

## Usage

If you are using the `agenciafmd/admix-postal`, all leads will be saved, without any configuration.

If not, you can use the `Agenciafmd\Leads\Models\Lead` model to save your leads

```php
Lead::query()
    ->create([
        'source' => 'site',
        'name' => 'Irineu Martins Junior',
        'email' => 'irineu@fmd.ag',
        'phone' => '(17) 3353-2444',
        'description' => 'Conteúdo do lead',
    ]);
```
