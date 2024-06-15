#### Descrizione del File "index.php"

**Inclusione delle Dipendenze** 
- Il file index.php include il file di configurazione e il file che contiene la funzione **processData**.
- Il file index.php nel backend può gestire richieste API per elaborare i dati e gestire le chiavi crittografiche. Puoi ulteriormente estendere questo file per includere più endpoint e funzionalità in base alle tue esigenze.

**Impostazione degli Header** 
- Imposta il contenuto della risposta come JSON.
- Gestione delle Richieste: La funzione handleRequest controlla il metodo HTTP (GET, POST, PUT, DELETE) e il percorso della richiesta, e chiama le funzioni appropriate per gestirla.
- Gestione delle Richieste GET: Attualmente gestisce solo la richiesta per /api/key, recuperando la chiave dal Vault.
- Gestione delle Richieste POST: Gestisce la richiesta per /api/process, elaborando i dati forniti nel corpo della richiesta.
- Gestione delle Richieste PUT: Gestisce la richiesta per /api/key, ruotando la chiave nel Vault.
- Gestione delle Richieste DELETE: Attualmente non implementata, restituisce un errore 501.

#### Descrizione del file "config.php"

Questo file "backend/config/config.php" contiene le configurazioni necessarie per connettersi al Vault.

#### Nota sulla Classe KeyManagement

La classe KeyManagement si trova nel seguente percorso: "backend/api/key_management.php".
Occorre avere il client **hvac** installato tramite **Composer**.
L'inclusione e l'utilizzo di un client per la gestione delle chiavi crittografiche è un passaggio fondamentale per assicurare che il sistema Phalanx EDR/XDR possa gestire in modo sicuro le chiavi di cifratura utilizzate per la protezione dei dati.

**Requisiti e dipendenze**

- "require_once '../vendor/autoload.php';" è un comando in PHP che include il file **autoload** di **Composer** nello script.
- **Composer** è un gestore di dipendenze per PHP che permette di dichiarare le librerie necessarie ad un progetto PHP e di installarle facilmente. Eseguendo "composer install" in un progetto PHP, **Composer** crea una cartella **vendor** e un file **autoload.php** dentro di essa. Questo file autoload contiene tutte le classi e le librerie necessarie per il progetto, rendendo più semplice il caricamento automatico delle classi senza doverle includere manualmente una per una.
- La linea "use \Hvac\Hvac;" è una dichiarazione di utilizzo (use statement) in PHP. Questo permette di utilizzare la **classe Hvac del namespace Hvac** nello script senza dover specificare il namespace completo ogni volta che viene richiesto l'uso di quella classe.
- **Il client hvac** è una libreria PHP che facilita l'interazione con **HashiCorp Vault**, un sistema per la gestione delle chiavi segrete. Questa libreria consente di eseguire operazioni come la generazione, archiviazione, e rotazione delle chiavi crittografiche.

#### Passaggi per Configurare e Utilizzare il Client hvac

- Installare Composer: se non fosse già Composer installato, scaricarlo ed installarlo seguendo le istruzioni ufficiali.
- Creaziond ci un file composer.json nella directory principale del progetto. Ad esempio:
  
  {
      "require": {
          "some/hvac-client": "^1.0"  // Assicurarsi di usare il nome corretto del pacchetto del client hvac
      }
  }
  
- Installa le Dipendenze: eseguire il comando "composer install" nella directory del progetto per installare le dipendenze dichiarate. Questo comando, come anticipato, creerà una directory **vendor** e genererà il file **autoload.php**.
- Includere il file autoload.php nel tuo script PHP per caricare automaticamente le classi del **client hvac**: "require_once '../vendor/autoload.php';"
- Dopo aver incluso il file autoload, é possibile utilizzare il client hvac all'interno dello script:
  
          use \Hvac\Hvac;
          $hvac = new Hvac();
          // Esempio di utilizzo del client hvac
          $hvac->authenticate('your-token');
          $key = $hvac->generateKey();
  
- Sostituire, dove richiesto, **'your-token'** con il token effettivo per l'autenticazione del **client hvac**. Inoltre, il nome del pacchetto del client hvac (some/hvac-client) deve essere sostituito con il nome reale del pacchetto impiegato.
- Esempio di utilizzo della classe:

          $keyManager = new KeyManagement();
          $newKey = $keyManager->generateKey();
          echo "Generated Key: " . $newKey;
