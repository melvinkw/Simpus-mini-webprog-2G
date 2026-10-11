document.addEventListener("DOMContentLoaded", function () {
    loadList({
        url: "../data/books.json",
        keys: ["title", "author", "year", "stock", "category"] // Added "category" key
    });
});