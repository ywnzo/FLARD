import { FETCH, GET_PARAMS, SPECIAL_CHARS } from "./utils.js";

var cardFrontEdit = document.querySelector('.card-front-edit');
var cardBackEdit = document.querySelector('.card-back-edit');

var cardFrontP = document.querySelector('.card-front-p');
var cardBackP = document.querySelector('.card-back-p');

var cardFrontEditInput = document.querySelector('#card-edit-front-input');
var cardBackEditInput = document.querySelector('#card-edit-back-input');

var btn_delete = document.querySelector('#btn-delete');

var params = new URLSearchParams(document.location.search);

function update_text(propName, value) {
    var formData = new FormData();
    formData.append('method', 'update');
    formData.append('table', 'cards');
    formData.append("vals", propName + " = " + GET_PARAMS(SPECIAL_CHARS(value)));
    formData.append('params', "ID = " + GET_PARAMS(params.get('card')));

    FETCH('components/crud.php', formData, () => {
    });
}

function delete_card() {
    var formData = new FormData();
    formData.append('method', 'delete');
    formData.append('table', 'cards');
    formData.append('params', "ID = " + GET_PARAMS(params.get('card')));

    FETCH('components/crud.php', formData, () => {
        window.location.replace('cards.php?set=' + params.get('set'), )
    });
}

function loadSelectedCard() {
    if(cardFrontEditInput) {
      cardFrontEditInput.value = cardFrontP.innerHTML;
      cardFrontEditInput.addEventListener('keyup', () => {
          cardFrontP.innerHTML = cardFrontEditInput.value;
      })
      cardFrontEditInput.addEventListener('change', () => {
          update_text('textFront', cardFrontEditInput.value);
      })
    }

    if(cardBackEditInput) {
      cardBackEditInput.value = cardBackP.innerHTML;
      cardBackEditInput.addEventListener('keyup', () => {
          cardBackP.innerHTML = cardBackEditInput.value;
      })
      cardBackEditInput.addEventListener('change', () => {
          update_text('textBack', cardBackEditInput.value);
      })
    }


    $('.card-wrapper').click(flip_card);

    btn_delete.addEventListener('click', () => {
        delete_card();
    })
}

function main() {
    loadSelectedCard()
}

main()
