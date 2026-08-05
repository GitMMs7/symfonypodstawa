Instrukcje pracy z pakietami (lokalnie i publikacja)

Cel:
- Pozostawić główne repozytorium działające tak, jakby pakiety nie istniały.
- Umożliwić wygodny lokalny development pakietów (path repository) bez publikacji.
- Przygotować instrukcję migracji do publikacji na Packagist / zdalnego VCS.

Checklist (co zrobić teraz)
- [x] Root nie zawiera PSR-4 mapowania pakietów w `composer.json`.
- [x] Główna rejestracja bundli jest warunkowa (`config/bundles.php`).
- [x] Główne `config/routes.yaml` nie importuje bezpośrednio plików z `packages/`.
- [ ] Jeśli chcesz testować lokalnie — dodać `repositories: path` w root `composer.json` tymczasowo.
- [ ] Kiedy nazwy pakietów są stabilne — utworzyć zdalne repozytoria i opublikować na Packagist.

Szybkie instrukcje — opcje pracy

1) Rozwój lokalny (rekomendowane gdy nazwy / API mogą się zmieniać)
- Nie publikuj pakietów jeszcze.
- W root możesz tymczasowo dodać `path` repositories do `composer.json` (opcja symlink jest wygodna):

```json
"repositories": [
  {
    "type": "path",
    "url": "packages/Mms7SymfonyPakieciarnia/LokalneDomoweBundle",
    "options": {"symlink": true}
  },
  {
    "type": "path",
    "url": "packages/Mms7SymfonyPakieciarnia/ArchiwistaBundle",
    "options": {"symlink": true}
  }
]
```

Po dodaniu wpisów uruchom w root:

```powershell
composer require mms7/lokalne-domowe-bundle:dev-master --prefer-source
composer require mms7/archiwista-bundle:dev-master --prefer-source
```

Zaleta: Composer utworzy symlink lub skopiuje pakiety do `vendor/` i autoload zacznie działać. Po ustabilizowaniu nazw/publikacji możesz usunąć `repositories` i polegać na Packagist.

2) Testowanie bez zmiany `composer.json` (ręczne ładowanie bundli)
- Możesz zostawić root tak jak jest i ręcznie skopiować lub zainstalować pakiety do `vendor/` jeśli tego potrzebujesz. To jednak jest mniej wygodne.

3) Publikacja (kiedy nazwy są stabilne)
- Utwórz zdalne repo (GitHub/GitLab) dla każdego pakietu.
- W pakiecie ustaw remote i wypchnij:

```powershell
cd packages/Mms7SymfonyPakieciarnia/LokalneDomoweBundle
git remote add origin git@github.com:twoj-org/lokalne-domowe-bundle.git
git push -u origin master
git tag v0.1.0
git push origin v0.1.0
```

- Zarejestruj pakiet w Packagist (lub skonfiguruj autouaktualnienie z GitHub).
- W root: `composer require mms7/lokalne-domowe-bundle:^0.1`.

Przykładowy przebieg migracji do Packagist (gdy nazwy i API są gotowe)
1. Zamrozić API w pakiecie (semantic versioning). 2. Wypchnąć tag release. 3. Zarejestrować w Packagist. 4. W root: `composer require mms7/packagename:^1.0`.

Uwaga o routach i configach pakietów
- Gdy pakiet zostanie zainstalowany przez Composer, pliki bundla zwykle znajdują się w `vendor/mms7/…/src/Resources/config`.
- Przykład importu (dodaj do `config/routes.yaml` po zainstalowaniu):

```yaml
lokalne_domowe_routes:
  resource: '../vendor/mms7/lokalne-domowe-bundle/src/Resources/config/routes.yaml'
  prefix: ''

archiwista_routes:
  resource: '../vendor/mms7/archiwista-bundle/src/Resources/config/routes.xml'
  prefix: ''
```

Plik przykładowy z importami routów znajduje się obok: `config/routes.packages.example.yaml` — skopiuj i dostosuj do siebie po instalacji pakietów.

Dodatkowe rekomendacje
- Dopóki nazwy pakietów nie są ostateczne: używaj `path` repo dla local development zamiast publikacji.
- Przed publikacją upewnij się że `composer.json` pakietów ma poprawne `name`, `autoload` (PSR-4) i `type: symfony-bundle`.
- Dodaj CI do pakietów (np. GitHub Actions) publikujące tag i informujące Packagist.

Jeśli chcesz, mogę teraz:
- dodać tymczasowy `composer.json` przykład z `repositories` (który później łatwo usunąć),
- dodać `config/routes.packages.example.yaml` (zrobię to teraz),
- przygotować plik `README_PACKAGES.md` w root z gotowymi komendami do skopiowania/pasted.

Powiedz które chcesz, a zrobię to automatycznie.
