# JobBoard (Laravel Project)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8-blue)
![License](https://img.shields.io/badge/license-MIT-green)

---

# 🇩🇪 Deutsch

## Beschreibung

Diese Webanwendung ist eine Jobbörse zur Verwaltung und Darstellung von Stellenanzeigen.

Die Anwendung kann **öffentlich genutzt werden (ohne Login)** und bietet zusätzlich ein **rollenbasiertes System** für erweiterte Funktionen.

---

## Key Features

* Rollenbasiertes Zugriffssystem (Guest, Visitor, User, Admin)
* CRUD-Funktionalität für Jobanzeigen
* Admin-Verwaltung für Firmen und Kategorien
* Filter nach Firma und Kategorie
* Pagination mit Zustandserhalt
* Saubere und übersichtliche Benutzeroberfläche

---

## Demo

Dieses Projekt ist für lokale Entwicklung gedacht.
Screenshots zeigen die wichtigsten Funktionen.

---

## Rollenmodell

### Gast (nicht eingeloggt)

* Jobanzeigen ansehen
* Filter nach Firma und Kategorie nutzen

### Visitor (eingeloggt)

* gleiche Funktionen wie Gast
* Grundlage für zukünftige Features (z. B. gespeicherte Filter)

### User

* eigene Jobanzeigen erstellen
* eigene Jobanzeigen bearbeiten und löschen

### Admin

* vollständige Kontrolle über alle Jobanzeigen
* Verwaltung von:

    * Firmen (Companies)
    * Kategorien (Categories)

---

## Funktionen

### Jobanzeigen

* Übersicht aller Jobanzeigen
* Detailansicht einzelner Jobs
* Erstellung, Bearbeitung und Löschung (rollenabhängig)

### Benutzerrollen & Rechte

* Gast: nur Ansicht der Inhalte
* Visitor (eingeloggt): gleiche Rechte wie Gast
* User: eigene Jobs erstellen, bearbeiten und löschen
* Admin: vollständige Kontrolle über alle Inhalte

### Firmen & Kategorien (Admin)

* Verwaltung von Firmen (Companies)
* Verwaltung von Kategorien (Categories)
* Löschung nur möglich, wenn keine abhängigen Jobs existieren

### Filter & Suche

* Filter nach Firma
* Filter nach Kategorie
* Kombination mehrerer Filter möglich
* Filter bleiben bei Pagination erhalten

### Benutzerfreundlichkeit

* Pagination für große Datenmengen
* Rücksprung zur vorherigen Seite nach Aktionen
* Wiederherstellung der Scroll-Position

### Performance

* Caching der Jobliste zur Reduzierung von Datenbankabfragen

### Persönliche Funktionen

* „Meine Jobs“: Übersicht aller eigenen Jobanzeigen für eingeloggte User


### Jobanzeigen

* Übersicht aller Jobs
* Detailansicht
* Erstellung, Bearbeitung und Löschung (rollenabhängig)

### Firmen (Admin)

* Firmen anlegen, bearbeiten und löschen
* Löschung nur möglich, wenn keine Jobs zugeordnet sind

### Kategorien (Admin)

* Kategorien anlegen, bearbeiten und löschen

### Filter

* Filter nach:

    * Firma
    * Kategorie
* Filter bleiben bei Pagination erhalten

### Benutzerfreundlichkeit

* Pagination für große Datenmengen
* Rücksprung zur vorherigen Seite nach Aktionen
* Wiederherstellung der Scroll-Position

---

## Technologien

* PHP
* Laravel Framework
* Blade Templates
* MySQL / MariaDB
* HTML / CSS

---

## Datenbank

Das Projekt wurde mit einer relationalen Datenbank entwickelt und getestet.

### Verwendet:

* MySQL / MariaDB

### Warum diese Datenbank?

* weit verbreitet und gut dokumentiert
* optimale Integration mit Laravel
* ideal für relationale Daten (Jobs, Firmen, Kategorien, Benutzer)
* einfache lokale Einrichtung

### Konfiguration (.env)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_app
DB_USERNAME=root
DB_PASSWORD=

Migration:

php artisan migrate

Seeder:

php artisan db:seed

---

## Installation

git clone https://github.com/AndrePflegel/job-app.git
cd job-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve

---

## Test-Accounts

| Rolle   | E-Mail                                    | Passwort |
| ------- | ----------------------------------------- | -------- |
| Admin   | [admin@test.de](mailto:admin@test.de)     | password |
| User    | [user@test.de](mailto:user@test.de)       | password |
| Visitor | [visitor@test.de](mailto:visitor@test.de) | password |

---

## Sicherheit

* Passwörter werden sicher gehasht gespeichert
* Rollenbasierte Zugriffskontrolle
* sensible Dateien (.env, storage, vendor) ausgeschlossen

---

## Screenshots

### Jobübersicht

Übersicht aller Jobanzeigen mit Filter nach Firma und Kategorie.
![Job Overview](docs/screenshots/job-list.png)

### Jobdetails

Detailansicht einer einzelnen Jobanzeige.
![Job Detail](docs/screenshots/job-detail.png)

### Job erstellen

Formular zur Erstellung einer neuen Jobanzeige.
![Create Job](docs/screenshots/job-create.png)

### Admin – Firmen

Verwaltung von Firmen (CRUD).
![Admin Companies](docs/screenshots/admin-companies.png)

### Admin – Kategorien

Verwaltung von Kategorien (CRUD).
![Admin Categories](docs/screenshots/admin-categories.png)

---

## Zukünftige Erweiterungen

* Favoritenfunktion für Jobs
* Erweiterte Suche (Keywords, Gehalt)
* API-Anbindung
* E-Mail-Benachrichtigungen
* Verbesserte UI/UX

---

# 🇬🇧 English

## Description

This web application is a job board for managing and displaying job listings.

The application can be used **publicly (without login)** and also provides a **role-based system** for extended functionality.

---

## Key Features

* Role-based access control (Guest, Visitor, User, Admin)
* CRUD operations for job listings
* Admin management for companies and categories
* Filtering by company and category
* Pagination with state persistence
* Clean and structured UI

---

## Demo

This project is intended for local development.
Screenshots demonstrate the main functionality.

---

## Roles

### Guest (not logged in)

* view job listings
* use filters

### Visitor (logged in)

* same as guest
* base for future features

### User

* create own jobs
* edit and delete own jobs

### Admin

* full control over all jobs
* manage:

    * companies
    * categories

---

## Features

* Job overview & detail page
* Create / edit / delete jobs
* Admin CRUD for companies & categories
* Filtering system
* Pagination with state handling
* 
### Performance
* Query caching for job listings

### Personal Features
* "My Jobs" dashboard for managing own listings

---

## Technologies

* PHP
* Laravel
* Blade
* MySQL / MariaDB
* HTML / CSS

---

## Database

The project uses a relational database.

### Used:

* MySQL / MariaDB

### Setup

Configured via .env file.

Run:

php artisan migrate
php artisan db:seed

---

## Installation

git clone https://github.com/AndrePflegel/job-app.git
cd job-app
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve

---

## Test Accounts

| Role    | Email                                     | Password |
| ------- | ----------------------------------------- | -------- |
| Admin   | [admin@test.de](mailto:admin@test.de)     | password |
| User    | [user@test.de](mailto:user@test.de)       | password |
| Visitor | [visitor@test.de](mailto:visitor@test.de) | password |

---

## Security

* passwords are hashed
* role-based access control
* sensitive files excluded

---

## Screenshots

### Job Overview

![Job Overview](docs/screenshots/job-list.png)

### Job Detail

![Job Detail](docs/screenshots/job-detail.png)

### Create Job

![Create Job](docs/screenshots/job-create.png)

### Admin Companies

![Admin Companies](docs/screenshots/admin-companies.png)

### Admin Categories

![Admin Categories](docs/screenshots/admin-categories.png)

---

## Future Improvements

* Save favorite jobs
* Advanced search
* API integration
* Email notifications
* UI improvements

---

## Author

Andre Pflegel

---

## Laravel

https://laravel.com
