const homeBtn = document.getElementById('home');

homeBtn.addEventListener('click', () => {
  redirect('../home/home.html');
})

const logoutBtn = document.getElementById('logout');

logoutBtn.addEventListener('click', () => {
  logout();
})

const submitBtn = document.getElementById('submit-button');

submitBtn.addEventListener('click', () => {
  const password = document.getElementById("password").value;
  const firstName = document.getElementById("firstName").value;
  const lastName = document.getElementById("lastName").value;
  const email = document.getElementById("email").value;

  const formData = {
    password: password,
    firstName: firstName,
    lastName: lastName,
    email: email
  };

  updateProfile(formData);
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

function redirect(path) {
  window.location = path;
}

// class User {
//   constructor(id, username, password, firstName, lastName,
//     email, role, speciality, graduationYear, groupUni, faculty) {
//     this.id = id;
//     this.username = username;
//     this.password = password;
//     this.firstName = firstName;
//     this.lastName = lastName;
//     this.email = email;
//     this.role = role;
//     this.speciality = speciality;
//     this.graduationYear = graduationYear;
//     this.groupUni = groupUni;
//     this.faculty = faculty;
//   }
// }

async function getProfileInfo() {
  fetch("../../backend/endpoints/getProfileInfo.php", {
    method: "GET",
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error loading profile info.");
      }
      return response.json();
    })
    .then((data) => {
      const userInfo = data.value;
      appendProfileInfo(userInfo);
    })
    .catch((error) => {
      console.error("Error when loading profile info: " + error);
    });
};

function appendProfileInfo(userInfo) {
  document.getElementById("username").value = userInfo.username;
  document.getElementById("password").value = userInfo.password;
  document.getElementById("firstName").value = userInfo.firstName;
  document.getElementById("lastName").value = userInfo.lastName;
  document.getElementById("email").value = userInfo.email;
  document.getElementById("speciality").value = userInfo.speciality;
  document.getElementById("graduationYear").value = userInfo.graduationYear;
  document.getElementById("groupUni").value = userInfo.groupUni;
  document.getElementById("faculty").value = userInfo.faculty;
}

async function updateProfile(formData) {
  const data = new FormData();

  fetch('../../backend/endpoints/modifyProfile.php', {
    method: 'PUT',
    headers: {
      "Content-Type": "application/json; charset=utf-8",
    },
    body: JSON.stringify(formData),
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Error updating profile info.');
      }
      return response.json();
    })
    .then((data) => {
      if (data.success === true) {
        console.log("The profile is updated successfully.");
      } else {
        console.log('The profile is NOT updated successfully.');
      }
    })
    .catch(error => {
      const message = 'Error when updating profile.';
      console.log(error);
      console.error(message);
    });
};

getProfileInfo();