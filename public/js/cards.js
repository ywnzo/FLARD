import { FETCH , GET_PARAMS} from "./utils.js";
import { create_notification } from "./notification.js";

var params = new URLSearchParams(document.location.search);

var set_name_input = document.querySelector('#set-name-input');

var text_front_input = $('#text-front');
var text_back_input = $('#text-back');

var copy_link_btn = $('#copy-link-btn');

var currentTextFront = '';

function update_set_name() {
    var formData = new FormData();
    formData.append('method', 'update');
    formData.append('table', 'cardSets');
    formData.append("vals", 'name = "' + set_name_input.value + '"');
    formData.append('params', "ID = " + GET_PARAMS(params.get('set')));
    FETCH('components/crud.php', formData, () => {});
}

async function create_options(text) {
    $('#definitions').empty();
    var option = $('<option>').html('Looking for definitions...');
    $('#definitions').append(option);

    var definitions = await get_definition(text);
    if(!definitions) {
      setTimeout(create_options, 500);
      return;
    }

    $('#definitions').empty();
    for(var i = 0; i < definitions.length; i++) {
      var definition = definitions[i];
      var option = $('<option>').val(definition).html(definition);
      $('#definitions').append(option);
      //console.log(definition)
    }
}

async function on_text_back_focus() {
    if(text_front_input.val() === '') {
      return;
    }
    if(text_front_input.val() === currentTextFront) {
      return;
    }

    var textFront = text_front_input.val();
    textFront = textFront.split(' ');

    if(textFront.length > 1) {
      return;
    }

    currentTextFront = text_front_input.val();
    if($('.input-option-span').length === 0) {
      create_options(textFront[0]);
    }
}

function main() {
    if(set_name_input) {
      set_name_input.addEventListener('change', update_set_name);
    }

    copy_link_btn.click(function() {
      navigator.clipboard.writeText(copy_link_btn.attr('name'))
      create_notification('Link copied!');
    })

    if(text_back_input) {
      text_back_input.focus(() => {
        on_text_back_focus()
      })
    }
}

main()
