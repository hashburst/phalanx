import ssl
import socket

context = ssl.create_default_context()

with socket.create_connection(("example.com", 443)) as sock:
    with context.wrap_socket(sock, server_hostname="example.com") as ssock:
        print(ssock.version())
