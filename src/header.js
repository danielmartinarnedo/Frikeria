document.ready(function () {
    const name = "John";

    fetch(`../controladores/src.php?action=conseguirUsuario`)
        .then(response => response.text())
        .then(data => {
            console.log(data); // Output: Hello, John
            document.getElementById("output").innerText = data;
        });
})   