async function loadList({ url, keys }) {
    // [PDF p.32 §4.2] Ambil elemen yang dibutuhkan
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        await new Promise((resolve) => setTimeout(resolve, 600));

        const res = await fetch(url);
        if (!res.ok) {
            throw new Error("Failed to fetch data (status " + res.status + ")");
        }
        const list = await res.json();

        list.forEach(function (item) {
            const tr = document.createElement("tr");

            let cells = "";
            keys.forEach(function (key) {
                cells += "<td>" + item[key] + "</td>";
            });

            cells +=
                "<td>" +
                '<button type="button">Edit</button> ' +
                '<button type="button" class="btn-delete">Delete</button>' +
                "</td>";

            tr.innerHTML = cells;
            tbody.appendChild(tr);
        });

    } catch (err) {
        tbody.innerHTML =
            '<tr><td colspan="' + (keys.length + 1) + '">' +
            "Failed to load data: " + err.message +
            "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}