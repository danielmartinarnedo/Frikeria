<?php require_once("./header.php"); ?>
<main class="container">
    <div class="row">
        <div class="col-12">
            <h2>Lista de Chats Privados</h2>
            <div class="container">
                <div class="row" id="listaChat">
                    <div class="card col-12 col-md-3" data-chat="${chat.id}">
                        <img class="logoUser" src="${mensaje.usuarioImg}" alt="logo de ${mensaje.usuarioNom}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require_once("./footer.php"); ?>