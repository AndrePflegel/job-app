# Entwicklungsprozess & Erfahrungen

## Projektverlauf

Die Anwendung wurde schrittweise entwickelt. Zunächst lag der Fokus auf der grundlegenden Funktionalität (CRUD für Jobs), danach wurden Rollen, Filter und Benutzerlogik ergänzt.

Im weiteren Verlauf wurde die Anwendung durch Tests, CI/CD und strukturelle Verbesserungen stabilisiert.

---

## Eingesetzte Technologien

* Laravel (Backend, Routing, Auth, ORM)
* Blade Templates (Frontend)
* SQLite lokal für Entwicklung und Tests
* MySQL / MariaDB optional für produktionsnahe Umgebungen
* Git & GitHub (Versionskontrolle)
* GitHub Actions (CI/CD)
* Composer (Dependency Management)
* Node / Vite (Frontend-Build)

---

## Reale Probleme und Lösungen

### 1. Probleme mit Git & GitHub

Zu Beginn kam es zu Unsicherheiten im Umgang mit Git und GitHub, insbesondere:

* Unterschied zwischen lokalem Repository und Remote Repository
* Verständnis von Commits, Push und Pull Requests
* Verwirrung, warum Änderungen lokal vorhanden sind, aber nicht auf GitHub sichtbar sind

**Lösung:**

* Klare Trennung zwischen lokalem Stand und Remote verstanden
* bewusster Umgang mit `git add`, `commit` und `push`
* regelmäßiges Überprüfen des Repository-Zustands
* Fehler später gefunden (Mail bei Git und GitHub war nicht gleich und damit gab es Probleme)

**Erkenntnis:**

Versionskontrolle ist ein zentraler Bestandteil der Entwicklung und muss sauber verstanden werden.

---

### 2. CI/CD Pipeline Fehler (GitHub Actions)

Nach Einrichtung der Pipeline schlugen die Tests zunächst fehl.

Probleme:

* Fehlende oder falsche Konfiguration
* Unterschiede zwischen lokaler Umgebung und CI-Umgebung
* Unklare Fehlermeldungen in den Logs

**Lösung:**

* Analyse der GitHub Actions Logs
* schrittweises Eingrenzen der Fehler
* Anpassung der Workflow-Datei

**Erkenntnis:**

CI-Systeme zeigen Fehler sehr genau, aber man muss lernen, Logs richtig zu lesen.

---

### 3. Fehlgeschlagene Authentifizierungs-Tests

Ein besonders schwieriger Fehler trat bei den Laravel Tests auf:

* Tests erwarteten Redirect auf `/dashboard`
* Anwendung leitete jedoch auf `/` weiter

Fehlermeldung:

```
Failed asserting that two strings are equal.
'/dashboard' != '/'
```

**Ursache:**

Falsche Redirect-Logik im Login-Controller.

**Lösung:**

* Analyse der Testfälle
* Verständnis der erwarteten Route
* Anpassung des Redirects im Controller

**Erkenntnis:**

Tests sind nicht „Feinde“, sondern helfen, Logikfehler aufzudecken.

---

### 4. Verständnisprobleme bei Laravel-Struktur

Zu Beginn war unklar:

* wo bestimmte Logik hingehört (Controller vs. Route)
* wie Laravel intern Redirects und Auth steuert

**Lösung:**

* schrittweises Durchgehen der Struktur
* gezieltes Nachvollziehen von Request-Flows

**Erkenntnis:**

Frameworks nehmen viel Arbeit ab, aber man muss ihre Struktur verstehen.

---

### 5. Datenbank & Migrationen

* Verständnis für Migrationen und Datenbankstruktur musste aufgebaut werden
* Beziehungen zwischen Tabellen waren anfangs nicht sofort klar

**Lösung:**

* Nutzung von Laravel Migrations
* klare Strukturierung der Tabellen (Jobs, Companies, Categories, Users)


---


### 6. Konflikt bei Tabellenstruktur („jobs“)

Während der Entwicklung trat ein Problem mit der Datenbankstruktur auf:

* Die Aufgabenstellung verlangte eine Tabelle mit dem Namen **`jobs`**
* Gleichzeitig existierten durch Laravel bzw. bestehende Strukturen bereits Tabellen bzw. Bezüge, die zu Konflikten führten

Dies führte zu Problemen bei:

* Migrationen
* Beziehungen zwischen Modellen
* Zugriffen im Code

**Lösung:**

