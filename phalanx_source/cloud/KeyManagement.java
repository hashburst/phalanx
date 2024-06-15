import com.bettercloud.vault.Vault;
import com.bettercloud.vault.VaultConfig;
import com.bettercloud.vault.response.LogicalResponse;

public class KeyManagement {
    private Vault vault;

    public KeyManagement() throws Exception {
        VaultConfig config = new VaultConfig()
                .address("http://127.0.0.1:8200")
                .token("your-vault-token")
                .build();
        vault = new Vault(config);
    }

    public String generateKey() throws Exception {
        LogicalResponse response = vault.logical().write("secret/data/keys", null);
        return response.getData().get("data").get("generated_key");
    }

    public void rotateKey() throws Exception {
        vault.logical().write("secret/data/keys/rotate", null);
    }

    public String getKey() throws Exception {
        LogicalResponse response = vault.logical().read("secret/data/keys");
        return response.getData().get("data").get("current_key");
    }
}
