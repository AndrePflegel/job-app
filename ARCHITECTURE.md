# Architektur der Anwendung

## Überblick

Die Anwendung basiert auf dem MVC-Pattern (Model-View-Controller), welches im Laravel Framework umgesetzt ist.

---

## Komponenten

### Model

* Repräsentiert die Datenbankstruktur
* Beispiele:

    * User
    * Job
    * Company
    * Category

---

### Model (Eloquent ORM im Detail)

Die Models basieren auf Laravel Eloquent ORM und bilden nicht nur Tabellen ab,
sondern enthalten auch Geschäftslogik und Beziehungen.

Wichtige Models:

* **User**
    * enthält Rollenlogik (`isAdmin()`, `isUser()`, `isVisitor()`)
    * verwaltet Beziehungen zu Jobs, Firmen und Kategorien
    * enthält Feld `last_seen_at` für personalisierte Inhalte

* **JobListing**
    * zentrale Entität der Anwendung
    * gehört zu:
        * Company
        * Category
        * User

* **Company**
    * hat viele JobListings
    * gehört zu vielen Usern (gespeichert)

* **Category**
    * hat viele JobListings
    * gehört zu vielen Usern (gespeichert)

---

### Beziehungen (Eloquent Relationships)

Die Anwendung nutzt verschiedene Beziehungstypen:

* **One-to-Many**
    * User → JobListings
    * Company → JobListings
    * Category → JobListings

* **Many-to-Many**
    * User ↔ Company (gespeicherte Firmen)
    * User ↔ Category (gespeicherte Kategorien)

Umgesetzt über Pivot-Tabellen:

* `company_user`
* `category_user`

Diese Beziehungen ermöglichen die Personalisierung der Anwendung.

---

### View

* Umsetzung mit Blade Templates
* Verantwortlich für Darstellung der Daten

---

### Controller

* Verarbeitet Anfragen
* Steuert die Logik zwischen Model und View

---

### Controller (Logik im Detail)

Controller enthalten neben CRUD-Logik auch:

* Rollenabhängige Logik (z. B. unterschiedliche Dashboards)
* Filter- und Suchlogik
* Matching-Logik für personalisierte Inhalte

Beispiel:

Der `DashboardController`:

* liefert unterschiedliche Daten je nach Rolle
* berechnet neue passende Jobs
* verwaltet den Referenzzeitpunkt (`last_seen_at`)

---

## Routing

* Definiert in `routes/web.php`
* Verknüpft URLs mit Controllern

---

## Authentifizierung

* Laravel Breeze
* Login / Registrierung
* Session-basierte Authentifizierung

---

## Autorisierung

* Umsetzung über Laravel Policies
* Zugriff abhängig von Benutzerrolle

---

## Datenbank

* Relationale Struktur
* Nutzung von Migrationen
* Beziehungen:

    * Job → Company
    * Job → Category
    * Job → User

---

### Datenbankstruktur (erweitert)

Zusätzlich zu den Haupttabellen existieren:

* Pivot-Tabellen für Many-to-Many Beziehungen
* Zeitbasierte Felder zur Zustandsverwaltung

Wichtige Felder:

* `job_listings.is_active`
* `users.role`
* `users.last_seen_at`

Diese ermöglichen:

* Filterung nach aktiven Jobs
* rollenbasierte Logik
* personalisierte Inhalte

---


## CI/CD

* GitHub Actions
* Automatische Tests bei jedem Push
* Mehrere PHP-Versionen


---

### Testing

Die Anwendung nutzt Laravel Feature Tests.

Abgedeckt sind unter anderem:

* Zugriffskontrolle (Policies)
* Job-Erstellung
* Admin-Funktionen
* gespeicherte Firmen und Kategorien
* Matching-Logik für neue Jobs

Tests werden automatisch über GitHub Actions ausgeführt.

---


## Rollen- und Berechtigungssystem

Die Anwendung nutzt ein rollenbasiertes Zugriffssystem mit folgenden Rollen:

* Guest (nicht eingeloggt)
* Visitor (eingeloggt, externe Nutzer)
* User (interne Mitarbeiter)
* Admin (vollständige Kontrolle)

Die Zugriffskontrolle erfolgt über:

* Laravel Policies
* zusätzliche Logik in Controllern und Views

---

## Personalisierung (Visitor Dashboard)

Für eingeloggte Besucher (Visitor) wurde ein personalisiertes Dashboard umgesetzt.

Funktionen:

* Speichern von Firmen und Kategorien (Many-to-Many Beziehungen)
* Anzeige gespeicherter Inhalte im Dashboard
* Anzeige der Anzahl aktiver Jobs pro Eintrag
* gezielte Navigation zu gefilterten Joblisten

---

## Matching-Logik für neue Jobs

Das System erkennt neue passende Jobs basierend auf:

* gespeicherten Firmen
* gespeicherten Kategorien

### Technisches Konzept:

* Referenzzeitpunkt wird über `last_seen_at` im User gespeichert
* Jobs werden gefiltert nach:
    * passenden Firmen/Kategorien
    * `created_at > last_seen_at`

### Besonderheit:

Die Logik trennt bewusst zwischen:

* **Daten aktualisieren** („Neue Jobs prüfen“)
* **Zustand speichern** („Als gesehen markieren“)

Dadurch:

* bleiben neue Jobs sichtbar
* verschwinden nicht automatisch
* Benutzer entscheidet selbst über den Status

---

## Datenbank-Erweiterungen

Zusätzliche Strukturen:

* Pivot-Tabelle `company_user`
* Pivot-Tabelle `category_user`
* Feld `last_seen_at` in `users`

Diese ermöglichen:

* Personalisierung
* Zustandsverwaltung pro Benutzer
* Erweiterbarkeit für zukünftige Features (z. B. gespeicherte Jobs)

Das Datenmodell wurde während der Entwicklung erweitert.
Die aktuelle Struktur ist im ER-Diagramm im Ordner /docs dokumentiert.

---

## Erweiterbarkeit

Die aktuelle Architektur ermöglicht:

* einfache Erweiterung um Favoriten (Jobs)
* Benachrichtigungssysteme
* API-Anbindung
* weitere personalisierte Inhalte

---

## Fazit

Die Anwendung ist modular aufgebaut, erweiterbar und entspricht modernen Webentwicklungsstandards.
