#### iOS Mobile Agent (ios_mobile_agent.ipa)
Per l'agente mobile iOS è necessario creare un'app utilizzando Xcode e Swift. 

**Descrizione dell'app**

- Raccolta dei Dati di Sistema: Utilizzare librerie come DeviceKit per raccogliere informazioni sul dispositivo.
- Integrazione con API Backend: Utilizzare URLSession per inviare i dati raccolti al server backend.

#### Android Mobile Agent (android_mobile_agent.apk)

Per l'agente mobile Android è necessario creare un'app utilizzando Android Studio e Java/Kotlin. 

**Descrizione dell'app**

- Raccolta dei Dati di Sistema: Utilizzare le API Android per raccogliere informazioni sul dispositivo.
- Integrazione con API Backend: Utilizzare HttpURLConnection o librerie come Retrofit per inviare i dati raccolti al server backend.

#### Note Importanti

- Autenticazione: Implementare l'autenticazione appropriata (token o altro) per assicurarsi che solo i client autorizzati possano inviare dati al backend.
- Error Handling: Aggiungere gestione degli errori robusta e logging per facilitare il debugging.
- Sicurezza: Assicurarsi che le comunicazioni tra gli agenti e il server siano protette (HTTPS).
