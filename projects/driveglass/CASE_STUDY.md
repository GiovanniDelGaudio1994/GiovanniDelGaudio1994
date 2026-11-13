# DriveGlass — Caso studio tecnico

**Tipologia:** applicazione personale Flutter / Dart, con dati locali SQLite e backend Node.js in evoluzione.  
**Stato:** dimostrazione video di una build locale; sorgente completo privato.  
**Demo:** https://www.giovannidelgaudio.it/driveglass-demo/

## Problema e obiettivo

Centralizzare in un'interfaccia unica informazioni sul veicolo, interventi di manutenzione, scadenze e documenti. Il progetto nasce dalla necessità di organizzare dati che altrimenti resterebbero frammentati in note, documenti e promemoria.

## Architettura e scelte tecniche

- **Flutter / Dart:** interfaccia applicativa multipiattaforma e componenti di navigazione.
- **SQLite:** memorizzazione locale delle informazioni registrate nell'app.
- **Maintenance e Garage:** organizzazione dei moduli intorno a veicoli e interventi.
- **Document Center:** generazione/esportazione di documenti PDF.
- **Node.js:** componenti backend in sviluppo, non presentati come servizi cloud in produzione.

La demo web pubblica è una **presentazione HTML/CSS/JavaScript separata**: non esegue l'app Flutter originale e non simula collegamenti reali al veicolo.

## Evidenze consultabili

- [Demo e video del software in esecuzione](https://www.giovannidelgaudio.it/driveglass-demo/)
- [Scheda di progetto](README.md)
- [Passaporto digitale dimostrativo](https://www.giovannidelgaudio.it/driveglass-demo/#pdf-proof)

Il video mostra navigazione e manutenzione nell'app durante un test locale. L'esportazione PDF è documentata nella presentazione. Queste prove non certificano il funzionamento di telemetria, OBD, funzioni remote o sincronizzazione cloud.

## Sfide tecniche e limiti

- Tenere coerenti dati e interfaccia durante la gestione delle manutenzioni.
- Rendere il layout utilizzabile su schermi diversi.
- Separare le funzioni disponibili dalle funzioni ancora sperimentali.
- Proteggere VIN, documenti e dati del veicolo: non esporli nella demo.

**Da verificare prima di un rilascio:** test Flutter riproducibili, gestione degli errori, integrazione backend, migrazioni database, performance, sicurezza e privacy.

## Cosa osservare durante un colloquio

Le decisioni su persistenza locale, modularità Flutter, esportazione PDF e gestione dei limiti di una demo rispetto al prodotto completo. Il codice sorgente proprietario non è pubblicato sul portfolio.
