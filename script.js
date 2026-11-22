function addProduto() {
    var area = document.getElementById("produtos-frete");
    var nova = area.firstElementChild.cloneNode(true);
    nova.querySelector("select").value = "";
    nova.querySelector("input").value = "1";
    area.appendChild(nova);
}

function delProduto(btn) {
    var area = document.getElementById("produtos-frete");
    if (area.children.length > 1) {
        btn.parentElement.parentElement.remove();
    }
}