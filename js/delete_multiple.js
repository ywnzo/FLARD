import { FETCH} from "./utils.js";

var isSelecting = false;

function assign_events () {
    $('.list-wrapper').css('border', '2px solid var(--wrapper-active)');
    var links = document.querySelectorAll('.link');
    links.forEach(link => {
        link.style.pointerEvents = 'none';
        var wrapper = link.parentElement;
        wrapper.classList.add('wiggle');
        wrapper.addEventListener('click', delete_link, false);
        wrapper.link = link;
    });

    document.querySelector('#del-multi-btn').classList.remove('btn-main')
    document.querySelector('#del-multi-btn').classList.add('btn-main-invert')
}

function deassign_events() {
    $('.list-wrapper').css('border', '2px solid var(--wrapper-inactive)');
    var links = document.querySelectorAll('.link');
    links.forEach(link => {
        link.style.pointerEvents = 'auto';
        var wrapper = link.parentElement
        wrapper.classList.remove('wiggle');
        wrapper.removeEventListener('click', delete_link, false);
    });

    document.querySelector('#del-multi-btn').classList.remove('btn-main-invert')
    document.querySelector('#del-multi-btn').classList.add('btn-main')
}

function delete_link(e) {
    var link = e.currentTarget.link;
    var url = link.href
    var urlObj = new URL(url);
    var params = new URLSearchParams(urlObj.search);
    var setID = params.get('set');
    var cardID = params.get('card');
    
    var table = window.location.href.includes('cards') ? 'cards' : 'cardSets'
    if (table === 'cards') {
        var params = "ID = '" + cardID + "' AND " + " setID = '" + setID + "'"
    } else {
        var params = "ID = '" + setID + "'";
        // alert(params)
    }

    var formData = new FormData();
    formData.append('method', 'delete');
    formData.append('table', table);
    formData.append('params', params);
    FETCH('components/crud.php', formData, () => {  });
    link.parentElement.remove();

    var links = document.querySelectorAll('.link');
    if(links.length === 0) {
        deassign_events();
        $('#start-flashing-btn').remove()
    }
}

function activate_selecting() {
    isSelecting = true;
    assign_events();
}

function deactivate_selecting() {
    isSelecting = false;
    deassign_events();
}

function main() {
    $('#del-multi-btn').on("click", function() {
        if(!isSelecting) {
            activate_selecting();
        } else {
            deactivate_selecting();
        }
    })
}
main();
