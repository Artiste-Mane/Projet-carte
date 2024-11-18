<?php
require_once 'includes/fonctions.php';
?>
<?php include 'includes/header.php' ?>

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Votre demande de la carte a été envoyée à l'administrateur</h3>
                <span class="breadcrumb"><a href="index.php">Acceuil</a> Votre demande de la carte a été envoyée à l'administrateur</span>
            </div>
        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>

<script>
    const jsConfetti = new JSConfetti()

    jsConfetti.addConfetti({
        confettiRadius: 6,
        confettiNumber: 500 * 3,
    })

    setTimeout(() => {
        window.location.href = 'index.php';
    }, 5000);
</script>

</body>