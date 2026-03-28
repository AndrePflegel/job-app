# Entwicklungsprozess & Erfahrungen

## Projektverlauf

Die Anwendung wurde schrittweise entwickelt. Zunächst lag der Fokus auf der grundlegenden Funktionalität (CRUD für Jobs), danach wurden Rollen, Filter und Benutzerlogik ergänzt.

Im weiteren Verlauf wurde die Anwendung durch Tests, CI/CD und strukturelle Verbesserungen stabilisiert.

---

## Eingesetzte Technologien

* Laravel (Backend, Routing, Auth, ORM)
* Blade Templates (Frontend)
* MySQL / MariaDB in diesem Fall lokal SQLlite (Datenbank)
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

---

## Fazit

Das Projekt zeigt nicht nur die Umsetzung einer Webanwendung, sondern auch den kompletten Lern- und Entwicklungsprozess – inklusive realer Probleme und deren Lösungen.

Gerade die Fehleranalyse und deren Behebung waren ein wesentlicher Bestandteil des Lernerfolgs.
