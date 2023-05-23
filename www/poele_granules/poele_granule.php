<?php
try {
  $dbh = new PDO('mysql:host=ecoconskevin.mysql.db; dbname=ecoconskevin; charset=utf8', 'ecoconskevin', 'C0nversium');
} catch (Exception $e) {
  die('Erreur de connexion' . $e->getMessage());
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Codition Code postal
    if (!preg_match("~^\d{5}$~", $_POST['code_postal'])) {
        $errors['lenght_postal_code'] = "Le code postal n'est pas conforme";
    }

    //Codition email
    if (!preg_match("~^.+@.+\..+$~", $_POST['email'])) {
        $errors['preg_email'] = "l'e-mail est non conforme";
    }

    //Codition numéro de téléphone
    if (!preg_match("~^\d{10}$~", $_POST['telephone'])) {
        $errors['lenght_phone'] = "Le numéro renseigner n'existe pas";
    }

    if (empty($errors)) {
        try {

            $query_params = array(
                ':status' => $_POST['status'],
                ':chauffage_actuel' => $_POST['chauffage_actuel'],
                ':logement_type' => $_POST['logement_type'],
                ':genre' => $_POST['genre'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':adresse' => $_POST['adresse'],
                ':ville' => $_POST['ville'],
                ':code_postal' => $_POST['code_postal'],
                ':telephone' => $_POST['telephone'],
                ':email' => $_POST['email'],
                ':acceptations' => isset($_POST['acceptations']) ? 0 : 1,
                ':offre' => isset($_POST['offre']) ? 1 : 0
            );

            $query = $dbh->prepare('INSERT INTO poele_granule(status, chauffage_actuel, logement_type, genre, nom, prenom, adresse, ville, code_postal, telephone, email, acceptations, offre) VALUES(:status, :chauffage_actuel, :logement_type,  :genre, :nom, :prenom, :adresse, :ville, :code_postal, :telephone, :email, :acceptations, :offre)');
            $query->execute($query_params);
            header("location: ../redirectory.html");
            exit;

        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}

$genre = $_POST['genre'] ?? "";
$nom = $_POST['nom'] ?? "";
$prenom = $_POST['prenom'] ?? "";
$adresse = $_POST['adresse'] ?? "";
$ville = $_POST['ville'] ?? "";
$code_postal = $_POST['code_postal'] ?? "";
$telephone = $_POST['telephone'] ?? "";
$email = $_POST['email'] ?? "";


/*CREATE TABLE poele_granule (
  id INT NOT NULL AUTO_INCREMENT,
  status VARCHAR(255),
  logement_type VARCHAR(255),
  chauffage_actuel VARCHAR(255),
  genre VARCHAR(255),
  nom VARCHAR(255),
  prenom VARCHAR(255),
  adresse VARCHAR(255),
  code_postal VARCHAR(5),
  ville VARCHAR(255),
  telephone VARCHAR(10),
  email VARCHAR(255),
  acceptations BOOLEAN,
  offre BOOLEAN,
  PRIMARY KEY (id)
);*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TTKG7XR');</script>
<!-- End Google Tag Manager -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YJVDX1493G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YJVDX1493G');
</script>

    <meta charset="UTF-8">
    <title>EcoConfort - Poêles à granulés</title>
    <meta name="description" content="Calculez vos aides de la prime Ma prime renov' pour l'installation d'un poêle à granules. Obtenez une estimation de vos aides financières avec notre formulaire en ligne.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    
    <link rel="stylesheet" href="css/poelegranules.css">
</head>
<body>

<header>
    <div id="title">
        <h1>NOUVELLES AIDES 2023, INSTALLEZ VOTRE POÊLE À GRANULÉS !</h1>
    </div>

    <div id="txt-form-header">
        <p id="container-text-header">
            RÉPONDEZ A NOTRE <span>QUESTIONNAIRE RAPIDE</span> POUR NOUS PERMETTRE DE VOUS ACCOMPAGNER DANS VOTRE INSTALLATION DE <span>POÊLES A GRANULÉS</span><br><br>

            DES AIDES <span>(JUSQU’A 3 200€)</span><br><br>
            DES ECONOMIES <span>(JUSQU’A 70%)</span><br><br>
            DES ENERGIES PLUS <span>DURABLE</span>
        </p>
        <div id="form">
            <p id="titre-form">Recevez la meilleure offre pour concrétiser votre projet</p>
            <form action="poele_granule.php" method="POST">
                <div class="f2pl">
                    <select id="status" name="status" required>
                        <option value="">→ Vous êtes... <sup>*</sup></option>
                        <option value="proprietaire" <?php if($_POST['status'] == 'proprietaire') echo 'selected'; ?>>Propiétaire</option>
                        <option value="locataire" <?php if($_POST['status'] == 'locataire') echo 'selected'; ?>>Locataire</option>
                    </select>

                    <select id="heating" name="chauffage_actuel" required>
                        <option value="">→ Votre chauffage actuel... <sup>*</sup></option>
                        <option value="gas" <?php if($_POST['chauffage_actuel'] == 'gas') echo 'selected'; ?>>Gaz</option>
                        <option value="fioul" <?php if($_POST['chauffage_actuel'] == 'fioul') echo 'selected'; ?>>Fioul</option>
                        <option value="electrique" <?php if($_POST['chauffage_actuel'] == 'electrique') echo 'selected'; ?>>Électrique</option>
                        <option value="bois" <?php if($_POST['chauffage_actuel'] == 'bois') echo 'selected'; ?>>Bois</option>
                        <option value="dual" <?php if($_POST['chauffage_actuel'] == 'dual') echo 'selected'; ?>>Dual(électricité + gaz)</option>
                        <option value="autre_chauffage" <?php if($_POST['chauffage_actuel'] == 'autre_chauffage') echo 'selected'; ?>>Autre</option>
                    </select>
                </div>

                <div class="fl">
                    <label for="logement_type"></label>
                    <select id="logement_type" name="logement_type" required>
                        <option value="">→ Type de logement... <sup>*</sup></option>
                        <option value="maison" <?php if($_POST['logement_type'] == 'maison') echo 'selected'; ?>>Une maison</option>
                        <option value="appartement" <?php if($_POST['logement_type'] == 'appartement') echo 'selected'; ?>>Un appartement</option>
                        <option value="locaux_professionnels"  <?php if($_POST['logement_type'] == 'locaux_professionnels') echo 'selected'; ?>>Locaux professionnels</option>
                        <option value="autre" <?php if($_POST['logement_type'] == 'autre') echo 'selected'; ?>>Autre</option>
                    </select>
                </div>

                <div class="fl exeption">
                    <label for="genre">Genre : </label required>
                    <input type="radio" id="homme" name="genre" value="homme" <?php if ($_POST['genre'] == 'homme') { echo 'checked'; } ?>>
                    <label for="homme">Homme</label>

                    <input type="radio" id="femme" name="genre" value="femme" <?php if ($_POST['genre'] == 'femme') { echo 'checked'; } ?>>
                    <label for="femme">Femme</label>

                    <input type="radio" id="non-defini" name="genre" value="non-defini" <?php if ($_POST['genre'] == 'non-defini') { echo 'checked'; } ?>>
                    <label for="non-defini">Non défini</label>
                </div>


                <div class="f2pl">
                    <input type="text" id="nom" name="nom" placeholder="→ Nom *" autocomplete="nom" value="<?php echo $nom; ?>" required>

                    <input type="text" id="prenom" name="prenom" placeholder="→ Prénom *" autocomplete="prenom" value="<?php echo $_POST['prenom'] ?? ''; ?>" required>
                </div>

                <div class="fl">
                    <input type="text" id="adresse" name="adresse" placeholder="→ Adresse" autocomplete="adresse" value="<?php echo $_POST['adresse'] ?? ''; ?>">
                </div>

                <div class="f2pl">
                    <input type="text" id="ville" name="ville" placeholder="→ Ville" autocomplete="ville" value="<?php echo $_POST['ville'] ?? ''; ?>">

                    <input type="text" id="code_postal" name="code_postal" placeholder="→ Code Postal *" autocomplete="codePostal" value="<?php echo $_POST['code_postal'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['lenght_postal_code'])) { ?>
                        <p id="error1"><?php echo $errors['lenght_postal_code']; ?></p>
                    <?php } ?>
                </div>


                <div class="fl">
                    <label for="email"></label>
                    <input type="text" id="email" name="email" placeholder="→ Adresse e-mail *" autocomplete="email" value="<?php echo $_POST['email'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['preg_email'])) { ?>
                        <p id="error2"><?php echo $errors['preg_email']; ?></p>
                    <?php } ?>
                </div>

                <div class="fl">
                    <label for="telephone"></label>
                    <input type="text" id="telephone" name="telephone" placeholder="→ Numéro de téléphone *" autocomplete="phone" value="<?php echo $_POST['telephone'] ?? ''; ?>" required>
                </div>

                <div class="fl-error">
                    <?php if (isset($errors['lenght_phone'])) { ?>
                        <p id="error3"><?php echo $errors['lenght_phone']; ?></p>
                    <?php } ?>
                </div>

                <div id="fb">
                    <div class="exeption" id="acceptations">
                        <input type="checkbox" id="cgu" name="cgu" <?php if(isset($_POST['offre'])) echo "checked"; ?> required>
                        <label for="cgu">J'accepte les <a href="https://ecoconfortsolutions.com/cgu.html">CGU</a> et que leurs partenaires me communiquent leurs devis *</label>
                        <br><br>

                        <input type="checkbox" id="offre" name="offre" <?php if(isset($_POST['offre'])) echo "checked"; ?>>
                        <label for="offre">J'accepte de recevoir des offres personnalisées email, téléphone et sms de EcoConfortSolution.fr ainsi que de ses partenaires</label>
                    </div>
                    <input type="submit" value="VALIDER" id="hbutton">
                </div>
            </form>
        </div>
    </div>
</header>

<div class="contenu">
    <h2>Faites des économies sur vos factures d’énergie !</h2>
    <div class="under-containt">
        <img src="img/stove.png" alt="poêle à granulés" id="first-img">
        <div class="txt-prime">
            <h3>EN 2023, MA PRIME RÉNOV S’ÉTEND !</h3>
            <p>
                Avec l'installation de panneaux solaires, vous pouvez bénéficier de <strong>plusieurs aides
                financières</strong> de l'État pour réduire vos coûts d'installation. Depuis 2023, Ma Prime
                Renov' est étendue à <strong>tous les propriétaires</strong>, offrant un soutien financier accru pour réduire
                votre empreinte carbone et améliorer votre confort. Vous pouvez également bénéficier de la
                prime CEE. <strong>Remplissez notre questionnaire</strong> pour savoir si vous êtes éligible à cette prime et
                transformez votre maison en un lieu de vie plus confortable et respectueux de l'environnement
                dès maintenant.
            </p>
        </div>
    </div>

    <div class="under-containt">
        <div class="txt-prime">
            <h3>BÉNÉFICIEZ DE LA PRIME C.E.E</h3>
            <p>
                La prime CEE est une <strong>aide financière</strong> offerte par l'État pour encourager les particuliers à
                adopter des comportements éco-responsables. En réalisant des travaux de rénovation énergétique
                ou en installant des équipements performants, vous pouvez <strong>bénéficier de cette prime</strong> et faire
                ainsi des <strong>économies</strong> sur vos factures d'énergie. <strong>Remplissez notre questionnaire</strong> pour découvrir
                si vous êtes éligible à la prime CEE et transformez votre maison en un lieu de vie plus confortable
                et respectueux de l'environnement.            </p>
        </div>
        <img src="img/pellet-stove.jpg" alt="poêle à granulés" id="green-house">
    </div>
    <div class="contant-button">
        <a href="#form"><button>VÉRIFIER MON ÉLIGIBILITÉ</button></a>
    </div>
</div>

<div class="bandeau">
    <h2>TOUT SAVOIR SUR LES POÊLES À GRANULÉS</h2>
</div>

<div class="contenu" id="contenu2">
    <div class="under-containt">
        <img src="img/people-use-bio-coal.png" alt="illustration de panneaux solaires" id="illustration">
        <div class="txt-prime">
            <h3 id="pac">POÊLE À GRANULÉS </h3>
            <p id="bold">
                Un poêle à granulés est un appareil de chauffage fonctionnant avec des granulés de bois comprimés.
                Il utilise une combustion propre et efficace pour produire de la chaleur, offrant ainsi une
                alternative plus écologique et économique aux méthodes de chauffage traditionnelles.
            </p>
            <br><br>
            <ul>
                <li>→ <span class="green-list">Utilise des granulés de bois</span>, une source de combustible renouvelable et écologique.</li>
                <li>→ <span class="green-list">Économique</span>, il permet de réaliser des économies sur la facture énergétique grâce à une consommation électrique réduite.</li>
                <li>→ <span class="green-list">Stable</span>, il offre une chaleur constante et régulière, programmable selon les besoins.</li>
                <li>→ <span class="green-list">Peu d’entretiens</span>, facile à utiliser et à entretenir, avec un nettoyage automatique du brûleur et une faible accumulation de cendres.</li>
                <li>→ <span class="green-list">Écologique</span>, avec son émission faible en carbonne ce mode de chauffage est une option plus respectueuse de l'environnement que les poêles à bois traditionnels.
                </li>
                <li>→ <span class="green-list">Flexible</span>, le poêle à granulés est utilisable comme système de chauffage principal ou d'appoint, offrant ainsi une flexibilité d'utilisation.</li>
            </ul>
            <a href="#form"><button>OBTENIR MON POÊLE A GRANULÉS</button></a>
        </div>
    </div>
</div>

<div class="bandeau">
    <h2>DISPOSITIF DE L’ÉTAT</h2>
    <div id="logo">
        <img src="img/Groupprimerenov.png" alt="logo de Ma prime rénov'">
        <img src="img/CEE-Certificat-Economie-Energie%201cee.png" alt="logo des certificats d'économies d'énergie">
        <img src="img/phast.png" alt="logo de France renov'">
        <img src="img/phast2.png" alt="logo de RGE eco artisan et logo de RGE QUALIBAT">
    </div>
    <div class="contant-button">
        <a href="#form"><button id="no-shadow">CALCULER MES AIDES</button></a>
    </div>
</div>

<footer>
    <p>
        ©2023 Tous droits réservés.| EcoConfortSolutions.com | <a href="/cgu.html">CGU</a>
    </p>
</footer>

</body>
</html>
