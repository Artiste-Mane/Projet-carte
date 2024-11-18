<?php
require 'includes/database.php';
require 'includes/fonctions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nom = $_POST['nom'];
  $postnom = $_POST['postnom'];
  $prenom = $_POST['prenom'];
  $profession = $_POST['profession'];
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];
  $sexe = $_POST['sexe'];
  $province = $_POST['province'];
  $commune = $_POST['commune'];
  $quartier = $_POST['quartier'];
  $photo = handleFileUpload($_FILES['photo'], 'uploads/');

  // Générer le QR code sur base du prénom, nom et postnom
  $qrCodeData = $prenom . ' ' . $nom . ' ' . $postnom;
  $qrCodeFilePath = generateQRCode($qrCodeData, 'qr-codes/');

  $stmt = $pdo->prepare('INSERT INTO clients (nom, postnom, prenom, profession, telephone, email, sexe, province, commune, quartier, photo, qrcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
  $stmt->execute([$nom, $postnom, $prenom, $profession, $telephone, $email, $sexe, $province, $commune, $quartier, $photo, $qrCodeFilePath]);

  header('Location: inscription_success.php');
  exit();
}
?>
<?php include 'includes/header.php' ?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3>Demander la carte</h3>
        <span class="breadcrumb"><a href="#">Acceuil</a> > Demander la carte</span>
      </div>
    </div>
  </div>
</div>

<div class="contact-page section">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="left-text">
          <div class="section-heading">
            <h6>Demander la carte</h6>
            <h2>Suivez le guide</h2>
          </div>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid voluptates veritatis voluptate? Unde perferendis, rerum odit hic amet officiis distinctio vel deserunt quos illo quae dolores possimus rem nisi in, adipisci ea, culpa exercitationem eaque sed quaerat iure delectus repellat!</p>
          <ul>
            <li><span>Etape 1</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur culpa esse doloribus facilis velit nobis ab mollitia, deleniti eius fugiat?</li>
            <li><span>Etape 2</span> Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit vero fugiat tempore!</li>
            <li><span>Etape 3</span> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, consectetur.</li>
          </ul>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="right-content">
          <div class="row">
            <h2>Remplissez le formulaire</h2>
            <br><br><br>
            <div class="col-lg-12">
              <form id="contact-form" enctype="multipart/form-data" method="post">
                <div class="row">
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="nom" id="nom" placeholder="Nom" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="postnom" id="postnom" placeholder="Postnom" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="prenom" id="prenom" placeholder="Prénom" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="profession" id="profession" placeholder="Profession" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="telephone" id="telephone" placeholder="Téléphone" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="E-mail" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <select name="sexe" id="sexe" required>
                        <option value="" disabled selected>Sexe</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                      </select>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="province" id="province" placeholder="Province" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="commune" id="commune" placeholder="Commune" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-6">
                    <fieldset>
                      <input type="text" name="quartier" id="quartier" placeholder="Quartier" autocomplete="on" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <input type="file" name="photo" id="photo" accept="image/*" required>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="orange-button">Soumettre le formulaire</button>
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
</div>
<?php include 'includes/footer.php' ?>