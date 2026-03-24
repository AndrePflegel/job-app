# Jobbörse (Laravel Projekt)

## Beschreibung

Diese Webanwendung dient zur Verwaltung von Jobanzeigen durch interne Mitarbeiter.

Benutzer können:

* Jobanzeigen anzeigen (Übersicht & Detailansicht)
* neue Jobanzeigen erstellen
* bestehende Jobanzeigen bearbeiten
* Jobanzeigen löschen

Die Anwendung bildet ein vollständiges CRUD-System ab.

---

## Technologien

* PHP
* Laravel Framework
* Blade Templates
* MySQL / MariaDB
* HTML / CSS

---

## Funktionen (CRUD)

* **Create:** neue Jobanzeigen erstellen
* **Read:** Übersicht und Detailansicht
* **Update:** Jobanzeigen bearbeiten
* **Delete:** Jobanzeigen löschen

---

## Besonderheiten

* Pagination für große Datenmengen
* konsistentes UI (einheitliche Aktionen in allen Ansichten)
* Rücksprung-Logik (Return-Parameter), damit Nutzer nach Aktionen zur richtigen Seite zurückkehren
* relationale Datenstruktur (Jobs, Unternehmen, Kategorien, Benutzer)

---

## Installation

1. Repository klonen:

   ```
   git clone <repository-url>
   cd job-app
   ```

2. Abhängigkeiten installieren:

   ```
   composer install
   ```

3. Umgebungsdatei erstellen:

   ```
   cp .env.example .env
   ```

4. App-Key generieren:

   ```
   php artisan key:generate
   ```

5. Datenbank konfigurieren in `.env`

6. Migrationen ausführen:

   ```
   php artisan migrate
   ```

7. Optional: Testdaten einfügen:

   ```
   php artisan db:seed
   ```

8. Server starten:

   ```
   php artisan serve
   ```

---

## Projektstruktur (vereinfacht)

* `app/Models` → Datenmodelle (JobListing, Company, Category, User)
* `app/Http/Controllers` → Logik (JobListingController)
* `resources/views` → Blade Templates (UI)
* `database/migrations` → Datenbankstruktur

---

## Autor

Andre Pflegel

---

## Laravel Framework

Dieses Projekt basiert auf dem Laravel Framework.

Laravel ist ein modernes PHP-Framework für Webanwendungen und bietet:

* elegantes Routing
* Eloquent ORM für Datenbankzugriffe
* Blade Template Engine
* Migrationen und Seeding
* integrierte Sicherheitsmechanismen

Weitere Informationen:
https://laravel.com
