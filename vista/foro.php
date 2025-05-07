<?php require_once("./header.php"); ?>
<main class="container-fluid">
    <h2 class="text-center"><?php echo $_GET["titulo"]; ?></h2>
    <section id="foro-container" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8" id="mensajes-container">
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-1 d-flex justify-content-end align-items-center">
                        <img class="logoUser" src="https://noticias.atura.mx/api/ckfinder/files/la-imagen-y-su-importancia-para-comunicar-la%20noche-estrellada-vincent-van-gogh(1).jpeg" alt="logo">
                    </div>
                    <div class="col-11 d-flex justify-items-center align-items-start">
                        <p><span class="me-2">USUARIO</span>
                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM504 312l0-64-64 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l64 0 0-64c0-13.3 10.7-24 24-24s24 10.7 24 24l0 64 64 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-64 0 0 64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" style="width: 24px; height: 24px;">
                                <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3zM471 143c9.4-9.4 24.6-9.4 33.9 0l47 47 47-47c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-47 47 47 47c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-47-47-47 47c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l47-47-47-47c-9.4-9.4-9.4-24.6 0-33.9z" />
                            </svg>
                        </p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, perferendis sequi. Nesciunt fuga a, aut eveniet, pariatur ullam blanditiis id expedita necessitatibus cum ducimus nisi sint ab! Natus, sed nihil?</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="input-foro" class="row d-flex justify-content-center align-items-center">
        <div class="col-12 col-md-8">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Escribe tu mensaje</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </section>
</main>
<script src="../src/foro.js"></script>
<?php require_once("./footer.php"); ?>