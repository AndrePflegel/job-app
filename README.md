# Job App

Eine Laravel-Webanwendung zur Anzeige und Verwaltung von Jobanzeigen.

## Projektbeschreibung

In dieser Anwendung können interne Benutzer Jobanzeigen verwalten.  
Jede Jobanzeige gehört zu:

- einer Firma
- einer Kategorie
- einem internen Benutzer

Die Anwendung wurde mit Laravel, Eloquent, Migrationen, Factorys, Seedern und Blade-Views umgesetzt.

## Funktionen

- Übersicht aller Jobanzeigen
- Detailansicht einzelner Jobanzeigen
- Beziehungen zwischen Jobanzeigen, Firmen, Kategorien und Benutzern
- Seed-Daten mit Faker
- Blade-Layout für wiederverwendbare Seitenstruktur

## Verwendete Technologien

- PHP
- Laravel
- Blade
- Eloquent ORM
- MySQL / MariaDB
- Faker

## Datenmodell

Haupttabellen:

- users
- companies
- categories
- job_listings

Zusätzliche Laravel-Systemtabellen:

- jobs
- failed_jobs
- job_batches
- cache
- sessions

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
