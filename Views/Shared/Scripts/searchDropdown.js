const searchSimilar = ['phone', 'phone case', 'phone screen protector', 'data'];
const searchSuggestionContainer = document.querySelector('.searchSuggestionContainer');
const searchInputBox = document.querySelector('#searchInputBox');
const unorderedList = document.querySelector('#unordered');

searchInputBox.addEventListener('input', (e) => {
    const userSearch = e.target.value.trim();
    if (userSearch.length === 0) {
        searchSuggestionContainer.classList.add('hidden');
        return;
    }
    searchSuggestionContainer.querySelectorAll('li')
        .forEach(item => item.remove());
    for (const product of searchSimilar) {
        if (userSearch === product.substring(0, userSearch.length)) {
            searchSuggestionContainer.classList.remove('hidden');
            addSuggestion(product);
        }
    }
});

const addSuggestion = product => {
    const listElement = document.createElement('li');
    const link = document.createElement('a');
    link.setAttribute('id', `${product}`);
    link.setAttribute('value', `${product}`);
    link.setAttribute('class', 'searchBtn');
    link.textContent = product;
    unorderedList.insertBefore(listElement, unorderedList.firstChild);
    listElement.insertBefore(link, listElement.firstChild);
}

document.addEventListener('DOMContentLoaded', function () {
    // Your code to run when the DOM is ready
    console.log('DOM is ready!');
});