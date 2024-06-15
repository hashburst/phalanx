import logging

logging.basicConfig(filename='phalanx.log', level=logging.INFO)

def log_event(event):
    logging.info(f"Event: {event}")

def respond_to_incident(event):
    log_event(event)
    # Incident response logic

if __name__ == "__main__":
    event = "Unauthorized access detected"
    respond_to_incident(event)
