<?php
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
  header('Location: cartes.php');
  exit();
}

$stmt = $pdo->prepare('SELECT * FROM clients WHERE id = ?');
$stmt->execute([$_GET['id']]);
$client = $stmt->fetch();

if (!$client) {
  header('Location: cartes.php');
  exit();
}

// Gérer la soumission du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update'])) {
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

    // Vérifier si une nouvelle photo a été uploadée
    if ($_FILES['photo']['size'] > 0) {
      $photo = handleFileUpload($_FILES['photo'], 'uploads/');
    } else {
      $photo = $client['photo'];
    }

    // Vérifier si le nom, postnom ou prénom ont changé
    if ($nom !== $client['nom'] || $postnom !== $client['postnom'] || $prenom !== $client['prenom']) {
      // Supprimer l'ancien QR code
      if (file_exists($client['qrcode'])) {
        unlink($client['qrcode']);
      }

      // Générer un nouveau QR code
      $qrCodeData = $prenom . ' ' . $nom . ' ' . $postnom;
      $qrCodeFilePath = generateQRCode($qrCodeData, 'qr-codes/');
    } else {
      $qrCodeFilePath = $client['qrcode']; // Conserver l'ancien QR code
    }

    // Mettre à jour les informations du client dans la base de données
    $stmt = $pdo->prepare('UPDATE clients SET nom = ?, postnom = ?, prenom = ?, profession = ?, telephone = ?, email = ?, sexe = ?, province = ?, commune = ?, quartier = ?, photo = ?, qrcode = ? WHERE id = ?');
    $stmt->execute([$nom, $postnom, $prenom, $profession, $telephone, $email, $sexe, $province, $commune, $quartier, $photo, $qrCodeFilePath, $client['id']]);

    header('Location: carte.php?id=' . $client['id']);
    exit();
  }
}

// Gérer la suppression du client
if (isset($_POST['delete'])) {
  // Supprimer le QR code associé
  if (file_exists($client['qrcode'])) {
    unlink($client['qrcode']);
  }

  // Supprimer le client de la base de données
  $stmt = $pdo->prepare('DELETE FROM clients WHERE id = ?');
  $stmt->execute([$client['id']]);

  header('Location: cartes.php');
  exit();
}
?>

<?php include 'includes/header.php' ?>
<style>
  label {
    margin: 15px auto;
    text-align: center;
    display: inline-block;
    width: 100%;
  }

  .btn {
    display: inline-block;
    height: 50px;
    line-height: 50px;
    background-color: #ee626b;
    color: #fff;
    font-size: 15px;
    text-transform: uppercase;
    font-weight: 500;
    padding: 0px 25px;
    border: none;
    border-radius: 25px;
    transition: all 0.3s;
  }

  p {

    margin-top: auto !important;
    margin-bottom: auto !important;

  }

  h1,
  h2,
  p {
    margin: 0;
  }

  h1 {
    font-family: 'Arvo', serif;
    font-weight: lighter;
    font-size: 25px;
  }

  .cardtitle {
    font-family: 'Bitter', serif;
    font-weight: bold;
  }

  p {
    font-family: 'Lato', sans-serif;
    display: inline-block;
    margin: 5px 1px;
    font-size: 15px;
  }

  #business-card {
    border: solid 1px #000;
    border-radius: 10px;
    box-shadow: 1px 2px 20px rgba(0, 0, 0, 0.2);
    background-color: #E9EEF2;
    margin: auto;

  }

  #card-title {
    padding: 5px;
    color: #fff;
    letter-spacing: 2px;
    text-align: center;
    text-transform: uppercase;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    background-image: url(../assets/images/page-heading-bg.jpg);
  }

  #card-id {
    padding: 5px;
    display: flex;
  }

  #card-number {
    display: inherit;
    margin-right: 50px;
  }

  #card-information {
    display: flex;
    padding: 5px;
  }

  #card-photo {
    background-position: center;
    background-repeat: none;
    background-size: cover;
    border: solid 2px #000;
    height: 162px;
    width: 150px;
    margin-right: 10px;
    border-radius: 5px;
  }

  #card-detail {
    display: flex;

  }

  .card-box {
    margin-right: 20px;
  }

  #cardsign {
    background: no-repeat url(https://fontmeme.com/permalink/200329/2719511201202ec68d51bbc66ea58d25.png);
    background-position: left;
    background-size: contain;
    height: 50px;
    /* width: 350px; */
  }

  #card-code {
    padding: 5px;
    background-color: #fff;
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
  }
</style>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3><?= $client['prenom'] ?> <?= $client['nom'] ?> <?= $client['postnom'] ?></h3>
        <span class="breadcrumb"><a href="index.php">Acceuil</a> > <a href="cartes.php">Cartes</a> > <?= $client['prenom'] ?> <?= $client['nom'] ?> <?= $client['postnom'] ?></span>
      </div>
    </div>
  </div>
</div>


