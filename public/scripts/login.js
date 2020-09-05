const $emailInput = document.getElementById('emailInput');
const $passwordInput = document.getElementById('passwordInput');
const $submitButton = document.getElementById('submitForm');

const LOGIN_USER_ENDPOINT = 'loginUser.php';
const MAIN_ENDPOINT = 'wall.php';

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
        if (data.success) {
            window.location.href = MAIN_ENDPOINT;
        } else {
            alert(data.data.message);
        }
    })
    .catch((error) => console.log(error));

}, false);
