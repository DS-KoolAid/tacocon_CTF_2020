document.getElementById("stockCheckForm").addEventListener("submit", function(e) {
    checkStock(this.getAttribute("method"), this.getAttribute("action"), new FormData(this));
    e.preventDefault();
});

function checkStock(method, path, data) {
    const retry = (tries) => tries == 0
        ? null
        : fetch(
            path,
            {
                method,
                headers: { 'Content-Type': window.contentType },
                body: payload(data)
            }
          )
            .then(res => res.status == 200
                ? res.text().then(t => t + " units")
                : "Could not fetch stock levels!"
            )
            .then(res => document.getElementById("stockCheckResult").innerHTML = res)
            .catch(e => retry(tries - 1));

    retry(3);
}