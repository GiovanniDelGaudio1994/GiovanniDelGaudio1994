# SignalScope — Caso studio Python

**Tipologia:** strumento CLI Python per monitorare modifiche di pagine pubbliche.  
**Licenza:** GNU AGPL-3.0-only per il codice originale pubblicato.  
**Demo:** https://www.giovannidelgaudio.it/signalscope-demo/

## Problema

Quando una pagina pubblica cambia, è utile rilevare che cosa è stato modificato e ricondurre il cambiamento alla fonte, senza presentare automaticamente la variazione come un fatto verificato.

## Implementazione pubblica

- [Motore Python originale](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/scraper/source/signalscope.py)
- [Test automatici](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/scraper/tests/test_signalscope.py)
- [README tecnico e limiti](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/scraper/README.md)
- [Demo web indipendente](https://www.giovannidelgaudio.it/signalscope-demo/)

Il progetto distingue acquisizione, confronto di snapshot, tracciabilità della fonte e segnalazione delle modifiche. La demo web serve a illustrare i flussi: non è una dashboard multiutente collegata a un servizio cloud.

## Affidabilità e sicurezza

Il README pubblico documenta esplicitamente limiti rispetto a pagine con rendering JavaScript, notifiche, autenticazione, protezione SSRF e concorrenza nelle verifiche DNS. Non è presentato come un classificatore AI né come strumento per aggirare accessi o CAPTCHA.

## Perché è utile a una code review

Perché il motore e i test sono consultabili: è possibile esaminare come vengono elaborati gli input, come sono riportati gli errori, come viene confrontato il contenuto e come sono gestiti gli scenari di test.

## Cosa migliorare

Aggiungere fixture riproducibili per casi limite, documentare il costo di esecuzione, verificare i termini d'uso delle fonti monitorate e fare review di sicurezza prima di un eventuale uso come servizio esposto in rete.
