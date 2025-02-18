var searchBar = document.querySelector('#search-bar');

function search() {
    var value = searchBar.value.toLowerCase();
    var links = document.querySelectorAll('.link');
    for(var i = 0; i < links.length; i++) {
        var link = links[i];
        var linkValue = link.innerHTML.toLowerCase();

        if(!value || value === '') {
            link.parentElement.style.display = 'block';
            continue;
        }

        if(!linkValue.includes(value)) {
            link.parentElement.style.display = 'none';
        } else {
            link.parentElement.style.display = 'block';
        }
    }
}

function main() {
    searchBar.addEventListener('keyup', function() {
        search();
    })
}
main();