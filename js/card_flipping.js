var cardWrapper = document.querySelector('.card-wrapper');
var isFlipped = false;

function flip_to_back() {
    var card = document.querySelector('.card');
    card.style.transform = 'rotateY(180deg)';
    isFlipped = true;
}

function flip_to_front() {
    var card = document.querySelector('.card');
    card.style.transform = 'rotateY(0deg)';
    isFlipped = false;
}

function flip_card() {
    if(!isFlipped) {
        flip_to_back();
    } else {
        flip_to_front();
    }
}

// function main() {
//     cardWrapper.addEventListener('click', () => {
//         flip_card();
//     })
// }

// main();