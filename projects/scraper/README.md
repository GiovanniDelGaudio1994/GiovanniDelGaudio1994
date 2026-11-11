# Scraper — concept di evoluzione: Open Opportunity Radar

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
