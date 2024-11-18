<?php
require 'includes/database.php';
require 'includes/fonctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare('SELECT id FROM administrateur WHERE email = ? AND password = ?');
  $stmt->execute([$email, $password]);

  if ($stmt->rowCount() > 0) {
    $_SESSION['user_id'] = $stmt->fetch()['id'];
    header('Location: index.php');
    exit();
  } else {
    $error = 'Identifiants incorrects';
  }
}
?>
<?php include 'includes/header.php' ?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3>Page de connexion</h3>
        <span class="breadcrumb"><a href="index.php">Acceuil</a> > Page de connexion </span>
      </div>
    </div>
  </div>
</div>

<div class="contact-page section">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="right-content w-100">
          <div class="" style="margin: 0 auto!important;">
            <form id="contact-form" method="post">
              <div class="row">
                <div class="col-lg-6">
                  <fieldset>
                    <input type="email" name="email" id="email" placeholder="Email..." aria-autocomplete="off" autocomplete="off" required>
                  </fieldset>
                </div>
                <div class="col-lg-6">
                  <fieldset>
                    <input type="password" name="password" id="password" placeholder="Mot de passe..." aria-autocomplete="off" autocomplete="off" required>
                  </fieldset>
                </div>

                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="orange-button">Send Message Now</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php' ?>