* Die eigene Implementierung wurde zunächst angepasst (z. B. alternative Benennung)
* anschließend wurde geprüft, wie die Struktur wieder an die Vorgaben angepasst werden kann
* Ziel war es, die Anforderungen einzuhalten und gleichzeitig Konflikte zu vermeiden

**Erkenntnis:**

Namenskonflikte zwischen Framework-Vorgaben und eigenen Anforderungen können zu unerwarteten Problemen führen.
Eine saubere Planung der Datenbankstruktur ist daher entscheidend.

---

## Allgemeine Erkenntnis aus diesem Problem

Dieses Problem zeigt, dass:

* Frameworks bereits eigene Strukturen mitbringen
* Anforderungen nicht immer direkt konfliktfrei umsetzbar sind
* man flexibel reagieren und Lösungen entwickeln muss

Gerade solche Situationen sind typisch für reale Projekte.


---

## Wichtige Erkenntnisse

* Fehler sind ein normaler Bestandteil der Entwicklung
* Debugging ist eine zentrale Fähigkeit
* Automatisierte Tests erhöhen die Qualität erheblich
* CI/CD gehört zum modernen Entwicklungsprozess dazu
* saubere Struktur spart später viel Zeit
* Berechtigungslogik sollte zentral organisiert sein
* Laravel Policies verbessern Wartbarkeit und Testbarkeit deutlich
* Views sollten sichtbare Aktionen über `@can(...)` an dieselben Regeln koppeln wie Controller


---

### 7. Einführung von Personalisierung (Visitor Dashboard)

Im späteren Verlauf wurde die Anwendung um personalisierte Funktionen erweitert.

Neue Features:

* Speichern von Firmen und Kategorien
* Anzeige im Dashboard
* Matching von neuen Jobs basierend auf Interessen

---

### 8. Herausforderung: „Neue Jobs“ Logik

Ein zentrales Problem war die Frage:

Wann ist ein Job „neu“?

Ansätze:

* automatische Aktualisierung → Jobs verschwinden sofort (nicht optimal)
* statischer Zustand → keine Aktualisierung möglich

**Lösung:**

Ein hybrider Ansatz:

* Referenzzeitpunkt (`last_seen_at`)
* manuelles Aktualisieren („Neue Jobs prüfen“)
* bewusstes Speichern („Als gesehen markieren“)

---

### 9. UX-Entscheidungen

Besonderer Fokus lag auf Benutzerfreundlichkeit:

* klare Trennung von Aktionen (prüfen vs. markieren)
* verständliche Button-Beschriftungen
* stabile Anzeige von Inhalten

---

### 10. Teststrategie erweitert

Neue Tests wurden hinzugefügt für:

* gespeicherte Firmen
* gespeicherte Kategorien
* Matching-Logik für Jobs
* Zustandsänderungen (last_seen_at)

Ergebnis:

* steigende Testabdeckung
* stabilere Anwendung
* reproduzierbares Verhalten

---

### 11. Umstellung der Autorisierung auf Policies

Im späteren Verlauf wurde die Berechtigungslogik überarbeitet.

Vorher:

* einzelne Berechtigungsprüfungen waren teilweise im `User`-Model, in Controllern und in Blade-Views verteilt
* dadurch war die Logik funktional, aber nicht zentral organisiert

Umstellung:

* Einführung bzw. konsequente Nutzung von Laravel Policies
* Controller nutzen `authorize(...)`
* Blade-Templates nutzen `@can(...)`
* alte Modell-Helfer für Berechtigungen wurden entfernt

Ergebnis:

* Berechtigungen sind jetzt an einer zentralen Stelle definiert
* Änderungen müssen nicht mehr an mehreren Stellen gleichzeitig vorgenommen werden
* Tests prüfen die echte Autorisierungslogik statt alter Hilfsmethoden

**Erkenntnis:**

Autorisierung sollte in Laravel möglichst konsistent über Policies umgesetzt werden, weil das die Anwendung verständlicher, wartbarer und robuster macht.


## Wichtige Erkenntnis aus diesem Abschnitt

Nicht nur technische Umsetzung ist entscheidend, sondern:

* saubere UX
* nachvollziehbares Verhalten
* klare Trennung von Logik

Diese Punkte sind typisch für reale Softwareprojekte.

---

## Fazit

Das Projekt zeigt nicht nur die Umsetzung einer Webanwendung, sondern auch den kompletten Lern- und Entwicklungsprozess – inklusive realer Probleme und deren Lösungen.

Gerade die Fehleranalyse und deren Behebung waren ein wesentlicher Bestandteil des Lernerfolgs.
