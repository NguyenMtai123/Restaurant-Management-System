document.addEventListener("DOMContentLoaded", function() {
    const tablesDiv = document.getElementById("tables");

    fetch("/api/tables")
        .then(res => res.json())
        .then(data => {
            tablesDiv.innerHTML = data.map(t =>
                `<p>Bàn ${t.name} – ${t.status}</p>`
            ).join("");
        })
        .catch(err => console.error(err));
});
