import os
import time
import requests
import json
from cryptography.fernet import Fernet

def collect_telemetry():
    # Collect telemetry data
    data = {
        "cpu_usage": os.popen('wmic cpu get loadpercentage').read(),
        "memory_usage": os.popen('wmic OS get FreePhysicalMemory').read()
    }
    return data

def encrypt_data(data, key):
    f = Fernet(key)
    encrypted_data = f.encrypt(json.dumps(data).encode())
    return encrypted_data

def send_data(encrypted_data):
    response = requests.post('https://phalanx.cloud/ingestion', data=encrypted_data)
    return response.status_code

if __name__ == "__main__":
    key = Fernet.generate_key()
    while True:
        telemetry_data = collect_telemetry()
        encrypted_data = encrypt_data(telemetry_data, key)
        send_data(encrypted_data)
        time.sleep(60)
