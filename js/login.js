(function () {
    /**
     * Get the login button
     */
    var login = document.getElementById('login');

    /**
     * Listen for click event on the login button
     */
    login.addEventListener('click', sendForm);
})();

/**
 * Handle the click event by sending an asynchronous request to the server
 */
function sendForm(event) {
    /**
     * Prevent the default behavior of the clicking the form submit button
     */
    event.preventDefault();

    /**
     * Get the values of the input fields
     */
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var rememberMe = document.getElementById('remember-me').checked;

    /**
     * Create an object with the user's data
     */
    var user = {
        username,
        password,
        remember: rememberMe
    };

    /**
     * Send POST request with user's data to the server
     */
    sendRequest('php/login.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
}

/**
 * Handle the received response from the server
 * If there were no errors found on validation, the index.html is loaded.
 * Else the errors are displayed to the user.
 */
function load(response) {
    console.log(response)
    if (response.success) {
        window.location = 'index.html';
    } else {
        var errors = document.getElementById('errors');
        errors.innerHTML = response.data;
    }
}