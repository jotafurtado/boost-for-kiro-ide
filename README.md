# Boost for Kiro IDE

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![Total Downloads](https://img.shields.io/packagist/dt/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![License](https://img.shields.io/packagist/l/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)

Brings [Laravel Boost](https://github.com/laravel/boost) MCP prompts to Amazon's **Kiro IDE** as on-demand slash commands. Laravel Boost 2.4+ natively configures Kiro (MCP server, `AGENTS.md`, skills) and Kiro exposes Boost's MCP prompts in chat through its `#` context-provider menu. This optional package provides a complementary workflow by converting eligible, argument-free Boost prompts into **manual steering files** (`.kiro/steering/boost-prompt-*.md`) that become first-class `/<filename>` slash commands in Kiro 1.0 — faster and more discoverable than the `#` MCP prompt picker.

> **Kiro 1.0 migration note**
> In Kiro IDE 1.0 the legacy `Manual` / `userTriggered` Agent Hooks trigger was removed and replaced by [manual steering files](https://kiro.dev/docs/steering/#manual-inclusion). This package therefore no longer generates `.kiro/hooks/*.kiro.hook` files; it generates `.kiro/steering/*.md` files instead. The `boost:kiro-hooks` command and `auto_sync_hooks` config key are preserved for compatibility.

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

The package is discovered automatically by Laravel and adds prompt-to-hook synchronization on top of Boost's native Kiro integration.

> **Laravel Boost v2.4+ Native Support**
> Laravel Boost creates the Kiro agent, registers its MCP server, writes `AGENTS.md`, and installs skills without this package. Install this package only if you also want Boost prompts exposed as Kiro slash commands (`/boost-prompt-*`).

## Usage

For general setup and usage of Laravel Boost, please refer to the [official Laravel Boost documentation](https://github.com/laravel/boost).

## Created File Structure

After installation and running the sync, manual steering files are generated in your Laravel project:

```text
.kiro/
└── steering/
    ├── boost-prompt-laravel-code-simplifier.md
    ├── boost-prompt-upgrade-inertia-v3.md
    ├── boost-prompt-upgrade-laravel-v13.md
    └── ...
```

Each file uses `inclusion: manual` front matter, so it is invoked on demand via `/<filename>` slash commands (e.g. `/boost-prompt-laravel-code-simplifier`) or `#<filename>` references in chat. You can add these files to `.gitignore` if desired, as they can be regenerated at any time.

## Prompt-to-Steering Conversion

Kiro IDE supports Boost's MCP prompts natively in chat via the `#` picker. This package additionally converts eligible, argument-free Boost prompts into manual steering files — discoverable slash commands for upgrade guides and code-assistance prompts like "Upgrade Laravel v13" or "Laravel Code Simplifier". If you prefer Kiro's native MCP prompt picker, you do not need this package.

Steering files are synced automatically when running `boost:install` or `boost:update`. Only prompts that are relevant to your project are included (e.g., the Inertia upgrade prompt only appears if your project uses Inertia). Leftover `.kiro/hooks/boost-prompt-*.kiro.hook` files from Kiro 0.x are removed during sync so upgraded workspaces stay clean.

You can also sync steering files manually:

```bash
php artisan boost:kiro-hooks
```

### Disabling Automatic Sync

If you prefer to manage steering files manually, you can disable the automatic sync:

```php
// config/boost.php
'agents' => [
    'kiro' => [
        'auto_sync_hooks' => false,
    ],
],
```

When disabled, steering files are only synced when you explicitly run `php artisan boost:kiro-hooks`.

### Custom Steering Path

By default, steering files are written to `.kiro/steering/`. To change the output location:

```php
// config/boost.php
'agents' => [
    'kiro' => [
        'steering_path' => '.kiro/steering',
    ],
],
```

## Compatibility

This package is designed for Laravel Boost ^2.4 and converts its eligible MCP prompts into Kiro 1.0 manual steering files.

### Tested Versions

- Laravel Boost: ^2.4
- Laravel: 11.55.x, 12.x, 13.x
- PHP: 8.2, 8.3, 8.4, 8.5

> Laravel 11 is retained for legacy compatibility testing. Because that framework line is end-of-life and covered by current security advisories, Composer may block fresh Laravel 11 dependency resolution. Applications should upgrade to Laravel 12 or 13.

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
