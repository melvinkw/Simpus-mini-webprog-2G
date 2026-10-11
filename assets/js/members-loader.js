document.addEventListener("DOMContentLoaded", function () {
    loadList({
        url: "../data/members.json",
        keys: ["member_no", "name", "address", "phone_no"]
    });
});