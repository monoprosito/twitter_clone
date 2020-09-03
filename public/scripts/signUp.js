const $usernameInput = document.getElementById('usernameInput');
const $emailInput = document.getElementById('emailInput');
const $passwordInput = document.getElementById('passwordInput');
const $phoneNumberInput = document.getElementById('phoneNumberInput');
const $submitButton = document.getElementById('submitForm');

const REGISTER_USER_ENDPOINT = 'http://localhost:8080/twitter_clone/public/registerUser.php';

$submitButton.addEventListener('click', (event) => {
    event.preventDefault();

    const user = {
        'username': $usernameInput.value,
        'email': $emailInput.value,
        'password': $passwordInput.value,
        'phoneNumber': $phoneNumberInput.value,
    }

    fetch(REGISTER_USER_ENDPOINT, {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(user)
    })
    .then((res) => res.json())
    .then((data) => console.log(data))
    .catch((error) => console.log(error));

}, false);
