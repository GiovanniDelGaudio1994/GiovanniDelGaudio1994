-- Synthetic sample data for a local installation only.
INSERT INTO categorie_corsi (id, nome, descrizione) VALUES
(1,'Cardio','Esempio di allenamento cardiovascolare'),
(2,'Forza','Esempio di allenamento forza'),
(3,'Flessibilità','Esempio di mobilità e stretching'),
(4,'Funzionale','Esempio di circuito funzionale');
INSERT INTO corsi (id, nome, descrizione, categoria_id, istruttore, max_partecipanti, immagine) VALUES
(1,'Yoga Demo','Lezione fittizia di yoga',3,'Istruttore Demo A',12,'images/placeholder.svg'),
(2,'Spinning Demo','Lezione fittizia di spinning',1,'Istruttore Demo B',15,'images/placeholder.svg'),
(3,'Circuito Demo','Lezione fittizia di allenamento funzionale',4,'Istruttore Demo C',14,'images/placeholder.svg');
INSERT INTO tipi_abbonamento (id, nome, descrizione, durata_mesi, prezzo, attivo) VALUES
(1,'Mensile Demo','Piano dimostrativo mensile',1,39.90,1),
(2,'Trimestrale Demo','Piano dimostrativo trimestrale',3,99.90,1);
INSERT INTO info_palestra (id,nome,indirizzo,telefono,email,descrizione) VALUES
(1,'FitZone DEMO','Via Esempio 1, Città Demo','0000000000','info@example.invalid','Centro fitness fittizio usato per illustrare il software.');

INSERT INTO faq (id, domanda, risposta, ordine) VALUES
(1,'Quali corsi sono previsti?','Yoga, spinning e allenamento funzionale (dati fittizi).',1),
(2,'Serve un account?','Per prenotare i corsi nel gestionale è previsto l’accesso.',2);
INSERT INTO servizi (id, titolo, descrizione, immagine, ordine) VALUES
(1,'Corsi di gruppo','Allenamenti collettivi dimostrativi.','images/placeholder.svg',1),
(2,'Personal training','Percorsi individuali descritti a scopo illustrativo.','images/placeholder.svg',2);
INSERT INTO galleria (id, percorso, descrizione, ordine) VALUES
(1,'images/placeholder.svg','Immagine dimostrativa',1),
(2,'images/placeholder.svg','Anteprima dimostrativa',2);
INSERT INTO testimonianze (id, nome, commento, ordine) VALUES
(1,'Persona Demo A','Esempio di recensione per il progetto.',1),
(2,'Persona Demo B','Esperienza dimostrativa, non una testimonianza reale.',2);
INSERT INTO orari (id, giorno, orario, corsi) VALUES
(1,'Lunedì','07:00 - 21:00','Yoga Demo (08:00)'),
(2,'Martedì','07:00 - 21:00','Spinning Demo (18:00)'),
(3,'Mercoledì','07:00 - 21:00','Circuito Demo (19:00)'),
(4,'Giovedì','07:00 - 21:00','Yoga Demo (08:00)'),
(5,'Venerdì','07:00 - 21:00','Spinning Demo (18:00)'),
(6,'Sabato','09:00 - 18:00','Sessioni demo'),
(7,'Domenica','Chiuso','');
INSERT INTO istruttori (id,nome,cognome,email,telefono,specializzazione,descrizione,biografia,immagine)
VALUES
(1,'Istruttore','Demo A','trainer-a@example.invalid','0000000000','Yoga','Profilo dimostrativo','Esempio per il portfolio','images/placeholder.svg'),
(2,'Istruttore','Demo B','trainer-b@example.invalid','0000000000','Spinning','Profilo dimostrativo','Esempio per il portfolio','images/placeholder.svg');
