# Instrukcja publikacji pakietów (pre-release / WIP)

Ten plik zawiera gotowe kroki do wypchnięcia lokalnych pakietów na zdalne repozytoria i rejestracji na Packagist jako wersje przed‑stabilne (alpha). Plik zakłada użycie PowerShell na Windows.

UWAGI WSTĘPNE
- Pakiety są obecnie oznaczone lokalnym tagiem `v0.1.0-alpha` i mają `extra.branch-alias` ustawione na `0.1-dev`.
- Zmiana nazwy pakietu po publikacji komplikuje migrację użytkowników — upewnij się, że `name` w `composer.json` jest ostateczny.

1) Utworzenie zdalnych repozytoriów

- Stwórz repozytorium na GitHub/GitLab/Bitbucket dla każdego pakietu:
  - `mms7/lokalne-domowe-bundle`
  - `mms7/archiwista-bundle`

2) Dodanie remote i wypchnięcie zmian (PowerShell)

Przykład dla `LokalneDomoweBundle` (podmień URL na swoje):

```powershell
Push-Location 'C:\Users\mms7\PhpstormProjects\untitled\packages\Mms7SymfonyPakieciarnia\LokalneDomoweBundle'
git remote add origin https://github.com/your-org/lokalne-domowe-bundle.git
git push -u origin main
git push origin --tags
Pop-Location
```

Analogicznie dla `ArchiwistaBundle`:

```powershell
Push-Location 'C:\Users\mms7\PhpstormProjects\untitled\packages\Mms7SymfonyPakieciarnia\ArchiwistaBundle'
git remote add origin https://github.com/your-org/archiwista-bundle.git
git push -u origin main
git push origin --tags
Pop-Location
```

3) Oznaczenie release jako Pre-release na GitHub (opcjonalne)

- Na GitHub: wejdź do repo → Releases → Draft a new release → wybierz tag `v0.1.0-alpha` → zaznacz "This is a pre-release" → Publish release.

4) Rejestracja na Packagist

- Zaloguj się do https://packagist.org (konto lub organizacja).
- Kliknij "Submit Package" i podaj URL repozytorium (publiczne) lub skonfiguruj dostęp dla repo prywatnego.
- Packagist zindeksuje tagi i branch-alias. Dzięki `branch-alias` gałąź `dev-main` pojawi się jako `0.1-dev`.

5) Instalacja przed‑stabilnej wersji przez Composer

- Po rejestracji użytkownicy mogą wymagać:

```powershell
composer require mms7/lokalne-domowe-bundle:0.1.0-alpha
# lub
composer require mms7/lokalne-domowe-bundle:0.1.x-dev
```

6) Jeżeli chcesz pozostać prywatnie (nie publicznie)

- Możesz użyć GitHub Packages lub Private Packagist. Packagist publiczny wymaga publicznego repo lub konfiguracji dostępu dla prywatnego.

7) Automatyczne aktualizacje Packagist

- Na Packagist możesz skonfigurować webhook (GitHub integration) by Packagist automatycznie aktualizował wersje przy pushu.

8) Co mogę zrobić dla Ciebie teraz
- A) Wykonać push (musisz podać URL-e zdalnych repozytoriów i autoryzować połączenie (masz już ustawione SSH/HTTP)).
- B) Zarejestrować pakiety na Packagist (potrzebuję dostępu do konta Packagist lub tokena API) — albo pokażę dokładne kroki, jeśli wolisz zrobić to samodzielnie.
- C) Dodać przykładowy plik GitHub Actions w każdym pakiecie, uruchamiający testy i analizę (przygotuję PR lokalnie).

---

Jeśli chcesz, żebym wykonał push i/lub rejestrację: podaj URL-e docelowych repozytoriów (np. `https://github.com/your-org/lokalne-domowe-bundle.git`) i powiedz, czy mam użyć HTTPS (poprosi o login/hasło/token podczas push) czy SSH. Jeśli chcesz, żebym zarejestrował pakiet na Packagist, podaj token API Packagist lub wykonam kroki interaktywnie instruując Cię, co wkleić.

