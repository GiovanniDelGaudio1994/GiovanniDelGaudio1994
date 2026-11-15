# Headset Studio — Roadmap restyling Liquid Glass

## Versioni da preservare

- **v0.2 / applicazione effettiva:** UI desktop scura mostrata nei due video originali del 16 novembre 2026. Funzioni testate: riconoscimento del dispositivo e volume Mac.
- **v0.3 / restyling proposto:** concept luminoso Liquid Glass, con sidebar translucida, pannelli batteria e stato, slider volume, render delle cuffie e Audio Lab in preparazione.

## Assets di riferimento

- [Mockup originale Liquid Glass (WebP)](https://www.giovannidelgaudio.it/headset-studio-demo/assets/headset-studio-liquid-glass.webp)
- [Breve video reale della versione precedente](https://www.giovannidelgaudio.it/headset-studio-demo/assets/connection-demo.mp4)
- [Registrazione completa reale](https://www.giovannidelgaudio.it/headset-studio-demo/assets/full-demo.mp4)
- [Pagina dimostrativa pubblica](https://www.giovannidelgaudio.it/headset-studio-demo/)

## Attività per repository Flutter futuro

1. Recuperare il progetto Flutter locale originale e conservarne un tag/branch prima di modificare UI o plugin.
2. Creare branch `feature/liquid-glass-restyling` dal codice funzionante.
3. Scomporre la UI in widget responsivi Dashboard, Device, Audio Lab, Settings.
4. Riprodurre la palette bianco/azzurro/lilla e i materiali traslucidi, con fallback accessibile, contrasto e modalità Riduci trasparenza.
5. Mantenere invariati i servizi già verificati per rilevamento Bluetooth e volume macOS.
6. Integrare dati batteria/firmware soltanto se un'interfaccia reale li espone e se l'informazione è testata. Non riportare 90% e 0.0.0 come telemetria vera.
7. Audio Lab ed equalizzatore: mantenerli indicati come futuri fino alla loro implementazione.
8. Validare macOS; testare Windows separatamente prima di dichiarare supporto.
9. Confrontare la UI con il mockup; aggiungere test Flutter e una nuova registrazione reale.
10. Aggiornare portfolio, changelog e release notes dopo le verifiche.

**Nota:** questa cartella del profilo GitHub è una scheda pubblica del progetto, non contiene i sorgenti Flutter. Nessuna modifica al codice dell'app è stata ancora applicata da questo branch.
