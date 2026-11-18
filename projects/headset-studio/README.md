<div align="center">

# 🎧 Headset Studio

### Bluetooth Headphone Companion · Flutter for macOS

<img src="https://raw.githubusercontent.com/GiovanniDelGaudio1994/giovanni-portfolio/main/portfolio/assets/projects/headset-studio-liquid-glass.webp" alt="Headset Studio — concept Liquid Glass in azzurro, bianco e lilla, con cuffie over-ear e pannelli della dashboard" width="820">

<sub>Concept grafico del prossimo restyling: non è uno screenshot della build v0.2.1.</sub>

**Flutter · Dart · macOS · Bluetooth · Audio di sistema**

[💻 Sorgenti originali v0.2.1](https://github.com/GiovanniDelGaudio1994/headset-studio/tree/main/source/v0.2.1) · [🎬 Demo e video](https://www.giovannidelgaudio.it/headset-studio-demo/) · [📂 Repository principale](https://github.com/GiovanniDelGaudio1994/headset-studio)

</div>

---

## Il progetto

**Headset Studio** nasce dall'esigenza di visualizzare e gestire informazioni sulle cuffie Bluetooth collegate al Mac. I primi test sono stati effettuati con **Marshall Major III Bluetooth**.

Il progetto è **indipendente e non ufficiale**: non è affiliato, approvato o sponsorizzato da Marshall Group.

## Cosa mostra il codice pubblicato

Nel repository dedicato è disponibile un **estratto autentico della v0.2.1**, non una ricostruzione:
- [`headphone_service.dart`](https://github.com/GiovanniDelGaudio1994/headset-studio/blob/main/source/v0.2.1/lib/services/headphone_service.dart): interrogazione di macOS con `system_profiler` e `pmset`, rilevamento Major III, parsing dello stato e della batteria quando disponibile.
- [`mac_audio_service.dart`](https://github.com/GiovanniDelGaudio1994/headset-studio/blob/main/source/v0.2.1/lib/services/mac_audio_service.dart): lettura e modifica del **volume di uscita del Mac**, non del firmware delle cuffie.
- [`headphone_service_test.dart`](https://github.com/GiovanniDelGaudio1994/headset-studio/blob/main/source/v0.2.1/test/headphone_service_test.dart): test del parsing con dati di esempio.

**Ambito di pubblicazione:** i file caricati sono una selezione di sorgenti reali. Il progetto completo, la dashboard 3D e gli asset non sono ancora inclusi in questo estratto; quindi non è una release installabile. I test presenti non risultano eseguiti in questo ambiente di pubblicazione.

## Stato e design

| Area | Stato |
| --- | --- |
| Prototipo Flutter macOS | Avviato e provato dall'autore |
| Rilevamento Major III e stato di connessione | Test iniziali effettuati |
| Controllo volume di sistema | Testato dall'autore |
| Batteria e dettagli del dispositivo | Dipendono dai dati disponibili su macOS; non garantiti |
| Interfaccia Liquid Glass chiara | Concept / evoluzione in corso |
| Audio Lab, EQ e compatibilità Windows | In studio, non verificati |

Il concept grafico raffigura dati e controlli illustrativi. Non implica che batteria, firmware, protocolli o funzioni avanzate siano già implementati come mostrati.

## Esplora

- [Codice originale v0.2.1](https://github.com/GiovanniDelGaudio1994/headset-studio/tree/main/source/v0.2.1)
- [Repository Headset Studio e README](https://github.com/GiovanniDelGaudio1994/headset-studio)
- [Demo, mockup e registrazioni dell'app](https://www.giovannidelgaudio.it/headset-studio-demo/)
- [Portfolio personale](https://www.giovannidelgaudio.it/)

---

<div align="center"><sub>© 2026 Giovanni Del Gaudio · Headset Studio · Progetto personale indipendente</sub></div>
