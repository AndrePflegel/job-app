# JobBoard (Laravel Projekt)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8-blue)
![License](https://img.shields.io/badge/license-MIT-green)

---

## Deutsch

### Beschreibung

Diese Anwendung ist eine webbasierte Jobbörse zur Verwaltung und Darstellung von Stellenanzeigen.

Die Plattform kann öffentlich ohne Login genutzt werden und bietet zusätzlich ein rollenbasiertes Zugriffssystem für interne Benutzer.

Ziel des Projekts war die Entwicklung einer strukturierten und erweiterbaren Laravel-Anwendung.

---

### Funktionen

* Rollenbasiertes Zugriffssystem (Guest, Visitor, User, Admin)
* CRUD-Funktionalität für Jobanzeigen
* Verwaltung von Firmen und Kategorien durch Admins
* Filter nach Firma und Kategorie
* Pagination mit Zustandserhalt
* „Meine Jobs“-Bereich für eingeloggte Benutzer
* Caching zur Reduzierung von Datenbankabfragen
* Automatisierte Tests mit CI (GitHub Actions)
* Personalisierter Dashboard-Bereich für Visitor
* Speichern von Firmen und Kategorien
* Anzeige neuer passender Jobs basierend auf Interessen
* Zeitbasierte Erkennung neuer Inhalte (last_seen_at)

---

### Rollen

**Gast (nicht eingeloggt)**

* Anzeigen von Jobanzeigen
* Nutzung von Filtern

**Visitor (eingeloggt)**

* gleiche Basisrechte wie Gast
* zusätzlich:
    * persönliches Dashboard
    * Speichern von Firmen und Kategorien
    * Anzeige neuer passender Jobs

**User**

* Jobs erstellen
* Jobs bearbeiten und löschen (rollenbasiert, auch teamorientiert möglich)

**Admin**

* vollständige Kontrolle über alle Daten
* Verwaltung von Firmen und Kategorien

---

### Funktionen im Detail

**Jobanzeigen**

* Übersicht aller Jobs
* Detailansicht
* Erstellung, Bearbeitung und Löschung (rollenabhängig)

**Filter**

* Filter nach Firma
* Filter nach Kategorie
* kombinierbar
* Zustand bleibt bei Pagination erhalten

**Benutzerfreundlichkeit**

* Pagination bei großen Datenmengen
* Rücksprung zur vorherigen Seite nach Aktionen
* Scroll-Position bleibt erhalten

**Performance**

* Caching der Jobliste


**Personalisierung (Visitor)**

* Speichern von Firmen und Kategorien
* Übersicht im Dashboard
* Anzeige neuer passender Jobs
* manuelle Aktualisierung möglich
* bewusste Markierung als „gesehen“

Diese Funktion ermöglicht eine einfache, aber effektive Personalisierung der Anwendung.

* XML-Sitemap für Suchmaschinen (/sitemap.xml)
* Visuelle Sitemap zur Darstellung der Seitenstruktur (/sitemap)

---

### Screenshots

#### Job Übersicht mit Filter
![Job Übersicht](docs/screenshots/job-list.png)

#### Job Detailansicht
![Job Detail](docs/screenshots/job-detail.png)

#### Job erstellen
![Job erstellen](docs/screenshots/job-create.png)

#### Kategorienverwaltung (Admin)
![Kategorien](docs/screenshots/admin-categories.png)

#### Firmenverwaltung (Admin)
![Firmen](docs/screenshots/admin-companies.png)

---

### Technologien

* PHP 8
* Laravel
* Blade Templates
* MySQL / MariaDB
* HTML / CSS
* GitHub Actions (CI)
* SQLite (lokal für Entwicklung und Tests)

* Service-Klassen zur Auslagerung von Business-Logik (z. B. VisitorMatchingJobsService)

---

### Datenbank

Relationale Datenbank mit folgenden Tabellen:

* Users
* Jobs
* Companies
* Categories

Eigenschaften:

* Beziehungen zwischen Jobs, Firmen und Kategorien
* Firmen und Kategorien können nur gelöscht werden, wenn keine abhängigen Jobs existieren
* Umsetzung über Laravel Migrationen

Zusätzlich:

* Pivot-Tabellen für gespeicherte Firmen und Kategorien
* Zeitstempel `last_seen_at` für personalisierte Inhalte

Beziehungen:

* User ↔ Companies (gespeichert)
* User ↔ Categories (gespeichert)

---

## Datenbankmodell (aktueller Stand)

Das ursprüngliche Datenmodell wurde im Verlauf der Entwicklung erweitert.

Neu hinzugekommen:
- Pivot-Tabellen für gespeicherte Firmen und Kategorien (`company_user`, `category_user`)
- `last_seen_at` im User zur Ermittlung neuer Jobs seit dem letzten Besuch

![Aktuelles ER-Diagramm](docs/workbench_modellierung_aktuell.png)

---

### Installation

```bash
git clone https://github.com/AndrePflegel/job-app.git
cd job-app

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan serve
```

---

### Tests

* Laravel Feature Tests
* GitHub Actions Pipeline
* Tests laufen auf PHP 8.2, 8.3 und 8.4

Abgedeckte Bereiche:

* Zugriffskontrolle (Guest / Visitor / User / Admin)
* Job-Erstellung und Bearbeitung
* gespeicherte Firmen und Kategorien
* personalisierte Job-Vorschläge
* Zustandsänderungen (z. B. „als gesehen markieren“)

* Service-Tests für ausgelagerte Logik (z. B. Matching-Logik und Session-Verhalten)

---

### Sicherheit

* Passwort-Hashing
* Rollenbasierte Zugriffskontrolle
* Schutz sensibler Dateien (.env, storage, vendor)

---

### Test-Accounts

| Rolle   | E-Mail                                    | Passwort |
| ------- | ----------------------------------------- | -------- |
| Admin   | [admin@test.de](mailto:admin@test.de)     | password |
| User    | [user@test.de](mailto:user@test.de)       | password |
| Visitor | [visitor@test.de](mailto:visitor@test.de) | password |

---

### Erweiterungsmöglichkeiten

* Favoritenfunktion
* Erweiterte Suche
* API-Anbindung
* E-Mail-Benachrichtigungen
* UI-Verbesserungen
* gespeicherte Jobs (Favoriten)
* Benachrichtigungen bei neuen passenden Jobs
* individuelle Suchprofile
* Echtzeit-Updates

---

## English

### Description

This application is a web-based job board for managing and displaying job listings.

The platform can be used publicly without login and additionally provides a role-based access system for internal users.

The goal of the project was to develop a structured and extensible Laravel application.

---

### Features

* Role-based access system (Guest, Visitor, User, Admin)
* CRUD functionality for job listings
* Management of companies and categories by admins
* Filtering by company and category
* Pagination with state persistence
* “My Jobs” area for logged-in users
* Caching to reduce database queries
* Automated tests with CI (GitHub Actions)
* Personalized dashboard for visitors
* Saving companies and categories
* Display of new matching jobs based on interests
* Time-based detection of new content (`last_seen_at`)

---

### Roles

**Guest (not logged in)**

* View job listings
* Use filters

**Visitor (logged in)**

* same basic permissions as guest
* additionally:
    * personal dashboard
    * save companies and categories
    * view new matching jobs

**User**

* Create jobs
* Edit and delete jobs (role-based, optionally team-oriented)

**Admin**

* Full control over all data
* Manage companies and categories

---

### Features in Detail

**Job Listings**

* Overview of all jobs
* Detail view
* Creation, editing, and deletion (role-based)

**Filters**

* Filter by company
* Filter by category
* combinable
* state persists during pagination

**Usability**

* Pagination for large datasets
* Return to previous page after actions
* Scroll position is preserved

**Performance**

* Caching of job listings

**Personalization (Visitor)**

* Save companies and categories
* Overview in dashboard
* Display of new matching jobs
* Manual refresh possible
* Explicit marking as “seen”

This feature provides a simple but effective personalization of the application.

* XML sitemap for search engines (/sitemap.xml)
* Visual sitemap for page structure (/sitemap)

---

### Technologies

* PHP 8
* Laravel
* Blade Templates
* MySQL / MariaDB
* HTML / CSS
* GitHub Actions (CI)
* SQLite (local development and testing)

* Service classes for business logic (e.g. VisitorMatchingJobsService)

---

### Database

Relational database with the following tables:

* Users
* Jobs
* Companies
* Categories

Properties:

* Relationships between jobs, companies, and categories
* Companies and categories can only be deleted if no dependent jobs exist
* Implemented via Laravel migrations

Additionally:

* Pivot tables for saved companies and categories
* Timestamp `last_seen_at` for personalized content

Relationships:

* User ↔ Companies (saved)
* User ↔ Categories (saved)

---

## Database Model (current state)

The original data model was extended during development.

New additions:
- Pivot tables for saved companies and categories (`company_user`, `category_user`)
- `last_seen_at` in the user model to detect new jobs since the last visit

---

### Installation

git clone https://github.com/AndrePflegel/job-app.git
cd job-app

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan serve

### Tests
* Laravel Feature Tests
* GitHub Actions pipeline
* Tests run on PHP 8.2, 8.3 and 8.4

** Covered areas: **

* Access control (Guest / Visitor / User / Admin)
* Job creation and editing
* Saved companies and categories
* Personalized job suggestions
* State changes (e.g. mark as “seen”)
* Service tests for extracted logic (e.g. matching logic and session behavior)

** Security **
* Password hashing
* Role-based access control
* Protection of sensitive files (.env, storage, vendor)
 

** Test Accounts **
Role    E-Mail          Password
Admin	admin@test.de   password
User	user@test.de    password
Visitor	visitor@test.de password

---


** Possible Extensions **
* Favorites feature
* Advanced search
* API integration
* Email notifications
* UI improvements
* Saved jobs (favorites)
* Notifications for new matching jobs
* Individual search profiles
* Real-time updates

 
Author
Andre Pflegel
