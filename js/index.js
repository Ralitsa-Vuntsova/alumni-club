(function() {
    var submitButton = document.getElementById('submit');
    submitButton.addEventListener('click', sendForm);

    /**
     * Get the logout button
     */
     var logoutBtn = document.getElementById('logout');
     /**
      * Listen for click event on the logout button
      */
     logoutBtn.addEventListener('click', logout);

    // TODO: Send request for getting all students' marks
    sendRequest('src/index.php/students', {method: 'GET'}, loadStudents, console.log);
})();

function sendForm(event) { // prepare the info from the form to be sent to the server
    /**
     * Prevent the default behavior of the clicking the form submit button (because we want things to happen async)
     */
    event.preventDefault();

    var firstName = document.getElementById('first-name').value;
    var lastName = document.getElementById('last-name').value;
    var fn = document.getElementById('fn').value;
    var mark = document.getElementById('mark').value;

    var data = {
        firstName,
        lastName,
        fn,
        mark
    };

    sendRequest('src/index.php/addStudent', 'POST', `data=${JSON.stringify(data)}`, addStudentMark, handleErrors);
}

/*
function sendForm(event) {
    event.preventDefault();

    var occasion = document.getElementById('occasion').value;
    var privacy = document.getElementById('privacy').value;
    var occasionDate = document.getElementById('occasionDate').value;
    var location = document.getElementById('location').value;
    var content = document.getElementById('content').value;

    var data = {
        occasion,
        privacy,
        occasionDate,
        location,
        content
    };

    sendRequest('index.php', 'POST', `data=${JSON.stringify(data)}`);
    // sendRequest('php/index.php/addPost', 'POST', `data=${JSON.stringify(data)}`, addPost, handleErrors);
}
*/

function sendRequest(url, method, data){ // sends async request to the server
    var request = new XMLHttpRequest();

    // adding event listener - listens for an answer from the server
    request.addEventListener('load', function(){
        var response = JSON.parse(request.responseText); // convert to JSON

        if(request.status === 200){
            addStudentMark(response); // response = array of student data
        } else {
            handleErrors(response); // response = array of errors
        }
    })

    // sending the info to the server
    request.open(method, url, true);
    request.setRequestHeader('Content-Tpe', 'application/x-www-form-urlencoded'); // pointing out what type of data we are sending
    request.send(data);
}

/*
function sendRequest(url, method, data){
    var request = new XMLHttpRequest();

    request.addEventListener('load', function(){
        var response = JSON.parse(request.responseText);

        if(request.status === 200){
            addPost(response);
        } else {
            handleErrors(response);
        }
    })

    request.open(method, url, true);
    request.setRequestHeader('Content-Tpe', 'application/x-www-form-urlencoded'); // what type of data we are sending
    request.send(data);
}
*/

// adds student with the given data in the table in the html 
function addStudentMark(studentData) {
    var studentTable = document.getElementById('marks');
    var tr = document.createElement('tr');

    Object.values(studentData).forEach(function(data) {
        var td = document.createElement('td');
        td.innerHTML = data;
        tr.appendChild(td);
    });

    studentTable.appendChild(tr);
}

/*
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
*/

function loadStudents(studentsData) {
    if (studentsData['success']) {
        studentsData['data'].forEach(function (student) {
            addStudentMark(student);
        });
    } else {
        console.log(studentsData['data']);
        window.location = 'login.html';
    }
}

// same for our system
// puts the errors in the label with id=errors, visualize in the browser
function handleErrors(errors) {
    var errorsLabel = document.getElementById('errors');

    errorsLabel.innerHTML = ''; // first we clear the old errors
    errorsLabel.style.display = 'block';
    errorsLabel.style.color = 'red';

    errors.forEach(function(error) { 
        errorsLabel.innerHTML += error;
    });
}

/**
 * Handle the click event by sending an async request to the server
 */
 function logout(event) {
    /**
     * Prevent the default behavior of the clicking the form submit button
     */
    event.preventDefault();

    /**
     * Send GET request to api.php/logout to logout the user
     */
    sendRequest('src/logout.php', {method: 'GET'}, redirect, console.log);

}

function redirect() {
    window.location = 'login.html';
}