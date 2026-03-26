# JobBoard (Laravel Projekt)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8-blue)
![License](https://img.shields.io/badge/license-MIT-green)

---

# 🇩🇪 Deutsch

## 📌 Projektbeschreibung

Diese Anwendung ist eine webbasierte Jobbörse zur Verwaltung und Darstellung von Stellenanzeigen.

Die Plattform kann **öffentlich (ohne Login)** genutzt werden und bietet zusätzlich ein **rollenbasiertes Zugriffssystem** für interne Benutzer.

Ziel des Projekts war es, eine **strukturierte, sichere und erweiterbare Laravel-Anwendung** zu entwickeln.

---

## 🚀 Features

* Rollenbasiertes Zugriffssystem (Guest, Visitor, User, Admin)
* CRUD-Funktionalität für Jobanzeigen
* Admin-Verwaltung für Firmen und Kategorien
* Filter nach Firma und Kategorie
* Pagination mit Zustandserhalt
* „Meine Jobs“-Bereich für eingeloggte User
* Caching zur Performance-Optimierung
* Vollständige Testabdeckung mit CI (GitHub Actions)

---

## 👥 Rollenmodell

### Gast (nicht eingeloggt)

* Anzeigen von Jobanzeigen
* Nutzung von Filtern

### Visitor (eingeloggt)

* gleiche Rechte wie Gast
* Grundlage für zukünftige Features

### User

* eigene Jobs erstellen
* eigene Jobs bearbeiten und löschen

### Admin

* vollständige Kontrolle über alle Daten
* Verwaltung von:

    * Firmen (Companies)
    * Kategorien (Categories)

---

## 🧩 Funktionen im Detail

### Jobanzeigen

* Übersicht aller Jobs
* Detailansicht
* Erstellung, Bearbeitung und Löschung (rollenabhängig)

### Filter & Suche

* Filter nach Firma
* Filter nach Kategorie
* kombinierbar
* Zustand bleibt bei Pagination erhalten

### Benutzerfreundlichkeit

* Pagination bei großen Datenmengen
* Rücksprung zur vorherigen Seite nach Aktionen
* Scroll-Position bleibt erhalten

### Performance

* Caching der Jobliste zur Reduzierung von Datenbankabfragen

---

## 🛠️ Technologien

* PHP 8
* Laravel Framework
* Blade Templates
* MySQL / MariaDB
* HTML / CSS
* GitHub Actions (CI/CD)

---

## 🗄️ Datenbank

Relationale Datenbank mit folgenden Haupttabellen:

* Users
* Jobs
* Companies
* Categories

### Eigenschaften

* Beziehungen zwischen Jobs, Firmen und Kategorien
* Integritätsregeln (z. B. keine Löschung bei Abhängigkeiten)
* Nutzung von Laravel Migrations

---

## ⚙️ Installation

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

## 🧪 Tests & CI

* Automatisierte Tests mit Laravel
* GitHub Actions Pipeline
* Tests laufen auf:

    * PHP 8.2
    * PHP 8.3
    * PHP 8.4

---

## 🔐 Sicherheit

* Passwort-Hashing
* Rollenbasierte Zugriffskontrolle (Policies)
* Schutz sensibler Dateien (.env, storage, vendor)

---

## 👤 Test-Accounts

| Rolle   | E-Mail                                    | Passwort |
| ------- | ----------------------------------------- | -------- |
| Admin   | [admin@test.de](mailto:admin@test.de)     | password |
| User    | [user@test.de](mailto:user@test.de)       | password |
| Visitor | [visitor@test.de](mailto:visitor@test.de) | password |

---

## 🔮 Erweiterungsmöglichkeiten

* Favoritenfunktion
* Erweiterte Suche (Keywords)
* API-Anbindung
* E-Mail-Benachrichtigungen
* UI/UX Verbesserungen

---

# 🇬🇧 English

## 📌 Description

This project is a web-based job board application built with Laravel.

It supports both:

* public access (without login)
* role-based internal management

---

## 🚀 Features

* Role-based access control
* CRUD operations for jobs
* Admin management (companies & categories)
* Filtering system
* Pagination with state persistence
* CI pipeline with automated tests

---

## 🛠️ Tech Stack

* PHP / Laravel
* Blade Templates
* MySQL / MariaDB
* GitHub Actions

---

## ⚙️ Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

---

## 👤 Author

Andre Pflegel

---
