var setNameInput = document.querySelector('#set-name');
var setCreateBtn = document.querySelector('#set-create');
var linkList = document.querySelector('#set-list');

var sets = [];
var links = [];

var selectedSet = null;

var btn_back = document.querySelector('.btn-back');

function saveSet(set) {
    document.cookie = set['ID']+ "=" +JSON.stringify(sets);
    // document.cookie = 
}

function loadSets() {
    var cookie = document.cookie
    if(cookie) {
        sets = JSON.parse(cookie);
        console.log('sets: ', sets);
    }
}

function removeSetLinks() {
    links.forEach(link => {
        link.remove()
    })
}

function onSetSelected(set) {
    window.open('cards.html?set=' + set['ID'], "_self")
}

function createLink(set) {
    var linkWrapper = document.createElement('div');
    linkWrapper.classList.add('row');
    linkWrapper.classList.add('link-wrapper');
    linkWrapper.addEventListener('click', () => {
        onSetSelected(set);
    })
    linkList.appendChild(linkWrapper)
    links.push(linkWrapper)

    var link = document.createElement('button')
    link.innerHTML = set['name']
    link.classList.add('link')
    linkWrapper.appendChild(link)
}

function loadSetLinks() {
    removeSetLinks()

    sets.forEach(set => {
        createLink(set)
    })
}

function onSetCreateClicked() {
    var setName = setNameInput.value;
    setNameInput.value = '';
    if(setName === '') {
        console.log('Enter name');
        return;
    }

    var newset = {
        'ID': Math.random().toString(16).slice(2),
        'name': setName,
        'cards': []
    }

    sets.push(newset)
    saveSet(newset)
    loadSetLinks();
}

function main() {
    loadSets()
    if(!sets) {
        sets = []
        saveSets()
    }
    loadSetLinks()
    setCreateBtn.addEventListener('click', () => {
        onSetCreateClicked()
    })

    btn_back.addEventListener('click', () => {
        history.back()
    })
}

main()