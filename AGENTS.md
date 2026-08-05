# AGENTS.md - Symfony 7.4 Custom Bundles Project

## Project Architecture

This is a **Symfony 7.4 MicroKernel** application with modular custom bundles architecture. The project uses:

- **Framework**: Symfony 7.4 with framework-bundle, doctrine-bundle, twig
- **Database**: PostgreSQL (via Docker Compose) with Doctrine ORM 3.6+
- **Frontend**: Tailwind CSS v4.3.2 with Stimulus JS for interactivity
- **Frontend Template**: Twig with Bootstrap 5 (via asset-mapper)

### Critical Structure

```
src/                                # Main app namespace (App\)
packages/Mms7SymfonyPakieciarnia/   # Custom reusable bundles
  ├── LokalneDomoweBundle/          # Registered as all environments
  └── ArchiwistaBundle/             # Registered as all environments
config/
  ├── bundles.php                   # Registers all bundles (both Symfony & custom)
  ├── services.yaml                 # Service container config
  ├── routes.yaml                   # Route imports (uses attributes in controllers)
  └── packages/                     # Bundle-specific config (doctrine, security, etc.)
```

## Service Container & Dependency Injection

- **Autowiring**: ENABLED - inject by type hint
- **Autoconfiguration**: ENABLED - automatically registers commands, event subscribers
- **Service registration**: Auto-registering from `src/` and bundle controller directories
- **Exclusions from auto-registration**: `DependencyInjection/`, `Entity/`, `Kernel.php`

**Custom bundle controller registration** in `config/services.yaml`:
```yaml
Mms7SymfonyPakieciarnia\LokalneDomoweBundle\Controller\:
  resource: '../packages/Mms7SymfonyPakieciarnia/LokalneDomoweBundle/src/Controller/'
  tags: ['controller.service_arguments']
```

## Routing & Controllers

- **Route definition**: Use `#[Route]` attributes in controller methods (not annotations)
- **Namespace pattern**: Controllers extend `AbstractController`
- **Bundle routing**: Each custom bundle can have its own controller namespace
- **Template rendering**: Use bundle-specific Twig namespaces like `@LokalneDomowe` for LokalneDomoweBundle

**Example** (from HomeController.php):
```php
#[Route('/', name: 'app_home')]
public function index(): Response
{
    return $this->render('@LokalneDomowe/index.html.twig');
}
```

## Database & Entities

- **ORM**: Doctrine ORM 3.6+
- **Mapping**: Attributes-based (not YAML) - `#[ORM\Entity]` pattern
- **Naming strategy**: Underscore (converts camelCase to snake_case)
- **Entity location**: `src/Entity/`
- **Database URL**: Set via `DATABASE_URL` env var (check .env file)

**Migrations**: Stored in `migrations/` - run with `bin/console doctrine:migrations:migrate`

## Frontend & Assets

- **Asset mapper**: Symfony asset-mapper (not Webpack/Vite)
- **CSS**: Tailwind CSS v4.3.2 with `tw-` prefix (configured in `tailwind.config.js`)
- **JS**: Stimulus controllers via `symfony/stimulus-bundle`
- **Real-time updates**: Symfony UX Turbo (partial page replacement)
- **Build command**: `symfony tailwind:build` for CSS compilation
- **Asset path**: `/assets/` - resolved by asset-mapper

**Tailwind config** uses `tw-` prefix globally to avoid CSS conflicts:
```javascript
module.exports = {
  prefix: 'tw-',
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"]
}
```

## Development Workflows

### Database Setup
```bash
docker compose up -d              # Start PostgreSQL container
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

### Running Application
```bash
symfony server:start              # Start built-in server (watch assets automatically)
```

### Testing
```bash
bin/phpunit                       # Run all tests from tests/
bin/phpunit tests/SomeTest.php    # Run specific test
```

**Test environment**: Uses `APP_ENV=test` with separate test database (via `DBName_suffix`)

### Code Generation
```bash
bin/console make:entity           # Generate entity with attributes
bin/console make:controller       # Generate controller
bin/console make:migration        # Generate migration after entity changes
```

## Important Conventions

1. **Tab indentation** in PHP files (not spaces) - matches existing codebase
2. **Service autowiring** by type hint in constructor - dependency injection is automatic
3. **Environment variables**: Use `%env()%` in YAML config, accessed in PHP via `getenv()`
4. **Database naming**: Underscore strategy - `firstName` → `first_name` in DB
5. **Tailwind prefix**: Always use `tw-` class prefix (`tw-flex`, `tw-text-lg`, etc.)
6. **Bundle template namespace**: `@BundleName/` maps to bundle's `Resources/views/`

## External Dependencies

- **Database**: PostgreSQL 16 (via Docker Compose)
- **Node packages**: `tailwindcss`, `autoprefixer`, `postcss` (installed via npm)
- **PHP packages**: See `composer.json` - Symfony 7.4.*, Doctrine 3.*, PHPUnit 13.*

## Debugging & Profiling

- **Web Profiler**: Available at `/_profiler` (dev mode only)
- **Debug bar**: Shows at bottom of page in dev mode
- **Console debug commands**:
  ```bash
  bin/console debug:router          # List all routes
  bin/console debug:container       # List services
  bin/console debug:config doctrine # View Doctrine config
  ```

## Key Files to Understand

- `config/bundles.php` - Bundle registration order matters
- `config/services.yaml` - Service container setup (autowiring defaults)
- `src/Kernel.php` - Uses MicroKernelTrait (simple config)
- `phpunit.dist.xml` - Strict settings: failOnDeprecation, failOnNotice, failOnWarning
- `compose.yaml` - PostgreSQL service with health checks

## Common Tasks for AI Agents

### Adding a new Entity
1. Create in `src/Entity/YourEntity.php` with `#[ORM\Entity]` attributes
2. Run `bin/console make:migration`
3. Run `bin/console doctrine:migrations:migrate`

### Adding a new Route
1. Create controller in appropriate namespace (App\Controller\ or bundle's Controller\)
2. Use `#[Route]` attributes on methods
3. Routes auto-discovered and registered

### Modifying Frontend
1. Edit `.twig` files in `templates/` (main) or bundle's `Resources/views/`
2. Update Stimulus controllers in `assets/controllers/`
3. Add Tailwind classes with `tw-` prefix
4. Tailwind automatically rebuilds on file changes

### Adding a Service
1. Create class in `src/` (not in excluded dirs)
2. Use constructor dependency injection with type hints
3. Service auto-registered and auto-wired

