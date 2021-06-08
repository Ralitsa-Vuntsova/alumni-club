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
            const message = 'Error logout user.';
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
                console.log("The post is added successfully.");
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

function redirect(path) {
    window.location = path;
}

getPosts();