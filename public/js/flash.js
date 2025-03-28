import { FETCH, GET_PARAMS, RAND_INT } from "./utils.js";

var params = new URLSearchParams(document.location.search);

var btn_backward = document.querySelector('#btn-backward');
var btn_forward = document.querySelector('#btn-forward');

var index_btn_wrapper = document.querySelector('#index-btn-wrapper');
var index_btns = [];

var cards = [];
var currentIndex = 0;

var isLoaded = false;

function shuffle() {
    var shuffled = [];
    while (cards.length > 0) {
        var randIndex = Math.floor(Math.random() * cards.length);
        shuffled.push(cards.splice(randIndex, 1)[0]);
    }
    return shuffled
}

async function get_cards() {
    var formData = new FormData();
    formData.append('method', 'select');
    formData.append('table', 'cards');
    formData.append("cols", "*");
    formData.append('params', "setID = " + GET_PARAMS(params.get('set')));
    cards = await FETCH('components/crud.php', formData, () => { });
    cards = JSON.parse(cards);
    console.log(cards)

    if(Array.isArray(cards)) {
        cards = shuffle();
    } else {
        var arr = [];
        arr.push(cards);
        cards = arr;
    }
}

function activate_index_btn(index) {
    index_btns.forEach(btn => {
        btn.classList.remove('index-btn-active');
    })

    if(index_btns == []) {
        return;
    }

    index_btns[index].classList.add('index-btn-active');
    index_btns[index].scrollIntoView({behavior: 'smooth', block: 'end', inline: 'center' })
    document.body.scroll(0, 0)

    if(index === 0) {
        $('#btn-backward').hide()
        $('#btn-forward').show()
    } else if(index === cards.length - 1) {
        $('#btn-backward').show()
        $('#btn-forward').hide()
    } else {
        $('#btn-backward').show()
        $('#btn-forward').show()

    }
}

function on_index_btn_pressed(index) {
    if(currentIndex === index) {
        return;
    }
    load_card(index);
    activate_index_btn(index);
}

async function create_index_btns() {
    var count = cards.length;
    index_btn_wrapper.style.justifyContent = count > 4 ? 'start' : 'center';

    for (let i = 0; i < count; i++) {
        var btn = document.createElement('btn');
        btn.innerHTML = i + 1;
        btn.classList.add('index-btn');
        btn.addEventListener('click', () => {
            on_index_btn_pressed(i);
        })
        index_btn_wrapper.appendChild(btn);
        index_btns.push(btn)
    }
}

function load_text(index) {
    if(Array.isArray(cards)) {
        $('.card-front-p').html(cards[index]['textFront']);
        $('.card-back-p').html(cards[index]['textBack']);
    }
}

async function load_card(index) {
    var template = $('#template-card').html();

    if(isLoaded) {
        $('.card-wrapper').fadeOut("fast", function() {
            $('#flash-wrapper').remove();
            $('.content-wrapper').append(template)
            $('.card-wrapper').fadeIn("fast", () => {
                $('.card-wrapper').click(flip_card);
            })
            load_text(index)
        })
    } else {
        $('.content-wrapper').append(template)
        $('.card-wrapper').fadeIn("fast")
        $('.card-wrapper').click(flip_card);
        load_text(index)
    }

    isFlipped = false;

    activate_index_btn(index);
    currentIndex = index;
}

async function main() {
    await get_cards();
    await create_index_btns();
    await load_card(0)
    isLoaded = true;

    if(cards.length <= 1) {
        return;
    }
    btn_forward.addEventListener('click', () => {
        if(currentIndex + 1 >= cards.length - 1) {
            load_card(cards.length - 1);
        } else {
            load_card(currentIndex + 1)
        }
    })
    btn_backward.addEventListener('click', () => {
        if(currentIndex - 1 <= 0) {
            load_card(0);
        } else {
            load_card(currentIndex - 1)
        }
    })

    $('#btn-shuffle').click(function() {
        location.reload()
    })
}

if(window.location.href.includes('flash.php')) {
  main();
}
