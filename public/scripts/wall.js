const $tweetMessageArea = document.getElementById('tweetMessage');
const $tweetLimitArea = document.getElementById('tweetLimit');
const TWEET_LIMIT_LENGTH = 280;
const TWEET_LIMIT_WARNING = TWEET_LIMIT_LENGTH - 20;

let charLength = 0;

const countCharacters = (str) => {
    charLength = str.length;
};

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
