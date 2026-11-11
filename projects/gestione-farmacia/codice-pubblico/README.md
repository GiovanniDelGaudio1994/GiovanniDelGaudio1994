# GestioneFarmacia — estratto del codice originale

Questa cartella contiene **due classi di dominio tratte dal progetto universitario Java**, rese consultabili per mostrare la struttura dei modelli dati. Il codice è stato formattato in una versione leggermente più compatta, con contenuto e responsabilità preservati. Non si tratta di una nuova applicazione autonoma.

| File | Ruolo |
|---|---|
| [`Farmaco.java`](Farmaco.java) | Entità farmaco: ID, casa farmaceutica, nome commerciale, quantità, prezzo, tipo e riferimenti a ricette |
| [`ReportInventario.java`](ReportInventario.java) | Struttura dati di un report di inventario |

**Esclusi volutamente:** DAO, credenziali MySQL, file SQL, account, database, anagrafiche e sorgenti delle finestre Java Swing. Le classi condivise non contengono valori personali reali.

## Contesto tecnico

Il progetto completo utilizza i package `model`, `dao`, `gui`. Questi due esempi mostrano una piccola parte del package `model` e non sono sufficienti per eseguire il gestionale.

## Diritti

© 2026 Giovanni Del Gaudio. Tutti i diritti riservati sui contributi originali. **Codice pubblicato per lettura e valutazione tecnica, non con una licenza open source.** Nessun permesso generale di copia, modifica o distribuzione viene concesso da questa pagina.
