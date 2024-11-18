<?php
require_once 'includes/database.php';
require_once 'includes/fonctions.php';

redirectIfNotLoggedIn();

$stmt = $pdo->query('SELECT * FROM clients');
$clients = $stmt->fetchAll();
?>

<?php include 'includes/header.php' ?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h3>Voir les cartes</h3>
        <span class="breadcrumb"><a href="#">Acceuil</a> > Voir les cartes</span>
      </div>
    </div>
  </div>
</div>

<div class="section trending">
  <div class="container">
    <ul class="trending-filter">
      <li>
        <a class="is_active" href="#!" data-filter="*">Toutes</a>
      </li>
      <li>
        <a href="#!" data-filter=".M">Hommes</a>
      </li>
      <li>
        <a href="#!" data-filter=".F">Femmes</a>
      </li>

    </ul>
    <div class="row trending-box">
      <?php foreach ($clients as $client): ?>
        <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 <?= $client['sexe'] ?>">
          <div class="item">
            <div class="thumb">
              <a href="carte.php?id=<?= $client['id'] ?>"><img src="<?= $client['photo'] ?>" alt=""></a>
              <span class="price">
                <img height="50" src="<?= $client['qrcode'] ?>" alt="">
              </span>
            </div>
            <div class="down-content">
              <span class="category">Nom complet</span>
              <h4><?= $client['prenom'] ?> <?= $client['nom'] ?></h4>
              <a href="carte.php?id=<?= $client['id'] ?>"><i class="fa fa-eye"></i></a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>
  
  </div>
</div>
<?php include 'includes/footer.php' ?>