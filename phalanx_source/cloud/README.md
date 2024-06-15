#### Classe KeyManagement (Python)

- Prerequisiti: installare il **client Vault di HashiCorp** usando **pip**:
  
                  pip install hvac

#### Descrizione dello Script KeyManagement.py

- Importazione del **modulo hvac** ovvero del client ufficiale di **HashiCorp Vault per Python**.

- Classe KeyManagement:

          - __init__: Inizializza la connessione a Vault utilizzando l'indirizzo e il token forniti.
          
          - generate_key: Crea o aggiorna un segreto con una nuova chiave. (Nota: generated_key è un valore di esempio; dovrai implementare la tua logica di generazione delle chiavi).
          
          - rotate_key: Ruota la chiave esistente aggiornando il segreto con una nuova chiave. (Nota: rotated_key è un valore di esempio; dovrai implementare la tua logica di rotazione delle chiavi).
          
          - get_key: Recupera la chiave corrente dal percorso specificato.

- Esempio di Utilizzo:

          - Inizializza l'oggetto KeyManagement con l'indirizzo di Vault e il token.
          - Genera una nuova chiave.
          - Ruota la chiave esistente.
          - Recupera e stampa la chiave corrente.

**Nota**
Sostituire **your-vault-token** con un token di autenticazione valido e personalizzare la logica di generazione e rotazione delle chiavi in base specifiche esigenze del sistema. Inoltre, verificare che il percorso **"secret/data/keys"** corrisponda alla configurazione del Vault impiegato dal sistema.
