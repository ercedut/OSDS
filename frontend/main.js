document.addEventListener('DOMContentLoaded', function() {
    let loginForm = document.querySelector('form');
    let usernameField = document.querySelector('input[name="username"]');
    let passwordField = document.querySelector('input[name="password"]');
    let desKeyField = document.querySelector('input[name="des_key"]');
    
    loginForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        let requestData = {
            username: usernameField.value,
            password: passwordField.value,
            des_key: desKeyField.value
        };
        
        fetch('/backend/auth', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/dashboard';
            } else {
                alert('login failed');
            }
        })
        .catch(() => alert('error processing request'));
    });
});
