const $tweetMessageArea = document.getElementById('tweetMessage');
const $tweetLimitArea = document.getElementById('tweetLimit');
const $tweetButton = document.getElementById('submitForm');

const $filterBySentenceInput = document.getElementById('filter-by-sentence');
const $filterByDateInput = document.getElementById('filter-by-date');
const $filterButton = document.getElementById('filter-button');

const TWEET_LIMIT_LENGTH = 280;
const TWEET_LIMIT_WARNING = TWEET_LIMIT_LENGTH - 20;

let charLength = 0;
let currentURL = new URL(location.href);
let sentence = currentURL.searchParams.get('sentence');
let date = currentURL.searchParams.get('date');

if (sentence) {
    $filterBySentenceInput.value = sentence;
}

if (date) {
    $filterByDateInput.value = date;
}

const countCharacters = (str) => {
    charLength = str.length;
};

const prepareFiltersURL = () => new Promise((resolve) => {
    const sentence = $filterBySentenceInput.value;
    const date = $filterByDateInput.value;

    if (sentence && date) {
        resolve(`${MAIN_ENDPOINT}?sentence=${encodeURIComponent(sentence)}&date=${encodeURIComponent(date)}`);
    } else if (sentence) {
        resolve(`${MAIN_ENDPOINT}?sentence=${encodeURIComponent(sentence)}`);
    } else if (date) {
        resolve(`${MAIN_ENDPOINT}?date=${encodeURIComponent(date)}`);
    } else {
        resolve(MAIN_ENDPOINT);
    }
});

$filterButton.addEventListener('click', async (event) => {
    event.preventDefault();

    await prepareFiltersURL()
    .then(data => location.href = encodeURI(data));

}, false);

$tweetMessageArea.addEventListener('keyup', () => {
    countCharacters($tweetMessageArea.value);
    $tweetLimitArea.innerHTML = `${charLength}/${TWEET_LIMIT_LENGTH} characters`;

    if (charLength >= TWEET_LIMIT_WARNING) {
        if (!$tweetLimitArea.classList.contains('tweet-limit-message-red')) {
            $tweetLimitArea.classList.add('tweet-limit-message-red');
        }
    }
    else {
        if ($tweetLimitArea.classList.contains('tweet-limit-message-red')) {
            $tweetLimitArea.classList.remove('tweet-limit-message-red');
        }
    }
});

$tweetButton.addEventListener('click', (event) => {
    event.preventDefault();

    const message = {
        'text': $tweetMessageArea.value,
    }

    fetch(TWEET_MESSAGE_ENDPOINT, {
        method: 'post',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(message)
    })
    .then((res) => res.json())
    .then((data) => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.data.message);
        }
    })
    .catch((error) => console.log(error));
}, false);
