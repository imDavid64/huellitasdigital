<?php
//NO QUITAR//
if (!defined('BASE_URL')) {
  require_once __DIR__ . '/../../../config/bootstrap.php';
}
//NO QUITAR//
?>

<!--FOOTER-->
<footer>
    <div class="pre-footer">
        <div>
            <span><strong>Contáctenos:</strong></span>
        </div>
        <div class="footer-contact">
            <div><i class="bi bi-whatsapp"></i>+506 7210 9730</div>
            <div><i class="bi bi-telephone"></i>+506 2102 8142</div>
            <div><i class="bi bi-envelope"></i>drahuellitas@gmail.com</div>
        </div>
    </div>
    <div class="footer-content">
        <div>
            <div>
                <a href="<?= BASE_URL ?>/index.php?controller=home&action=index" class="footer-logo">
                    <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Logo Veterinaria Dra.Huellitas">
                    <span>Veterinaria <br><strong>Dra.Huellitas</strong></span>
                </a>
            </div>
        </div>
        <div>
            <div class="footer-interest-links">
                <span><strong>Links de Interés</strong></span>
                <a href="<?= BASE_URL ?>/index.php?controller=aboutUS&action=index">Sobre Nosotros</a>
                <a href="<?= BASE_URL ?>/index.php?controller=aboutUS&action=index">Nuestra Misión y Visión</a>
            </div>
            <div class="social-media">
                <span><strong>Nuestras Redes Sociales</strong></span>
                <div>
                    <a href="https://www.instagram.com/drahuellitascr"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.facebook.com/drahuellitas"><i class="bi bi-facebook"></i></a>
                    <a href="https://wa.me/50672109730"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
        <div id="vet-location">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1168.1526247390802!2d-84.13922709798275!3d10.0018685338411!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8fa0fb25f08bfa0f%3A0xde176276b76b0b2b!2sVeterinaria%20Dra%20Huellitas!5e0!3m2!1ses!2scr!4v1754965379769!5m2!1ses!2scr"
                width="500" height="400" style="border-radius:10px;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>

    <div class="post-footer">
        <span>&copy; 2025 - Dra Huellitas</span>
    </div>

</footer>