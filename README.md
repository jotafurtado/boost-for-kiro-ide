# Boost for Kiro IDE

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![Total Downloads](https://img.shields.io/packagist/dt/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)
[![License](https://img.shields.io/packagist/l/jcf/boost-for-kiro-ide.svg?style=flat-square)](https://packagist.org/packages/jcf/boost-for-kiro-ide)

Adiciona suporte ao **Kiro IDE** da Amazon no [Laravel Boost](https://github.com/laravel/boost), integrando o servidor MCP (Model Context Protocol) e diretrizes de IA especificamente projetadas para o Kiro.

## Sobre o Kiro IDE

O Kiro IDE é um ambiente de desenvolvimento integrado alimentado por IA da Amazon que suporta o Model Context Protocol (MCP), permitindo que agentes de IA interajam com seu projeto Laravel de forma contextualizada e eficiente.

## Sobre o Laravel Boost

Laravel Boost acelera o desenvolvimento assistido por IA fornecendo o contexto e estrutura essenciais que a IA precisa para gerar código Laravel de alta qualidade e específico do framework. Este pacote estende o Boost para funcionar perfeitamente com o Kiro IDE.

## Requisitos

- PHP 8.1 ou superior
- Laravel 10.x, 11.x ou 12.x
- [Laravel Boost](https://github.com/laravel/boost) ^1.0
- Kiro IDE instalado no seu sistema

## Instalação

Você pode instalar o pacote via Composer:

```bash
composer require jcf/boost-for-kiro-ide --dev
```

O pacote registra automaticamente o Kiro IDE com o Laravel Boost através do auto-discovery do Laravel.

## Uso

### 1. Instalar Laravel Boost (se ainda não instalado)

Se você ainda não tem o Laravel Boost instalado, instale-o primeiro:

```bash
composer require laravel/boost --dev
php artisan boost:install
```

### 2. Configurar o Kiro IDE

Ao executar o comando `php artisan boost:install`, o Kiro IDE aparecerá como uma opção disponível. Selecione-o para configurar automaticamente:

- **Configuração MCP**: Criada em `.kiro/settings/mcp.json`
- **Diretrizes de IA**: Criadas em `.kiro/steering/laravel-boost.md`

### 3. Ativar no Kiro IDE

No Kiro IDE:

1. Abra a paleta de comandos (`Cmd+Shift+P` ou `Ctrl+Shift+P`)
2. Procure por "MCP: Reconnect All Servers" e pressione `Enter`
3. O servidor MCP `laravel-boost` será automaticamente detectado e conectado

O Kiro carrega automaticamente as diretrizes de IA de `.kiro/steering/laravel-boost.md` para fornecer assistência contextualizada para sua aplicação Laravel.

## Estrutura de Arquivos Criados

Após a instalação, os seguintes arquivos serão criados no seu projeto Laravel:

```
.kiro/
├── settings/
│   └── mcp.json           # Configuração do servidor MCP
└── steering/
    └── laravel-boost.md   # Diretrizes de IA para o Kiro
```

Você pode adicionar esses arquivos ao `.gitignore` se desejar, pois eles podem ser regenerados executando `php artisan boost:install` ou `php artisan boost:update`.

## Ferramentas MCP Disponíveis

Após a instalação, o Kiro terá acesso a todas as ferramentas MCP do Laravel Boost, incluindo:

- **Application Info**: Informações sobre PHP, Laravel, pacotes e modelos Eloquent
- **Browser Logs**: Logs e erros do navegador
- **Database Connections**: Inspeção de conexões de banco de dados
- **Database Query**: Execução de queries no banco de dados
- **Database Schema**: Leitura do schema do banco de dados
- **Get Config**: Obter valores de configuração
- **Last Error**: Ler o último erro dos logs
- **List Artisan Commands**: Listar comandos Artisan disponíveis
- **List Routes**: Listar rotas da aplicação
- **Read Log Entries**: Ler entradas de log
- **Search Docs**: Buscar documentação do Laravel
- **Tinker**: Executar código arbitrário no contexto da aplicação
- E muito mais...

## Atualização das Diretrizes

Para manter suas diretrizes de IA atualizadas com as últimas versões dos pacotes do ecossistema Laravel instalados, execute:

```bash
php artisan boost:update
```

Você também pode automatizar este processo adicionando-o aos scripts do Composer:

```json
{
  "scripts": {
    "post-update-cmd": ["@php artisan boost:update --ansi"]
  }
}
```

## Compatibilidade

Este pacote é projetado para ser compatível com todas as versões do Laravel Boost ^1.0. Ele usa os hooks de extensão fornecidos pelo Laravel Boost para registrar o ambiente de código do Kiro.

### Versões Testadas

- Laravel Boost: ^1.0
- Laravel: 10.x, 11.x, 12.x
- PHP: 8.1, 8.2, 8.3

## Detecção Automática

O pacote detecta automaticamente instalações do Kiro IDE nos seguintes locais:

**macOS:**

- `/Applications/Kiro.app`

**Linux:**

- `/opt/kiro`
- `/usr/local/bin/kiro`
- `~/.local/bin/kiro`

**Windows:**

- `%ProgramFiles%\Kiro`
- `%LOCALAPPDATA%\Programs\Kiro`

**Detecção em Projetos:**

- Presença do diretório `.kiro` no projeto

## Testes

Execute os testes com:

```bash
composer test
```

Para executar apenas análise estática:

```bash
composer lint
```

## Changelog

Por favor, veja [CHANGELOG](CHANGELOG.md) para mais informações sobre o que mudou recentemente.

## Contribuindo

Contribuições são bem-vindas! Por favor, sinta-se à vontade para enviar um Pull Request.

## Segurança

Se você descobrir alguma questão relacionada à segurança, por favor envie um e-mail para jotacfurtado@gmail.com ao invés de usar o issue tracker.

## Créditos

- [João C. Furtado](https://github.com/jotafurtado)
- [Laravel Boost](https://github.com/laravel/boost) - Pacote original que este estende
- [Todos os Contribuidores](../../contributors)

## Licença

A licença MIT (MIT). Por favor, veja o [Arquivo de Licença](LICENSE) para mais informações.

## Links Relacionados

- [Laravel Boost](https://github.com/laravel/boost) - Pacote principal
- [Model Context Protocol](https://modelcontextprotocol.io/) - Especificação MCP
- [Laravel Documentation](https://laravel.com/docs) - Documentação oficial do Laravel
- [Kiro IDE](https://aws.amazon.com/kiro) - Site oficial do Kiro IDE
