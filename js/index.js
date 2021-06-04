(function() {
    // event listener for the submit button
    var submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', sendForm);

    // event listener fot the logout button
     var logoutBtn = document.getElementById('logout');
     logoutBtn.addEventListener('click', logout);
 
    // endpoint = posts
    sendRequest('../php/index.php/posts', { method: 'GET' }, loadPosts, console.log);
})();

function sendForm(event) { // prepare the info from the form to be sent to the server
    // prevent the default behavior of the clicking the submit button (because we want things to happen async)
    event.preventDefault();

    // get the values of the input fields
    var occasion = document.getElementById('occasion').value;
    var privacy = document.getElementById('privacy').value;
    var occasionDate = document.getElementById('occasionDate').value;
    var location = document.getElementById('location').value;
    var content = document.getElementById('content').value;

    // create an object with the input data
    var data = {
        occasion,
        privacy,
        occasionDate,
        location,
        content
    };

    // endpoint = addPost
    sendRequest('../php/index.php/addPost', { method: 'POST', data: `${JSON.stringify(data)}` }, addPost, handleErrors);
}

// add post with the given data in the table in the html
function addPost(postData){
    var postTable = document.getElementById('posts');
    var tr = document.createElement('tr');

    Object.values(postData).forEach(function(data) {
        var td = document.createElement('td');
        td.innerHTML = data;
        tr.appendChild(td);
    });

    postTable.appendChild(tr);
}

function loadPosts(postsData) {
    if (postsData['success']) {
        // obhojdame postovete i za vseki post dobavqme v tablicata
        postsData['data'].forEach(function (post) {
            addPost(post);
        });
    } else {
        window.location = 'login.html';
    }
}

// puts the errors in the label with id=errors, visualize in the browser
function handleErrors(errors) {
    var errorsLabel = document.getElementById('errors');

    errorsLabel.innerHTML = ''; // first we clear the old errors
    errorsLabel.style.display = 'block';
    errorsLabel.style.color = 'red';

    // there can be more than one error
    errors.forEach(function(error) { 
        errorsLabel.innerHTML += error;
    });
}

 function logout(event) {
    event.preventDefault();

    sendRequest('../php/logout.php', { method: 'GET' }, redirect, console.log);
}

function redirect() {
    window.location = 'login.html';
}