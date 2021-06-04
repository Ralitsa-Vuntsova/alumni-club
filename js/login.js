(function () {
    // event listener for the login button
    var login = document.getElementById('login');
    login.addEventListener('click', sendForm);
})();

function sendForm(event) {
    event.preventDefault();

    // get the values of the input fields
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var rememberMe = document.getElementById('remember-me').checked;

    // create an object with the user's data
    var user = {
        username,
        password,
        remember: rememberMe
    };

    sendRequest('php/login.php', { method: 'POST', data: `data=${JSON.stringify(user)}` }, load, console.log);
}

/*
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