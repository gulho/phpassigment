const username = document.querySelector('#username');
const password = document.querySelector('#password');
const counterDiv = document.querySelector('#counter_div');
const loginDiv = document.querySelector('#login');
const usernameCounter = document.querySelector('#username_counter');
const counter = document.querySelector('#counter');

function login(event) {
    axios.post("http://localhost/login", {
        username: username.value,
        password: password.value
    }).then(response => {
        counter.innerHTML = response.data.count;
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token;
        loginDiv.style.display = 'none';
        counterDiv.style.display = 'block';
        usernameCounter.value = username.value;

    })
}

function logout() {
    axios.defaults.headers.common['Authorization'] = null;
    loginDiv.style.display = 'block';
    counterDiv.style.display = 'none';
}

function addOneMore() {
    axios.post("http://localhost/addonemore", {})
        .then(
            response => {
                console.log(response.data);
                counter.innerHTML = response.data.count;
            }
        );
}