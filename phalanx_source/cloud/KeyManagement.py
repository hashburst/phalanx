import hvac

class KeyManagement:
    def __init__(self, vault_addr, token):
        self.client = hvac.Client(url=vault_addr, token=token)

    def generate_key(self, key_path):
        # Generate a new key at the specified path
        self.client.secrets.kv.v2.create_or_update_secret(
            path=key_path,
            secret={'generated_key': 'new-key-value'}  # Replace 'new-key-value' with your key generation logic
        )
        return f"Key generated at {key_path}"

    def rotate_key(self, key_path):
        # Rotate the key (this is an example, actual key rotation logic will depend on your requirements)
        self.client.secrets.kv.v2.create_or_update_secret(
            path=key_path,
            secret={'rotated_key': 'new-rotated-key-value'}  # Replace 'new-rotated-key-value' with your rotation logic
        )
        return f"Key rotated at {key_path}"

    def get_key(self, key_path):
        # Retrieve the current key at the specified path
        key_data = self.client.secrets.kv.v2.read_secret_version(path=key_path)
        return key_data['data']['data']

# Example usage
if __name__ == "__main__":
    vault_address = "http://127.0.0.1:8200"
    vault_token = "your-vault-token"
    key_path = "secret/data/keys"

    key_manager = KeyManagement(vault_address, vault_token)

    # Generate a new key
    print(key_manager.generate_key(key_path))

    # Rotate the key
    print(key_manager.rotate_key(key_path))

    # Get the current key
    current_key = key_manager.get_key(key_path)
    print(f"Current key: {current_key}")
