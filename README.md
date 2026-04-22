# Boost for Kiro IDE

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![Total Downloads](https://img.shields.io/packagist/dt/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![License](https://img.shields.io/packagist/l/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)

Empowers Amazon's **Kiro IDE** within [Laravel Boost](https://github.com/laravel/boost). While Laravel Boost 2.4+ now natively configures Kiro IDE, **this package remains indispensable**. Kiro IDE does not currently understand MCP Prompts natively. This package acts as your "Hook Superpower," seamlessly translating all rich Boost MCP recommendations and commands into interactive **Agent Hooks** (`.kiro/hooks/*.hook`), enabling you to trigger them visually right from the Kiro interface.

## About Kiro IDE

Kiro IDE is an AI-powered integrated development environment from Amazon that supports the Model Context Protocol (MCP), allowing AI agents to interact with your Laravel project in a contextualized and efficient manner.

## About Laravel Boost

Laravel Boost accelerates AI-assisted development by providing the essential context and structure that AI needs to generate high-quality, framework-specific Laravel code. This package extends Boost to work seamlessly with Kiro IDE.

## Requirements

- PHP 8.2 or higher
- Laravel 11.x, 12.x or 13.x
- [Laravel Boost](https://github.com/laravel/boost) ^2.4
- Kiro IDE installed on your system

## Installation

You can install the package via Composer:

```bash
composer require jcf/boost-for-kiro-ide --dev
```

The package automatically registers Kiro IDE with Laravel Boost through Laravel's auto-discovery.

> **✨ Laravel Boost v2.4+ Native Support**  
> Starting with version 2.4, Laravel Boost creates the Kiro Agent and registers MCP capabilities out-of-the-box. The industry standard `AGENTS.md` file is now used natively, replacing the old `.kiro/steering/laravel-boost.md`. This is fantastic because it centralizes all AI guidelines in a single, unified file, cutting down on token waste and improving context retention. This package builds exactly on top of that official integration, focusing entirely on expanding your Hook arsenal.

## Usage

For general setup and usage of Laravel Boost, please refer to the [official Laravel Boost documentation](https://github.com/laravel/boost).

## Created File Structure

After installation and running the sync, hooks will be generated in your Laravel project:

```text
.kiro/
└── hooks/
    ├── boost-prompt-laravel-code-simplifier.kiro.hook
    ├── boost-prompt-upgrade-inertia-v3.kiro.hook
    ├── boost-prompt-upgrade-laravel-v13.kiro.hook
    └── ...
```

You can add these files to `.gitignore` if desired, as they can be regenerated at any time.

## Prompt-to-Hook Conversion

Kiro IDE does not support MCP prompts. To make Boost's prompts available in Kiro, this package converts them into agent hooks — user-triggered actions that appear in Kiro's **Agent Hooks** panel.

This gives Kiro users access to the same upgrade guides and code assistance prompts that other MCP clients get natively, like "Upgrade Laravel v13" or "Laravel Code Simplifier".

Hooks are synced automatically when running `boost:install` or `boost:update`. Only prompts that are relevant to your project are included (e.g., the Inertia upgrade prompt only appears if your project uses Inertia).

You can also sync hooks manually:

```bash
php artisan boost:kiro-hooks
```

### Disabling Automatic Sync

If you prefer to manage hooks manually, you can disable the automatic sync:

```php
// config/boost.php
'agents' => [
    'kiro' => [
        'auto_sync_hooks' => false,
    ],
],
```

When disabled, hooks are only synced when you explicitly run `php artisan boost:kiro-hooks`.

## Compatibility

This package is designed to be compatible with all versions of Laravel Boost ^2.0. It uses the extension hooks provided by Laravel Boost to register the Kiro code environment.

### Tested Versions

- Laravel Boost: ^2.4
- Laravel: 11.x, 12.x, 13.x
- PHP: 8.2, 8.3, 8.4

## Testing

Run the tests with:

```bash
composer test
```

To run only static analysis:

```bash
composer lint
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## Security

If you discover any security related issues, please email jotacfurtado@gmail.com instead of using the issue tracker.

## Credits

- [João C. Furtado](https://github.com/jotafurtado)
- [Laravel Boost](https://github.com/laravel/boost) - Original package that this extends
- Huge thanks to [Karel Faille (@shaffe-fr)](https://github.com/shaffe-fr) for submitting PR-7, bringing the incredible Prompt-to-Hook translation feature to life.
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Related Links

- [Laravel Boost](https://github.com/laravel/boost) - Main package
- [Model Context Protocol](https://modelcontextprotocol.io/) - MCP specification
- [Laravel Documentation](https://laravel.com/docs) - Official Laravel documentation
- [Kiro IDE](https://aws.amazon.com/kiro) - Official Kiro IDE website
