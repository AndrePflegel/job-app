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

---

### Rollen

**Gast (nicht eingeloggt)**

* Anzeigen von Jobanzeigen
* Nutzung von Filtern

**Visitor (eingeloggt)**

* gleiche Rechte wie Gast

**User**

* eigene Jobs erstellen
* eigene Jobs bearbeiten und löschen

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

---

### Technologien

* PHP 8
* Laravel
* Blade Templates
* MySQL / MariaDB
* HTML / CSS
* GitHub Actions (CI)

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

---

## English

### Description

This project is a web-based job board application built with Laravel.

It supports public access without login as well as role-based internal management.

---

### Features

* Role-based access control
* CRUD operations for job listings
* Admin management for companies and categories
* Filtering system
* Pagination with state persistence
* CI pipeline with automated tests

---

### Tech Stack

* PHP / Laravel
* Blade Templates
* MySQL / MariaDB
* GitHub Actions

---

### Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

---

### Author

Andre Pflegel
