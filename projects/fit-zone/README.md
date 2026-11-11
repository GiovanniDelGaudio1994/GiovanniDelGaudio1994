[![Copertina Fit Zone](assets/portfolio-cover.svg)](./)

# 🏋️ Fit Zone — Gestionale web per palestra

**Progetto personale · PHP + MySQL · Pubblicazione del codice per portfolio**

Fit Zone è una web app sviluppata come progetto personale, dedicata alla gestione di una palestra: presentazione di corsi e istruttori, prenotazioni, abbonamenti, account e area amministratore. Questa versione conserva l'architettura e le pagine del progetto originale, accompagnate da una prima revisione di sicurezza.

## Esplora il progetto

- **[📂 Sfoglia il codice sorgente PHP](source/)** — codice reale del progetto, ripulito prima della pubblicazione.
- **[📖 Leggi la documentazione tecnica completa](source/README.md)** — funzionalità, file, architettura e installazione locale.
- **[🗺️ Roadmap e futuri branch](source/ROADMAP.md)** — sicurezza, prenotazioni e miglioramenti UI.
- **[🔎 Audit della pubblicazione](source/AUDIT-PUBBLICAZIONE.md)** — interventi effettuati e problemi ancora da risolvere.

## Funzionalità e architettura

| Area | Descrizione |
|---|---|
| **Sito palestra** | Homepage, presentazione dei servizi, galleria, orari e FAQ |
| **Account** | Registrazione, login, logout e gestione del profilo |
| **Corsi** | Catalogo, categorie, dettagli, istruttori e calendario |
| **Prenotazioni** | Prenotazione delle sessioni, disponibilità e cancellazione |
| **Abbonamenti** | Piani e storico abbonamenti |
| **Amministrazione** | Utenti, corsi e istruttori |
| **Database** | Schema relazionale MySQL, connessioni tramite `mysqli` |

**Stack accertato dall'analisi del codice:** `PHP` · `MySQL` · `HTML` · `CSS` · `JavaScript` · `mysqli`.

## Come usare il codice

La cartella `source/` contiene PHP, fogli CSS, JavaScript, configurazione MySQL da variabili d'ambiente e uno schema SQL con **dati di esempio inventati**. Le credenziali originali e i record di utenti e contatti non sono stati pubblicati. Le immagini fotografiche originali sono state sostituite con un segnaposto finché non sarà verificata la licenza d'uso.

**Non è ancora una release pronta per un hosting Internet.** Sono stati verificati i file con il linter PHP, ma non l'intero flusso con MySQL. Restano da completare CSRF, autorizzazioni, verifica delle prenotazioni, test e rifiniture UI.

## Repository e branch

Per ora il codice è consultabile **nella repository pubblica del portfolio**, all'interno della cartella `projects/fit-zone/source/`. La repository indipendente `Fit-Zone` non è stata ancora creata. Quando sarà disponibile, la storia di sviluppo si potrà organizzare in branch tematici e pull request.

© 2026 Giovanni Del Gaudio sui contributi originali. La visibilità pubblica non comporta automaticamente una licenza open source.
