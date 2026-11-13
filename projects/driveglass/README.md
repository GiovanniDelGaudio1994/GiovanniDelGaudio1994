[![DriveGlass — Smart Vehicle Companion, concept Liquid Glass](https://raw.githubusercontent.com/GiovanniDelGaudio1994/forma-ai/main/portfolio/assets/projects/driveglass-interface-2026.webp)](https://giovannidelgaudio.it/driveglass-demo/)

# DriveGlass — Smart Vehicle Companion

**Flutter · Dart · SQLite · Node.js (in sviluppo) · App privata con demo pubblica**

DriveGlass è un'applicazione per la gestione locale dei veicoli: Garage digitale, informazioni tecniche, manutenzione, scadenze e Document Center. Il design segue la direzione *Liquid Glass*. **Il codice sorgente completo rimane privato** e nessuna funzione remota del veicolo è dichiarata operativa.

[Leggi il caso studio tecnico: scelte, prove e limiti](CASE_STUDY.md)

## ▶ Demo pubblica con video reale

[![Fotogramma di una registrazione reale di DriveGlass Flutter durante un test locale](https://raw.githubusercontent.com/GiovanniDelGaudio1994/forma-ai/main/driveglass-demo/assets/driveglass-real-demo-poster.webp)](https://giovannidelgaudio.it/driveglass-demo/#verifiche)

**[Guarda la demo pubblica e il video dell'app](https://giovannidelgaudio.it/driveglass-demo/)** · **[Passaporto digitale PDF: anteprima dei dati esportati](https://giovannidelgaudio.it/driveglass-demo/#pdf-proof)** · **[Apri la sezione verifiche](https://giovannidelgaudio.it/driveglass-demo/#verifiche)**

Il filmato è un estratto ottimizzato di una registrazione reale dell'**8 novembre 2026**: mostra l'app Flutter funzionante sul Mac durante test di navigazione e manutenzione. È una prova dell'interfaccia locale, **non** di collegamenti OBD, telemetria live o controlli remoti.

## Funzionalità e stato

| Modulo | Situazione |
|---|---|
| Garage multi-veicolo | Implementato e provato localmente |
| Maintenance Center | Inserimento e salvataggio degli interventi verificati in sviluppo |
| Dati locali | Persistenza SQLite verificata nei test precedenti |
| Document Center | Esportazione PDF verificata nei test precedenti |
| Gallery | Galleria illustrativa di veicoli |
| Cloud Garage / sincronizzazione | In sviluppo, non dimostrata nel video |
| Telemetria e comandi remoti | Non disponibili nella demo pubblica |

La demo web è una **presentazione interattiva** separata dall'app proprietaria. Utilizza dati dimostrativi e non salva documenti, targhe, VIN o credenziali.

## Architettura e privacy

- **App privata:** Flutter/Dart, memorizzazione locale e moduli in evoluzione.
- **Showcase pubblico:** HTML/CSS/JavaScript e video dimostrativo senza sorgenti o database.
- **Backend:** componenti Node.js in sviluppo; non sono esposti nella demo.

© 2026 Giovanni Del Gaudio. Tutti i diritti riservati sui contributi originali.


## Licenza e diritti del progetto

**App Flutter privata:** tutti i diritti riservati sul codice originale non distribuito. Il video e il PDF mostrati nella demo sono materiali dimostrativi e non rendono l'app AGPLv3.

Le licenze open source non proibiscono la copia delle idee; verifica sempre il testo della licenza del singolo componente.
