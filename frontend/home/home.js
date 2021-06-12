const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', () => {
    logout();
})

const statisticsBtn = document.getElementById('statistics');

statisticsBtn.addEventListener('click', () => {
    redirect("../statistics/statistics.html");
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

async function getMyPosts() {
    fetch("../../backend/endpoints/myPosts.php", {
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
            appendMyPosts(posts);
        })
        .catch((error) => {
            console.error("Error when loading posts: " + error);
        });
};

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


function accept(postId) {
    const formData = {
        postId: postId,
        isAccepted: 1
    };

    answerPost(formData);
}

function decline(postId) {
    const formData = {
        postId: postId,
        isAccepted: 0
    };

    answerPost(formData);
}


async function answerPost(formData) {
    fetch('../../backend/endpoints/answerPost.php', {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify(formData),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error answering post.');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success === true) {
                console.log("The post is answered successfully.");
            } else {
                console.log('The post is NOT answered successfully.');
            }
        })
        .catch(error => {
            const message = 'Error when answering a post.';
            console.log(error);
            console.error(message);
        });
};

function appendPosts(posts) {
    var postSection = document.getElementById('list-of-invitations');

    Object.values(posts).forEach(function (data) {
        const { postId, ...res } = data; 
        var article = document.createElement('article');
       // console.log(data.postId);
        article.setAttribute("id", data.postId);

        var counter = 1;
        Object.values(res).forEach(function (property) {
            var paragraph = document.createElement('p');
            paragraph.innerHTML = property;
          //  console.log(property);
            article.appendChild(paragraph);

            paragraph.setAttribute('class', `prop-${counter++}`);
        });

        var buttonAccept = document.createElement('button');
        buttonAccept.innerHTML = "Приемам";
        buttonAccept.setAttribute("id", "accept-button");
        buttonAccept.setAttribute("type", "submit");
        buttonAccept.setAttribute("onclick", `accept(${data.postId})`);
        article.appendChild(buttonAccept);

        var buttonDecline = document.createElement('button');
        buttonDecline.innerHTML = "Отказвам";
        buttonDecline.setAttribute("id", "decline-button");
        buttonDecline.setAttribute("type", "submit");
        buttonDecline.setAttribute("onclick", `decline(${data.postId})`);
        article.appendChild(buttonDecline);

        postSection.appendChild(article);
    });
}

function appendMyPosts(posts) {
    var postSection = document.getElementById('list-of-my-invitations');

    Object.values(posts).forEach(function (data) {
        const { id, ...res } = data; 
        var article = document.createElement('article');

        var counter = 1;
        Object.values(res).forEach(function (property) {
            var paragraph = document.createElement('p');
            paragraph.innerHTML = property;
            console.log(property);
            article.appendChild(paragraph);

            paragraph.setAttribute('class', `prop-${counter++}`);
        });

        var buttonDelete = document.createElement('button');
        buttonDelete.innerHTML = "Изтрий";
        article.appendChild(buttonDelete);
        postSection.appendChild(article);
    });
}

async function getAllNearbyUsers() {
    fetch("../../backend/endpoints/nearbyUsers.php", {
        method: "GET",
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error loading nearby users.");
            }
            return response.json();
        })
        .then((data) => {
            // console.log(data.value);
            appendNearbyUsers(data.value);
            showMarkers(data.value);
        })
        .catch((error) => {
            console.error("Error when loading nearby users: " + error);
        });
}

function appendNearbyUsers(users) {
    var userSection = document.getElementById('nearby-alumnis');

    var counter = 1;
    Object.values(users).forEach(function (data) {
        var article = document.createElement('article');
        var markerIndex = document.createElement('p');
        markerIndex.setAttribute('class', 'marker-index');
        markerIndex.innerHTML = counter;
        article.appendChild(markerIndex);
        
        const { email, longitude, latitude, ...res } = data; // omits specific properties from an object in JavaScript
        Object.values(res).forEach(function (property) {
            var paragraph = document.createElement('p');
            paragraph.innerHTML = property;
            article.appendChild(paragraph);
        });
        userSection.appendChild(article);
        counter++;
    });
}

var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(initMap);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }

    document.getElementById("button-find-alumnis").disabled = true;
}

let map;

function updateCoordinates(position) {
    fetch('../../backend/endpoints/updateUserCoordinates.php', {
        method: 'PUT',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
        },
        body: JSON.stringify(position),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error updating coordinates.');
            }
            return response.json();
        })
        .then((data) => {
            if (data.success === true) {
                console.log("The coordinates are updated successfully.");
            } else {
                console.log('The coordinates are NOT updated successfully.');
            }
        })
        .catch(error => {
            const message = 'Error when updating coordinates.';
            console.log(error);
            console.error(message);
        });
}

function initMap(position) {
    const API_KEY = "AIzaSyDCoz_XLjdVs9EX8VHBxO3YEPiiWMznKi8";

    const currentLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
    };

    const updateCoords = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
    };

    updateCoordinates(updateCoords);

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: currentLocation,
    });

    const marker = new google.maps.Marker({
        position: currentLocation,
        map: map,
    });
    getAllNearbyUsers();
}

function showMarkers(features) {
    for (let i = 0; i < features.length; i++) {
        console.log(features[i].latitude);
        const marker = new google.maps.Marker({
            position: new google.maps.LatLng(features[i].latitude, features[i].longitude),
            label: `${i + 1}`,
            map: map,
        });
    }
}

function redirect(path) {
    window.location = path;
}

getPosts();
getMyPosts();
