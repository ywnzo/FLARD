var params = new URLSearchParams(document.location.search);

function main() {
    $('#sort-select').change(function() {
        var url = $(location).attr('href');
        if(url.length >= 1 && url.includes('set')) {
            url = url.split('&');
            url = url[0] + '&';
        } else {
            url = url.split('?');
            url = url[0] + '?'
        }
        url = url + 'o=' + $('#sort-select').val();
        window.location.replace(url);
    })

    var sort = params.get('o');
    if(sort) {
        $('#sort-select').val(sort)
    }
}

main();