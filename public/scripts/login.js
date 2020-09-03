const $emailInput = document.getElementById('emailInput');
const $passwordInput = document.getElementById('passwordInput');
const $submitButton = document.getElementById('submitForm');

const LOGIN_USER_ENDPOINT = 'http://localhost:8080/twitter_clone/public/loginUser.php';
const MAIN_ENDPOINT = 'http://localhost:8080/twitter_clone/public/wall.php';

$submitButton.addEventListener('click', (event) => {
    event.preventDefault();

    const user = {
        'email': $emailInput.value,
        'password': $passwordInput.value,
    }

    fetch(LOGIN_USER_ENDPOINT, {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    })
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        window.location.href = MAIN_ENDPOINT;
    })
    .catch((error) => console.log(error));

}, false);
