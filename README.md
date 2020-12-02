## F&MD - Leads

![Área Administrativa](https://github.com/agenciafmd/admix-leads/raw/master/docs/screenshot.png "Área Administrativa")

[![Downloads](https://img.shields.io/packagist/dt/agenciafmd/admix-leads.svg?style=flat-square)](https://packagist.org/packages/agenciafmd/admix-leads)
[![Licença](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

- Armazena os dados dos disparos feitos pelo [admix-postal](https://github.com/agenciafmd/admix-postal)

## Instalação

```
composer require agenciafmd/admix-leads:dev-master
```

Execute a migração

```
php artisan migrate
```

Se precisar do seed, faça a publicação

```
php artisan vendor:publish --tag=admix-leads:seeds
```

**não esqueça do `composer dumpautoload`**

O pacote escutará os disparos do admix-postal e guardará os envios.

Caso precise guardar os dados manualmente.

```
Lead::create([
    'source' => 'contato',
    'name' => $data['name'],
    'email' => $data['email'],
    'phone' => $data['phone'],
    'description' => 'Mensagem: ' . $data['message'],
]);
```

Onde o `source` funciona como o "tipo" de formulário, permitindo o filtro do painel