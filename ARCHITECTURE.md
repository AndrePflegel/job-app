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

### View

* Umsetzung mit Blade Templates
* Verantwortlich für Darstellung der Daten

---

### Controller

* Verarbeitet Anfragen
* Steuert die Logik zwischen Model und View

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

## CI/CD

* GitHub Actions
* Automatische Tests bei jedem Push
* Mehrere PHP-Versionen

---

## Fazit

Die Anwendung ist modular aufgebaut, erweiterbar und entspricht modernen Webentwicklungsstandards.
