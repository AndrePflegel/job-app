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

## Aktueller Entwicklungsstand

- Rollenmodell für Benutzer vorbereitet (`admin`, `user`)
- `role`-Spalte in der Benutzerverwaltung vorhanden
- Admin-Testnutzer im Seeder angelegt
- User-Modell um Rollen-Hilfsmethoden erweitert

## Authentifizierung

Laravel Breeze wurde als Grundlage für die Authentifizierung eingebunden.

Der aktuelle Stand:
- Login- und Registrierungslogik wurde generiert
- Migrationen sind vorhanden
- Frontend-Build über Node.js / npm wird lokal eingerichtet

Hinweis:
Die Standard-Registrierung von Breeze wird im weiteren Verlauf noch an das Firmenkonzept angepasst.

## Frontend-Integration

Nach der Einbindung von Laravel Breeze wurde das bestehende Blade-Layout wieder an die Job-App angepasst.

Aktueller Stand:
- öffentliche Jobübersicht als Startseite
- Navigation für Gäste und eingeloggte Benutzer getrennt
- bestehende Job-Views optisch wieder an das Projektlayout angebunden

## Benutzerfreundlichkeit

Die Anwendung merkt sich beim Navigieren aus der Jobliste:

- aktuelle Seite (Pagination)
- Scroll-Position

Beim Zurückkehren zur Übersicht wird die vorherige Position wiederhergestellt,
sodass der Nutzer direkt weiterarbeiten kann.

## Admin-Verwaltung

Admins können zusätzlich Stammdaten verwalten:

- Firmen anlegen, bearbeiten und löschen
- Firmen können nur gelöscht werden, wenn keine Jobs mehr darauf verweisen

Firmen und Kategorien bleiben für alle Rollen als Anzeige- und Filterwerte nutzbar.

## Filterfunktion

Die öffentliche Jobübersicht kann nach folgenden Kriterien gefiltert werden:

- Firma
- Kategorie

Die Filter sind für alle Rollen nutzbar.
Die Auswahl bleibt bei Pagination erhalten.

## Testdaten

Für die lokale Entwicklung werden folgende Test-Accounts angelegt:

- admin@test.de (Admin)
- user@test.de (User)
- visitor@test.de (Visitor)

Passwort für alle: password

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
