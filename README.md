# BiblioTech - Sistema di Gestione Biblioteca Scolastica

BiblioTech è un'applicazione web progettata per la gestione digitalizzata dei prestiti librari all'interno di un istituto scolastico. Il sistema sostituisce il vecchio registro cartaceo, permettendo il monitoraggio in tempo reale delle copie disponibili e la gestione differenziata tra studenti e bibliotecari.

## Caratteristiche del Progetto

* **Gestione Ruoli:** Accesso differenziato per Studenti e Bibliotecari.
* **Catalogo Real-time:** Visualizzazione immediata della disponibilità dei libri.
* **Movimentazione:**
    * *Prestito:* Decremento automatico delle copie e registrazione data.
    * *Restituzione:* Chiusura prestito e ri-incremento delle giacenze.
* **Sicurezza:**
    * Password salvate con hashing sicuro (Bcrypt).
    * Prevenzione SQL Injection tramite Prepared Statements.
    * Protezione delle sessioni.

## Requisiti

Per eseguire il progetto è necessario avere installato sulla propria macchina:
* **Docker**
* **Docker Compose**
* **Git**

## Installazione e Avvio

1.  **Clonare il repository** (o scaricare la cartella del progetto):
    ```bash
    git clone <URL_DEL_TUO_REPO>
    cd BiblioTech_Cognome
    ```

2.  **Avviare i container**:
    Eseguire il seguente comando dalla root del progetto (dove si trova il file `docker-compose.yml`):
    ```bash
    docker-compose up -d --build
    ```

3.  **Attendere l'inizializzazione**:
    Al primo avvio, il container del database impiegherà qualche secondo per importare automaticamente lo schema e i dati di test dal file `sql/database.sql`.

4.  **Accedere all'applicazione**:
    Aprire il browser all'indirizzo:
     **Web App:** [http://localhost:8080](http://localhost:8080)

## Credenziali di Test

Il sistema è pre-caricato con i seguenti utenti per testare le funzionalità:

### Area Studenti
* **Username:** `studente1`
* **Password:** `studente1`
* *(Disponibili anche `studente2` / `studente2`)*

### Area Bibliotecari
* **Username:** `biblio`
* **Password:** `biblio1`

## Gestione Database

È inclusa un'istanza di **PhpMyAdmin** per ispezionare visivamente il database.
* **URL:** [http://localhost:8081](http://localhost:8081)
* **Server:** `db`
* **Utente:** `bibliotech_user`
* **Password:** `bibliotech_pass`

## Struttura del Progetto

```text
.
├── docker/                 # Configurazione Docker (Dockerfile)
├── docs/                   # Documentazione di analisi (PDF)
├── sql/                    # Dump SQL per la creazione del DB
├── src/
│   ├── app/                # Logica backend (DB, Auth, Config)
│   └── public/             # Pagine accessibili via browser (Frontend)
├── docker-compose.yml      # Orchestrazione dei container
└── README.md               # Questo file