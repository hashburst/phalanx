<?php

require_once '../vendor/autoload.php'; // Assicurati di avere il client hvac installato tramite Composer
use \Hvac\Hvac;

class KeyManagement {
    private $client;
    
    public function __construct($vault_addr, $token) {
        $this->client = new Hvac\Client(['address' => $vault_addr]);
        $this->client->setToken($token);
    }

    public function generate_key($key_path) {
        $this->client->write($key_path, ['generated_key' => 'new-key-value']);
        return "Key generated at $key_path";
    }

    public function rotate_key($key_path) {
        $this->client->write($key_path, ['rotated_key' => 'new-rotated-key-value']);
        return "Key rotated at $key_path";
    }

    public function get_key($key_path) {
        $key_data = $this->client->read($key_path);
        return $key_data['data'];
    }
}

?>
