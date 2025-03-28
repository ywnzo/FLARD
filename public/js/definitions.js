const url = 'https://twinword-twinword-bundle-v1.p.rapidapi.com/word_definition/?entry=';
const options = {
	method: 'GET',
	headers: {
		'x-rapidapi-key': '62b685c79dmsh461c894375a6844p1c9edbjsn9d72c8bba516',
		'x-rapidapi-host': 'twinword-twinword-bundle-v1.p.rapidapi.com'
	}
};

function capitalize(str) {
    return str.replace(/^./, char => char.toUpperCase());
}

async function parse_definition(meaning){
    console.log(meaning)
    var nouns = meaning['noun'];
    if(nouns !== '') {
        nouns = nouns.replaceAll('\n', ' ');
        nouns = nouns.split('(nou) ');
        nouns.splice(0, 1);
    }
    
    var verbs = meaning['verb'];
    if(verbs !== '') {
        verbs = verbs.replaceAll('\n', '');
        verbs = verbs.split('(vrb) ');
        verbs.splice(0, 1);
    }

    var adverbs = meaning['adverb'];
    if(adverbs !== '') {
        adverbs = adverbs.replaceAll('\n', '');
        adverbs = adverbs.split('(adv) ');
        adverbs.splice(0, 1);
    }

    var adjectives = meaning['adjective'];
    if(adjectives !== '') {
        adjectives = adjectives.replaceAll('\n', '');
        adjectives = adjectives.split('(adj) ');
        adjectives.splice(0, 1);
    }

    var arr = [];
    if(nouns[0]) {
        arr.push(capitalize(nouns[0]))
        if(nouns[1]) {
            arr.push(capitalize(nouns[1]))
        }
    }
    if(verbs[0]) {
        arr.push(capitalize(verbs[0]))
        if(verbs[1]) {
            arr.push(capitalize(verbs[1]))
        }
    }
    if(adverbs[0]) {
        arr.push(capitalize(adverbs[0]))
        if(adverbs[1]) {
            arr.push(capitalize(adverbs[1]))
        }
    }
    if(adjectives[0]) {
        if(adjectives[0] === 'not precisely limited, determined, or distinguished') {
            return ["No definitions found!"];
        }
        arr.push(capitalize(adjectives[0]))
        if(adjectives[1]) {
            arr.push(capitalize(adjectives[1]))
        }
    }

    return arr;
}


async function get_definition(word) {
    try {
        const response = await fetch(url + word, options);
        const result = await response.text();
        const data = JSON.parse(result);
        const meaning = data['meaning'];
        if(!meaning) {
            return;
        }
        return await parse_definition(meaning);
    } catch (error) {
        console.error(error);
    }
}