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
