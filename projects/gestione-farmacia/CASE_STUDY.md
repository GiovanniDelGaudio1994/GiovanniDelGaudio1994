# GestioneFarmacia — Caso studio Java e basi di dati

**Tipologia:** progetto universitario di Basi di Dati — Università degli Studi di Salerno (A.A. 2024/2025).  
**Stack:** Java Swing, SQL, MySQL, JDBC; modello concettuale E-R e organizzazione per livelli.  
**Demo:** https://www.giovannidelgaudio.it/gestione-farmacia-demo/

## Problema e requisiti

Modellare la gestione di un'attività farmaceutica includendo farmaci, inventario, clienti/pazienti, operatori, ricette e report. Il lavoro accademico affronta requisiti, dati e interrogazioni oltre all'interfaccia desktop.

## Progettazione

Il percorso documentato include:

1. Raccolta e analisi dei requisiti.
2. Modellazione **Entity–Relationship (E-R)** e analisi delle operazioni.
3. Traduzione nel modello relazionale e normalizzazione.
4. Implementazione con package **model**, **dao** e **gui** in Java.
5. Interfaccia Java Swing e accesso ai dati tramite JDBC/MySQL.

## Evidenze consultabili

- [Demo web ricostruttiva](https://www.giovannidelgaudio.it/gestione-farmacia-demo/), navigabile con dati sintetici.
- [Scheda completa](README.md).
- [Classe Farmaco.java](codice-pubblico/Farmaco.java) e [ReportInventario.java](codice-pubblico/ReportInventario.java): estratti originali pubblici destinati alla valutazione tecnica.

La demo HTML **non esegue il programma Java originale né si connette al database MySQL**. Il repository GitHub privato del gestionale esiste, ma il caricamento dei sorgenti completi deve ancora essere verificato; non è qui presentato come archivio completo già sincronizzato.

## Qualità, sicurezza e limiti

- Non distribuire dati di pazienti reali, account o configurazioni MySQL.
- La progettazione dei DAO e l'uso di query parametrizzate sono temi da discutere e verificare sul codice completo, non conclusioni certificate dalla demo.
- La ricostruzione web rende comprensibili i moduli, ma non comprova tutte le operazioni CRUD originali.

## Cosa osservare durante un colloquio

Scelte di modellazione E-R, cardinalità, vincoli, normalizzazione, responsabilità degli oggetti Java, confine tra GUI e DAO e gestione delle interrogazioni SQL.
