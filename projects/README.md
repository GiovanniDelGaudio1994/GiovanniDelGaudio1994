# Indice dei progetti — Giovanni Del Gaudio

Il profilo contiene **schede tecniche e materiali dimostrativi**; non è un contenitore unico di tutte le applicazioni. Per vedere i progetti in funzione, apri il [portfolio](https://www.giovannidelgaudio.it/).

## Applicazioni con codice completo riservato

| Progetto | Scheda GitHub | Demo pubblica | Sorgente completo |
| --- | --- | --- | --- |
| FORMA AI | [Scheda](forma-ai/) | [Demo](https://www.giovannidelgaudio.it/forma-ai-demo/) · [Atlante 3D](https://www.giovannidelgaudio.it/atlante-3d.html) | Privato (`forma-ai-private`) |
| DriveGlass | [Scheda](driveglass/) · [Caso studio](driveglass/CASE_STUDY.md) | [Demo e video](https://www.giovannidelgaudio.it/driveglass-demo/) | Privato: `driveglass-private` creato e verificato; codice Flutter e backend Node.js |
| Fit Zone | [Scheda](fit-zone/) | [Demo](https://www.giovannidelgaudio.it/fit-zone-demo/) | Privato: `fit-zone-private` creato e verificato; la versione attuale del ramo pubblico contiene soltanto la scheda e gli asset, non più la cartella `source/`; la cronologia storica può restare accessibile |
| GestioneFarmacia | [Scheda](gestione-farmacia/) · [Caso studio](gestione-farmacia/CASE_STUDY.md) | [Demo](https://www.giovannidelgaudio.it/gestione-farmacia-demo/) | Privato; solo due classi Java di esempio pubbliche |
| e-Wine | [Scheda](e-wine/) | [Demo](https://www.giovannidelgaudio.it/ewine-demo/) | Sorgente completo non pubblicato |
| LegacyBridge | [Scheda](legacybridge/) | [Demo](https://www.giovannidelgaudio.it/legacybridge-demo/) | Sviluppi futuri proprietari; sonda PowerShell storica AGPLv3 già pubblicata |

## Software e strumenti pubblici

| Progetto | Sorgente pubblico | Demo |
| --- | --- | --- |
| SignalScope | [Python / scraper](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/scraper) (AGPL-3.0-only) · [Caso studio](scraper/CASE_STUDY.md) | [Web](https://www.giovannidelgaudio.it/signalscope-demo/) |
| Meteo Bash 2D | [Bash](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/meteo-bash2d) (AGPL-3.0-only) | [Web](https://www.giovannidelgaudio.it/meteo-bash2d-demo/) |

## UX, studi e altri lavori

- [RememberMe / iRem](rememberme/) — [prototipo navigabile](https://www.giovannidelgaudio.it/portfolio/demos/irem/)
- [Cilento Platform](cilento-platform/) — scheda descrittiva
- [Gestionale B&B](gestionale-bnb/) — scheda descrittiva
- [Fit Zone](fit-zone/), [GestioneFarmacia](gestione-farmacia/) ed [e-Wine](e-wine/) — casi studio più completi

## Come sono organizzati i repository

```text
GiovanniDelGaudio1994/                 # profilo GitHub pubblico: README e projects/<schede>
giovanni-portfolio/                     # pubblico: sito e demo statiche
forma-ai/                               # pubblico storico: FORMA AI demo + tool AGPL
forma-ai-private/                       # privato: codice dell'app FORMA AI
GestioneFarmacia/                       # privato: repository del gestionale
driveglass-private/                     # PRIVATO: Flutter + Node.js
fit-zone-private/                       # PRIVATO: codice PHP storico
```

**Regola:** le demo pubbliche servono ai recruiter per valutare UX e funzionalità dimostrabili; non contengono i backend proprietari, le credenziali o i database reali. Una demo web, il suo JavaScript e i media collegati sono comunque scaricabili. La rimozione di file precedentemente pubblici dal ramo attuale **non ne elimina la cronologia Git**, né eventuali copie esterne.

Le cartelle `projects/` di questo repository sono schede; la cartella `giovanni-portfolio` contiene le demo. Conservare le route già pubblicate evita collegamenti interrotti.