<div class="single-product section">

  <div class="container">

    <div class="row">
      <div class="col-lg-7">

        <div id="business-card">
          <div id="card-title">
            <h1>République Démocratique du Congo</h1>
          </div>
          <div id="card-id">
            <div id="card-number">
              <p class="cardtitle">Numéro de la carte :</p>
              <p><?= $client['id']; ?></p>
            </div>
            <p class="cardtitle">Nationalité Congolaise</p>
          </div>
          <div id="card-information">
            <div id="card-photo" style="background-image: url(./<?= $client['photo']; ?>)"></div>
            <div id="card-text">
              <div id="card-name">
                <div class="card-box"></div>
                <p class="cardtitle">Nom :</p>
                <p><?= $client['nom'] ?></p>
                <div class="card-box"></div>
                <p class="cardtitle">Prénom :</p>
                <p><?= $client['prenom'] ?></p>
                <p class="cardtitle">Email :</p>
                <p><?= $client['email'] ?></p>
              </div>
              <div id="card-detail">
                <div class="card-box">
                  <p class="cardtitle">Sexe :</p>
                  <p><?= $client['sexe'] ?></p>
                </div>
                <div class="card-box">
                  <p class="cardtitle">Telephone :</p>
                  <p><?= $client['telephone'] ?></p>
                </div>
                <div class="card-box">
                  <p class="cardtitle">Province :</p>
                  <p><?= $client['province'] ?></p>
                </div>
                <div class="card-box">
                  <p class="cardtitle">Commune :</p>
                  <p><?= $client['commune'] ?></p>
                </div><br>
                <div class="card-box">
                  <p class="cardtitle">Quartier :</p>
                  <p><?= $client['quartier'] ?></p>
                </div>
              </div>
              <div id="card-sign">
                <p class="cardtitle">QrCode :</p>
                <div id="cardsign" style="background-image: url(./<?= $client['qrcode']; ?>)"></div>
              </div>
            </div>
          </div>
          <div id="card-code">
            <p>
              <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< <<<<<<<<<<<<<<<<<<<<<<<< </p>
          </div>
        </div>
        <br>
        <button class="btn" onclick="downloadCard('png')">Télécharger en PNG</button>
        <button class="btn" onclick="downloadCard('pdf')">Télécharger en PDF</button>

      </div>
      <div class="col-lg-5 align-self-center">

        <!-- Formulaire de modification -->
        <h4>Modifier les informations du client</h4>
        <form action="carte.php?id=<?= $client['id'] ?>" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <fieldset>
                <label for="nom">Nom</label>
                <input style="width: 100%!important;" type="text" name="nom" id="nom" value="<?= $client['nom'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="postnom">Postnom</label>
                <input style="width: 100%!important;" type="text" name="postnom" id="postnom" value="<?= $client['postnom'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="prenom">Prénom</label>
                <input style="width: 100%!important;" type="text" name="prenom" id="prenom" value="<?= $client['prenom'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="profession">Profession</label>
                <input style="width: 100%!important;" type="text" name="profession" id="profession" value="<?= $client['profession'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="telephone">Téléphone</label>
                <input style="width: 100%!important;" type="text" name="telephone" id="telephone" value="<?= $client['telephone'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="email">Email</label>
                <input style="width: 100%!important;" type="email" name="email" id="email" value="<?= $client['email'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="sexe">Sexe</label>
                <select style="width: 100%!important;" name="sexe" id="sexe" required>
                  <option value="M" <?= $client['sexe'] == 'M' ? 'selected' : '' ?>>Masculin</option>
                  <option value="F" <?= $client['sexe'] == 'F' ? 'selected' : '' ?>>Féminin</option>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="province">Province</label>
                <input style="width: 100%!important;" type="text" name="province" id="province" value="<?= $client['province'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="commune">Commune</label>
                <input style="width: 100%!important;" type="text" name="commune" id="commune" value="<?= $client['commune'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="quartier">Quartier</label>
                <input style="width: 100%!important;" type="text" name="quartier" id="quartier" value="<?= $client['quartier'] ?>" required>
              </fieldset>
            </div>
            <div class="col-lg-12">
              <fieldset>
                <label for="photo">Photo de profil</label>
                <input style="width: 100%!important;" type="file" name="photo" id="photo" accept="image/*">
              </fieldset>
            </div>
            <div class="col-lg-12">
              <br>
              <fieldset>
                <button type="submit" name="update" class="orange-button">Enregistrer les modifications</button>
              </fieldset>
            </div>
          </div>
        </form>
        <br>

        <!-- Bouton de suppression -->
        <form action="carte.php?id=<?= $client['id'] ?>" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
          <button type="submit" name="delete" class="red-button">Supprimer le client</button>
        </form>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-6">
            <img src="<?= $client['photo'] ?>" alt="">

          </div>
          <div class="col-lg-6">
            <img src="<?= $client['qrcode'] ?>" alt="">

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  function downloadCard(format) {
    const element = document.querySelector('#business-card');
    html2canvas(element).then(canvas => {
      if (format === 'png') {
        const link = document.createElement('a');
        link.href = canvas.toDataURL('image/png');
        link.download = '<?= $client['prenom'] ?>-<?= $client['nom'] ?>-<?= $client['postnom'] ?>.png';
        link.click();
      } else if (format === 'pdf') {
        const pdf = new jsPDF({
          orientation: 'landscape'
        });
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 10);
        pdf.save('<?= $client['prenom'] ?>-<?= $client['nom'] ?>-<?= $client['postnom'] ?>.pdf');
      }
    });
  }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<?php include 'includes/footer.php' ?>