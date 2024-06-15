import os
import psutil
import requests
import time
import json

SERVER_URL = "http://your-backend-server/api/process"
SLEEP_INTERVAL = 60  # seconds

def collect_system_data():
    data = {
        "cpu_usage": psutil.cpu_percent(interval=1),
        "memory_usage": psutil.virtual_memory().used / (1024 * 1024),  # in MB
        "disk_usage": psutil.disk_usage('/').percent,
        "network_activity": psutil.net_io_counters().bytes_sent + psutil.net_io_counters().bytes_recv,
        "os": "macOS"
    }
    return data

def send_data_to_server(data):
    try:
        headers = {'Content-Type': 'application/json'}
        response = requests.post(SERVER_URL, data=json.dumps(data), headers=headers)
        if response.status_code == 200:
            print("Data sent successfully")
        else:
            print(f"Failed to send data: {response.status_code}")
    except Exception as e:
        print(f"Error sending data: {e}")

def main():
    while True:
        data = collect_system_data()
        send_data_to_server(data)
        time.sleep(SLEEP_INTERVAL)

if __name__ == "__main__":
    main()
