# LegacyBridge — Hardware Compatibility Lab

🇮🇹 **Italiano** · [🇬🇧 English](README.en.md)

<div align="center">
  <a href="https://giovannidelgaudio.it/legacybridge-demo/">
    <img src="https://raw.githubusercontent.com/GiovanniDelGaudio1994/forma-ai/main/portfolio/assets/projects/legacybridge-cover.svg" alt="LegacyBridge: notebook classico del 2008 e ponte luminoso verso il software moderno" width="100%"/>
  </a>

  **Old hardware. New possibilities.**  
  C++ · Hardware research · PowerShell · Linux · Proprietary roadmap

  [▶ Demo del laboratorio](https://giovannidelgaudio.it/legacybridge-demo/) · [🔍 Piccolo modulo pubblico AGPLv3](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/legacybridge/)
</div>

---

## Il progetto

LegacyBridge è un laboratorio sperimentale nato per **studiare e recuperare computer datati**. Analizza architettura CPU, istruzioni disponibili, firmware e sistemi operativi, distinguendo i risultati **osservati** dalle informazioni ancora **da verificare**.

### Esperimento #001 — HP 550

| Verifica | Risultato |
|---|---|
| Modello | HP 550, generazione 2008 |
| CPU | Intel Core 2 Duo T5670 · 1,80 GHz |
| Architettura CPU | 64 bit, confermata |
| Windows installato | Windows 10 Pro 1909 x86 (32 bit) |
| Memoria | Circa 3 GiB |
| Firmware | BIOS Legacy |
| SSD | Capacità dichiarata 4 TB, fisica **non verificata** |
| Avvio Windows 10 | **Osservato** |
| Linux Live a 64 bit | **Da provare** |
| Windows 11 | **Non testato, non supportato ufficialmente** |

Il primo passo successivo è eseguire Linux Live da USB, rilevare le istruzioni CPU e creare un report anonimo. Nessuna formattazione, patch firmware o installazione Windows modificata.

## Sviluppo proprietario e sonda storica

**I nuovi sviluppi di LegacyBridge sono previsti come proprietari.** Solo una piccola sonda PowerShell read-only è stata già rilasciata sotto **GNU AGPL-3.0-only**, con il testo della licenza nel repository pubblico. Il laboratorio completo non viene distribuito.

Chi la riusa può studiarla, modificarla e redistribuirla rispettando le condizioni AGPL. Il marchio LegacyBridge e la relativa identità grafica rimangono distinti dalla licenza del codice; non sono stati registrati formalmente.

## Sicurezza e limiti

- Le dimensioni dichiarate dal controller di un SSD non provano la capacità reale.
- Windows 11 richiede altro oltre a x64: POPCNT/SSE4.2 nelle versioni recenti, oltre a requisiti ufficiali quali CPU approvata, UEFI/Secure Boot, TPM e RAM.
- Il progetto **non distribuisce ISO Windows, DLL proprietarie, sistemi patchati o strumenti di attivazione**.
- I dati dell'HP 550 pubblicati sono limitati alle specifiche tecniche; niente seriali, UUID, username o MAC.

**Stato:** laboratorio in sviluppo, esperimento hardware avviato.  
**Autore:** Giovanni Del Gaudio · 2026.


## Licenza e diritti del progetto

**Nuovi moduli indipendenti:** sviluppo proprietario previsto, senza pubblicazione del sorgente completo. **Sonda PowerShell già pubblicata:** [GNU AGPL-3.0-only](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/legacybridge/LICENSE); i diritti già concessi non sono revocabili retroattivamente. Per codice futuro derivato o combinato con la sonda bisogna rispettare eventuali obblighi copyleft.

Le licenze open source non proibiscono la copia delle idee; verifica sempre il testo della licenza del singolo componente.
