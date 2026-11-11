# 🧠 RememberMe (iRem)

### Progetto universitario di Interazione Uomo–Macchina (IUM)

**Progettazione centrata sull'utente · Paper sketch · Mockup · Test di usabilità · Android Java (progetto storico)**

> Negli elaborati accademici il nome compare anche come **iRem**. RememberMe è il nome usato nel portfolio per presentare questo lavoro.

## 1. Obiettivo del progetto

L'esercitazione universitaria affronta la progettazione di un'app capace di aiutare persone con difficoltà nella gestione dei ricordi e degli impegni quotidiani. La relazione studia in particolare scenari riferiti a persone con Alzheimer. L'obiettivo è **didattico e progettuale**: il software non è un dispositivo sanitario e non è dimostrata un'efficacia clinica.

Il sistema è organizzato in due funzioni principali:

- **Eventi**: inserire, consultare ed eliminare eventi e promemoria, con scelta di titolo e data.
- **Ricordi**: selezionare foto, attribuire didascalie, consultare una galleria ed eliminare i ricordi.

## 2. Processo User-Centered Design

Il lavoro segue un percorso progressivo:

`Analisi del problema` → `Raccolta requisiti` → `Personas` → `Task e casi d'uso` → `Paper sketch` → `Mockup` → `Prototipo` → `Valutazione di usabilità` → `Revisione`

### Ricerca e personas

Gli Assignment descrivono analisi del contesto, interviste e tre personas utilizzate per rappresentare bisogni differenti. I task presi in esame riguardano principalmente l'inserimento e la cancellazione di eventi e ricordi. Per proteggere i dati personali non riproduco qui le biografie complete dei partecipanti.

### Casi d'uso

| Caso | Azione dell'utente | Risposta prevista |
|:--|:--|:--|
| Inserisci evento | Compila nome e data | Memorizzazione e conferma |
| Elimina evento | Seleziona evento ed elimina | Conferma della rimozione |
| Inserisci ricordo | Seleziona immagine e didascalia | Salvataggio con feedback |
| Elimina ricordo | Seleziona ed elimina immagine | Aggiornamento della galleria |

## 3. Paper sketch e mockup autentici

Gli elaborati includono disegni su carta e mockup digitali delle seguenti schermate:

| Immagine | Funzione illustrata |
|:--|:--|
| **Home** | Accesso semplificato alle due aree Eventi e Ricordi |
| **Inserisci evento** | Form con campi e selezione della data |
| **Elimina evento** | Lista di eventi e controllo di eliminazione |
| **Inserisci ricordo** | Acquisizione/selezione di una foto e inserimento didascalia |
| **Elimina ricordo** | Galleria e cancellazione di un ricordo |

**Gli screenshot originali e otto immagini selezionate sono contenuti nel pacchetto di presentazione.** Per ora i file grafici non sono stati caricati in questa cartella GitHub: non vengono mostrati segnaposto fittizi. Queste immagini sono *mockup e schizzi*, non schermate di una build Android verificata oggi.

## 4. Principi di design adottati

La relazione cita i pattern **Playthrough**, **Calendar Picker** e **Gallery**. La progettazione propone pochi comandi riconoscibili, nomi espliciti, uniformità tra task simili, feedback visibile e guida per correggere gli errori di compilazione. La finalità è limitare il carico di memoria richiesto durante l'interazione.

## 5. Valutazione dell'usabilità

### Cognitive walkthrough

Un task rappresentativo è l'inserimento di un evento. Il gruppo analizza se l'utente riconosce il comando, comprende i campi del modulo, sa completare l'azione e interpreta il feedback finale.

### Valutazione euristica

Gli Assignment richiamano le **otto regole d'oro di Shneiderman**: consistenza, scorciatoie, feedback, dialoghi completi, gestione degli errori, possibilità di inversione, controllo dell'utente e riduzione del carico mnemonico.

### Testing cooperativo

