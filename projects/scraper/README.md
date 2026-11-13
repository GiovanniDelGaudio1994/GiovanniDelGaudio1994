# Scraper — concept di evoluzione: Open Opportunity Radar

> **Versione funzionante e codice pubblico:** [SignalScope — sorgente Python](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/scraper), [test](https://github.com/GiovanniDelGaudio1994/forma-ai/tree/main/projects/scraper/tests) e [caso studio tecnico](CASE_STUDY.md). La roadmap di seguito è una proposta ulteriore e non descrive funzioni già disponibili.


**Progetto personale · Ricerca e progettazione · Sorgenti da verificare**

Evoluzione proposta per l'archivio originale `Scraper.zip`: un osservatorio di opportunità verificabili per studenti, sviluppatori e persone in cerca di formazione, basato prioritariamente su fonti pubbliche e API ufficiali.

## Problema

Bandi, borse di studio, concorsi e occasioni professionali sono distribuiti su molteplici siti: le scadenze possono passare inosservate e alcuni annunci sono duplicati o poco chiari.

## Roadmap proposta (non ancora implementata)

1. Acquisizione da API, feed RSS/Atom e pagine che consentono la raccolta, nel rispetto di robots.txt, termini d'uso e limiti di frequenza.
2. Normalizzazione dei campi (titolo, ente, fonte, URL, data di pubblicazione e scadenza) e deduplicazione.
3. Ricerca per categorie, località e scadenze, con link alla fonte originale.
4. Segnalazione delle modifiche alle opportunità e spiegazione verificabile dei criteri di filtraggio.
5. Dashboard accessibile, test automatizzati e demo con dataset pubblico riproducibile.

## Principi di affidabilità

- Mai inventare scadenze o dichiarare che un'opportunità è disponibile senza una fonte valida.
- Citare la fonte primaria e mostrare l'ultimo controllo effettuato.
- Nessun bypass di CAPTCHA, autenticazione o restrizioni di accesso.
- Nessuna raccolta non necessaria di dati personali.

## Stato

L'idea e questa scheda sono pubbliche, ma il contenuto dello ZIP originale non è ancora stato ispezionato né integrato. Il software non è ancora certificato come funzionante. Il nome definitivo, la licenza e la fattibilità delle singole fonti saranno decisi dopo l'audit.


## Licenza e diritti del progetto

**Motore originale SignalScope:** [GNU AGPL-3.0-only](https://github.com/GiovanniDelGaudio1994/forma-ai/blob/main/projects/scraper/LICENSE). L'archivio storico di un altro scraper non è incluso in questa concessione.

Le licenze open source non proibiscono la copia delle idee; verifica sempre il testo della licenza del singolo componente.
