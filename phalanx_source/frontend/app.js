document.addEventListener("DOMContentLoaded", function() {
    const appDiv = document.getElementById("app");
    appDiv.innerHTML = `
        <form id="loginForm">
            <h2>Login</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    `;

    const loginForm = document.getElementById("loginForm");
    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();
        // Perform AJAX request to authenticate the user
        fetch('/api/auth.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                username: document.getElementById("username").value,
                password: document.getElementById("password").value
            })
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  appDiv.innerHTML = `<h2>Welcome, ${data.username}!</h2>`;
              } else {
                  alert("Invalid credentials");
              }
          });
    });
});