La presentazione finale documenta una valutazione con tre partecipanti e l'uso di questionari. Tra le modifiche descritte: **eliminazione della schermata di login**, semplificazione dell'interfaccia, revisione di pulsanti/colori e miglioramento dei percorsi dei task. La documentazione non costituisce una validazione clinica o una misura quantitativa generalizzabile dell'accessibilità.

## 6. Implementazione Android

Il materiale include un progetto Android Java storico con:

- Activity per menu, eventi/promemoria e ricordi;
- Componenti per programmazione e gestione delle notifiche;
- Galleria immagini con persistenza locale **SQLite**;
- Interfacce definite tramite layout XML.

Il progetto utilizza Android SDK e dipendenze storiche (compile/target SDK 25). **Non è stato verificato come compilabile o utilizzabile sui dispositivi Android moderni.**

**Nota sulle licenze:** il codice fornito è collocato in una cartella `AlarmReminder-master`, usa il package `com.delaroystudios.alarmreminder` e non include una licenza identificabile. La provenienza di questi componenti deve essere verificata prima di distribuire pubblicamente il codice completo o attribuirgli una licenza open source.

## 7. Team e contributi

Gli elaborati riportano **Francesco Sciretta, Giovanni Del Gaudio e Felice Napolitano** come componenti del progetto di gruppo. Negli Assignment 1 e 3, **Giovanni Del Gaudio** è indicato come responsabile della documentazione, con attività di stesura e revisione. Alcune presentazioni riportano una diversa ripartizione dei ruoli; questa scheda non attribuisce a un singolo componente l'intera progettazione o implementazione.

## 8. Competenze mostrate

**HCI/IUM**, User-Centered Design, analisi utenti e task, personas, casi d'uso, prototipazione su carta, wireframe, mockup, cognitive walkthrough, valutazione euristica, testing cooperativo, documentazione tecnica e collaborazione in team.

## 9. Stato e limiti

- **Progetto universitario storico**, non prodotto in produzione.
- **Mockup autentici disponibili nel materiale originale**, da caricare nella cartella pubblica `assets/`.
- **Sorgenti non ancora pubblicati**, in attesa di verifica della provenienza e delle licenze di terzi.
- Nessuna promessa di efficacia clinica.

---

**Portfolio di Giovanni Del Gaudio** · Progetto realizzato in gruppo · I contributi e le componenti di terzi restano soggetti ai diritti dei rispettivi autori.

## 🎞️ Prototipo animato — iRem

La demo animata è stata ricostruita a partire dalle schermate originali di `Prototipo (2).pptx`. Ripercorre sei momenti del prototipo: splash screen, scelta tra Eventi e Ricordi, inserimento di un evento, lista degli eventi, galleria e visualizzazione di una foto-ricordo.

**È un'animazione dimostrativa**, non una registrazione di un'app Android in esecuzione. [Apri la cartella pubblica destinata agli asset](assets/README.md).

> Il file GIF è già stato generato, ma **non è ancora ospitato nella repository**: la sezione non mostra un link immagine inesistente. Verrà visualizzato direttamente qui non appena il file sarà caricato come `assets/rememberme-demo.gif`.

## 📚 Documentazione del progetto

Al termine della presentazione sono disponibili due approfondimenti ricavati **dai documenti universitari originali**:

- 📄 [**Assignment 1, 2 e 3 — analisi utenti, casi d'uso, paper sketch e testing**](documentazione/assignment-1-2-3.md)
- 📊 [**Presentazione finale IUM — obiettivi, mockup, valutazione e risultati**](documentazione/presentazione-ium.md)

**Documenti originali di riferimento:** `Assignment1,2,3.docx`, `Assignment1,2,3.pdf` e `Presentazione ium.pptx`. Le pagine collegate sono rielaborazioni consultabili direttamente su GitHub; i file binari originali non sono ancora caricati nella repository pubblica.

