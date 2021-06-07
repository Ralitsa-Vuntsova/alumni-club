// (function() {
//     // event listener for the submit button
//     var submitButton = document.getElementById('submit');
//     submitButton.addEventListener('click', sendForm);

//     // event listener fot the logout button
//     var logoutBtn = document.getElementById('logout');
//     logoutBtn.addEventListener('click', logout);

//     // endpoint = posts
//     sendRequest('../backend/endpoints/postEndpoint.php', { method: 'GET' }, loadPosts, console.log);
// })();

const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', () => {
    logout();
})

function logout() {
    fetch('../../backend/endpoints/logout.php', {
        method: 'GET'
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error logout user.');
            }
            return response.json();
        })
        .then(response => {
            if (response.success) {
                redirect('../login/login.html');
            }
        })
        .catch(error => {
            const message = 'Грешка при изход на потребител.';
            console.error(message);
        });

}

const profileBtn = document.getElementById('profile');

profileBtn.addEventListener('click', () => {
    redirect('../profile/profile.html');
})

const submitPostBtn = document.getElementById('submit');

submitPostBtn.addEventListener('click', () => {
    const occasion = document.getElementById('occasion').value;
    const privacy = document.getElementById('privacy').value;
    const occasionDate = document.getElementById('occasionDate').value;
    const location = document.getElementById('location').value;
    const content = document.getElementById('content').value;

    const formData = {
        occasion: occasion,
        privacy: privacy,
        occasionDate: occasionDate,
        location: location,
        content: content
    };

    createPost(formData);
})


async function getPosts() {
    fetch("../../backend/endpoints/getAllPostsEndpoint.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error loading posts.");
            }
            return response.json();
        })
        .then((data) => {
            posts = data.value;
            appendPosts(posts);
        })
        .catch((error) => {
            console.error("Error when loading posts: " + error);
        });
};

// fetch('https://example.com/profile', {
//   method: 'POST', // or 'PUT'
//   headers: {
//     'Content-Type': 'application/json',
//   },
//   body: JSON.stringify(data),
// })

async function createPost(formData) {
    const data = new FormData();

    fetch('../../backend/endpoints/createPostEndpoint.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify(formData),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error creating post.');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success === true) {
                console.log("The post is added successfully!");
            } else {
                console.log('The post is NOT added successfully.');
            }
        })
        .catch(error => {
            const message = 'Error when creating a post.';
            console.log(error);
            console.error(message);
        });
};


// function placePosts(posts) {
//     posts.forEach((post) => {
//         const element = document.getElementById(hall.number);
//         if (element) {
//             element.innerHTML = hall.number + "<br>" + hall.type;
//         }
//     });
// }

// add post with the given data in the table in the html
function appendPosts(posts) {
    var postSection = document.getElementById('list-of-invitations');

    Object.values(posts).forEach(function (data) {
        var article = document.createElement('article');
        Object.values(data).forEach(function (property) {
            var paragraph = document.createElement('p');
            paragraph.innerHTML = property;
            article.appendChild(paragraph);
        });
        postSection.appendChild(article);
    });

}
// function sendForm(event) { // prepare the info from the form to be sent to the server
//     // prevent the default behavior of the clicking the submit button (because we want things to happen async)
//     event.preventDefault();

//     // get the values of the input fields
//     var occasion = document.getElementById('occasion').value;
//     var privacy = document.getElementById('privacy').value;
//     var occasionDate = document.getElementById('occasionDate').value;
//     var location = document.getElementById('location').value;
//     var content = document.getElementById('content').value;

//     // create an object with the input data
//     var data = {
//         occasion,
//         privacy,
//         occasionDate,
//         location,
//         content
//     };

//     // endpoint = addPost
//     console.log(data);
//     sendRequest('../php/index.php/addPost', { method: 'POST', data: `${JSON.stringify(data)}` }, addPost, handleErrors);
// }


// function loadPosts(postsData) {
//     if (postsData['success']) {
//         // obhojdame postovete i za vseki post dobavqme v tablicata
//         postsData['data'].forEach(function(post) {
//             addPost(post);
//         });
//     } else {
//         window.location = 'login.html';
//     }
// }

// puts the errors in the label with id=errors, visualize in the browser
function handleErrors(errors) {
    var errorsLabel = document.getElementById('errors');

    errorsLabel.innerHTML = ''; // first we clear the old errors
    errorsLabel.style.display = 'block';
    errorsLabel.style.color = 'red';

    // there can be more than one error
    errors.forEach(function (error) {
        errorsLabel.innerHTML += error;
    });
}

// function logout(event) {
//     event.preventDefault();

//     sendRequest('../php/logout.php', { method: 'GET' }, redirect, console.log);
// }

function redirect(path) {
    window.location = path;
}

getPosts();