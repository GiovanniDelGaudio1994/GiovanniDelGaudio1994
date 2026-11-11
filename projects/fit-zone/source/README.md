[![Fit Zone — copertina del progetto](https://raw.githubusercontent.com/GiovanniDelGaudio1994/GiovanniDelGaudio1994/main/projects/fit-zone/assets/portfolio-cover.svg)](https://github.com/GiovanniDelGaudio1994/GiovanniDelGaudio1994/tree/main/projects/fit-zone)

# 🏋️ Fit Zone

**Gestionale web di palestra · Progetto personale · PHP + MySQL · Portfolio 2026**

Fit Zone è una web app personale progettata per gestire informazioni di una palestra, corsi, utenti, prenotazioni, abbonamenti e strumenti per il personale amministrativo. Questo repository distribuisce una **versione storica ripulita per la revisione tecnica**, non un servizio pronto per produzione. Alcune parti sono da completare.

## Funzionalità documentate nel codice

| Area | File principali | Cosa fa |
|---|---|---|
| Vetrina palestra | `index.php` | Servizi, galleria, orari, FAQ e form contatti |
| Account | `register.php`, `login.php`, `logout.php` | Registrazione, accesso e sessioni |
| Profilo utente | `profile.php` | Informazioni personali e aggiornamento password |
| Corsi e attività | `corsi.php`, `attivita.php`, `dettaglio-corso.php` | Catalogo e dettagli attività |
| Prenotazioni | `prenota-corso.php`, `prenotazioni.php`, `calendario.php` | Sessioni, disponibilità e gestione prenotazioni |
| Abbonamenti | `abbonamenti.php` | Piani e storico abbonamenti |
| Amministrazione | `admin.php` | Utenti, corsi e istruttori |
| Database | `database/schema.sql` | Schema relazionale MySQL senza dati personali |

## Tecnologie

- **PHP 8+**, MySQL, `mysqli`, sessioni PHP, HTML, CSS, JavaScript.
- Dipendenza visuale esterna Font Awesome via CDN su alcune pagine.
- Nessun utilizzo di MongoDB nella versione caricata.

## Architettura in breve

```text
fit-zone/
├── index.php / login.php / register.php
├── corsi.php / calendario.php / prenotazioni.php
├── abbonamenti.php / admin.php / profile.php
├── db_config.php           # Variabili d'ambiente, nessun segreto nel codice
├── database/
│   ├── schema.sql          # Solo struttura
│   └── demo-seed.sql       # Dati inventati
├── css/
├── script/
├── images/placeholder.svg  # Fotografie non ridistribuite
└── .github/workflows/php-lint.yml
```

## Installazione locale (ambiente di sviluppo)

Requisiti: **PHP 8+ con estensione MySQLi** e un'istanza **MySQL 8+**.

1. Crea un database chiamato `fitzone_db` e un utente MySQL locale con i permessi minimi necessari.
2. Importa `database/schema.sql` e poi `database/demo-seed.sql` tramite il client MySQL.
3. Configura nel terminale o nel server web le variabili `FITZONE_DB_HOST`, `FITZONE_DB_PORT`, `FITZONE_DB_USER`, `FITZONE_DB_PASSWORD`, `FITZONE_DB_NAME`. Il file `.env.example` è un riferimento, **non** viene letto automaticamente da PHP.
4. Esegui `php -S 127.0.0.1:8000` dalla cartella del progetto e apri `http://127.0.0.1:8000`.
5. Registrati con un account creato da te. **Nessun admin predefinito** viene distribuito. Se devi provare il pannello admin in locale, assegna esplicitamente il ruolo ad un tuo account di test tramite il database.

Questo percorso non è stato verificato con una vera installazione MySQL in questa analisi: sono stati verificati il sorgente e la sintassi PHP. Prima dell'uso reale sono necessari test di integrazione.

## Audit di pubblicazione

[Leggi i controlli effettuati e ciò che resta da verificare](AUDIT-PUBBLICAZIONE.md).

## Sicurezza e limitazioni

**Non distribuire questo progetto pubblicamente su un server prima della revisione indicata in [SECURITY.md](SECURITY.md).** La repository può essere pubblica come sorgente di portfolio ma contiene ancora aspetti da migliorare (CSRF, controlli autorizzativi, sanitizzazione completa, test).

Il database storico conteneva dati, email e password hash: **non viene pubblicato**. Sono inclusi esclusivamente struttura e righe dimostrative. Le foto originali del sito e le immagini caricate dagli utenti non sono distribuite per incertezza sulla provenienza e sui diritti d'uso; al loro posto è presente un'immagine neutra.

## Roadmap e branch

Seguire [ROADMAP.md](ROADMAP.md). Le modifiche future verranno sviluppate in branch tematici, riviste e integrate con pull request verso `main`. Vedere [CONTRIBUTING.md](CONTRIBUTING.md).

## Diritti e attribuzione

© 2026 Giovanni Del Gaudio, per i propri contributi. Pubblicazione per valutazione tecnica; **nessuna licenza open source è stata ancora concessa**. Eventuali componenti di terzi mantengono le rispettive licenze.
