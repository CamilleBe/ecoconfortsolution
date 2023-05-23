
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
                ':logement' => $_POST['logement'],
                ':precision_reno' => $_POST['precision_reno'],
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

            $query = $dbh->prepare('INSERT INTO renov (status, logement, precision_reno, genre, nom, prenom, adresse, ville, code_postal, telephone, email, acceptations, offre) VALUES(:status, :logement, :precision_reno, :genre, :nom, :prenom, :adresse, :ville, :code_postal, :telephone, :email, :acceptations, :offre)');
            $query->execute($query_params);
            header("location: ../redirectory.html");
            exit;

        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}

/*CREATE TABLE renov (
  id INT NOT NULL AUTO_INCREMENT,
  status VARCHAR(255),
  logement VARCHAR(255),
  precision_reno VARCHAR(255),
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

$genre = $_POST['genre'] ?? "";
$nom = $_POST['nom'] ?? "";
$prenom = $_POST['prenom'] ?? "";
$adresse = $_POST['adresse'] ?? "";
$ville = $_POST['ville'] ?? "";
$code_postal = $_POST['code_postal'] ?? "";
$telephone = $_POST['telephone'] ?? "";
$email = $_POST['email'] ?? "";
$precision_reno = $_POST['precision_reno'] ?? "";

?>

<!DOCTYPE html>
<html class="no-js" lang="fr">

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

    <meta charset="utf-8">
    <title>EcoSolutions - Rénovation globale</title>
    <meta name="description" content="Calculez vos aides de la prime Ma prime renov' pour une rénovation globale. Obtenez une estimation de vos aides financières avec notre formulaire en ligne.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    
    <link rel="stylesheet" href="css/renov.css">
</head>

<body>
<header>
    <div id="title">
        <h1>NOUVELLES AIDES 2023, FAITES UNE RÉNOVATION GLOBALE !</h1>
    </div>

    <div id="txt-form-header">
        <p id="container-text-header">
            RÉPONDEZ A NOTRE <span>QUESTIONNAIRE RAPIDE</span> POUR NOUS PERMETTRE DE VOUS ACCOMPAGNER DANS L'INSTALLATION DE VOTRE<span>RÉNOVATION GLOBALE !</span><br><br>

            DES AIDES <span>(JUSQU’A 12 000€)</span><br><br>
            DES ECONOMIES <span>(JUSQU’A 70%)</span><br><br>
            UNE CONSOMATION PLUS <span>VERTE</span>
        </p>
        <div id="form">
            <p id="titre-form">Recevez la meilleure offre pour concrétiser votre projet</p>
            <form action="renov.php" method="POST">
                <div class="f2pl">
                    <select id="status" name="status" required>
                        <option value="">→ Vous êtes... <sup>*</sup></option>
                        <option value="proprietaire"  <?php if($_POST['status'] == 'proprietaire') echo 'selected'; ?>>Propiétaire</option>
                        <option value="locataire" <?php if($_POST['status'] == 'locataire') echo 'selected'; ?>>Locataire</option>
                    </select>

                    <label for="logement"></label>
                    <select id="logement" name="logement" required>
                        <option value="">→ Type de logement... <sup>*</sup></option>
                        <option value="maison" <?php if($_POST['logement'] == 'maison') echo 'selected'; ?>>Une maison</option>
                        <option value="appartement" <?php if($_POST['logement'] == 'appartement') echo 'selected'; ?>>Un appartement</option>
                        <option value="locaux_professionnels"  <?php if($_POST['logement'] == 'locaux_professionnels') echo 'selected'; ?>>Locaux professionnels</option>
                        <option value="autre" <?php if($_POST['logement'] == 'autre') echo 'selected'; ?>>Autre</option>
                    </select>
                </div>

                <div class="fl">
                    <input type="text" id="precision_reno" name="precision_reno" placeholder="→ Précision sur la rénovation *" value="<?php echo $precision_reno; ?>" required>
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
        <img src="img/BuildingConstruction.gif" alt="un gif de construction de maison pour illustrer le texte" id="first-image">
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
                et respectueux de l'environnement.
            </p>
        </div>
        <img src="img/Refinery.gif" alt="un gif d'une maison pour illustrer le texte" id="green-house">
    </div>
    <div class="contant-button">
        <a href="#form"><button>VÉRIFIER MON ÉLIGIBILITÉ</button></a>
    </div>
</div>

<div class="bandeau">
    <h2>TOUT SAVOIR SUR LA RÉNOVATION GLOBALE</h2>
</div>

<div class="contenu" id="contenu2">
    <div class="under-containt">
        <img src="img/builder-seeing-plan-of-a-construction-site.png" alt="illustration d'un employer qui regarde un plan de construction" id="illustration">
        <div class="txt-prime">
            <h3 id="pac">RÉNOVATION GLOBALE</h3>
            <p id="bold">
                La rénovation globale consiste à mettre en œuvre une approche globale et intégrée pour
                la rénovation d'un bâtiment, en prenant en compte les aspects techniques, économiques,
                environnementaux et sociaux, afin d'obtenir un résultat optimal en termes de confort,
                de durabilité et de qualité de vie.
            </p>
            <br><br>
            <ul>
                <li>→ <span class="green-list">Économique,</span> les travaux de rénovation globale permettent de réduire les coûts d'énergie à long terme.</li>
                <li>→ <span class="green-list">Écologique,</span> les travaux de rénovation globale peuvent réduire les émissions de gaz à effet de serre et contribuer à la préservation de l'environnement.</li>
                <li>→ <span class="green-list">Confortable,</span> les travaux de rénovation globale peuvent améliorer le confort thermique et acoustique de la maison.</li>
                <li>→ <span class="green-list">Sécurité,</span> les travaux de rénovation globale peuvent améliorer la sécurité des installations électriques et de plomberie.</li>
                <li>→ <span class="green-list">Esthétique,</span>les travaux de rénovation globale peuvent améliorer l'apparence et la valeur de la maison.</li>
            </ul>
            <a href="#form"><button>COMMENCER MA RÉNOVATION</button></a>
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
    <!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-YJVDX1493G"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-YJVDX1493G');
</script>

    <meta charset="UTF-8">
    <title>EcosConfortSolution</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    <link rel="stylesheet" href="css/home-page.css">
</head>
<body>
    <nav>
        <img src="img/Group 1.png" alt="logo d'éco confort solution">
    </nav>
    <header>
        <div>
            <p>
                <span id="txt-l1">Avec EcoConfort Solutions,</span>
                <br><br>
                <span class="text-l2">Nous sommes là pour vous accompagner dans votre projet.<br></span>
                <span class="text-l2" id="visibility">Remplissez notre formulaire afin d'obtenir rapidement et gratuitement <br> des devis d'artisans de votre région.</span>

                <br><br>
                <span id="txt-l3">Obtenez plusieurs devis</span><br>
                <span id="free">GRATUITEMENT</span>
            </p>
            <a href="#p3"><button>OBTENIR MON DEVIS</button></a>
        </div>
    </header>

    <div id="first-page">
        <h1>Comment trouver le meilleur devis gratuitement ?</h1>
        <div id="stage">
            <div class="sub-step">
                <div>
                    <div class="number">1</div>
                    <div>
                        <h2>REMPLISSEZ NOTRE FORMULAIRE</h2>
                        <p>Commencez par remplir notre formulaire pour permettre à votre artisan local de mieux comprendre votre besoin et de vous proposer un devis précis.</p>
                    </div>
                </div>
            </div>

            <div class="sub-step">
                <div>
                    <div class="number">2</div>
                    <div>
                        <h2>NOUS CONFIRMONS VOTRE DEMANDE</h2>
                        <p>Un membre d’EcoConfort Solutions prendra contact avec vous pour confirmer votre demande. Vos informations seront ensuite transmises à un artisan local.</p>
                    </div>
                </div>
            </div>

            <div class="sub-step">
                <div>
                    <div class="number">3</div>
                    <div>
                        <h2>UN ARTISAN LOCAL VOUS CONTACTE</h2>
                        <p>Enfin, un artisan agréé de votre région vous contactera afin de vous envoyer un devis gratuit. Il sera en mesure de vous donner des conseils adaptés à votre projet en fonction de votre budget et de vos aides financières.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-flex">
            <a href="#p3"><button>OBTENIR MON DEVIS</button></a>
        </div>
    </div>

    <div id="bandeau">
        <h3>NOS SERVICES</h3>
        <div id="container-card">
        <div class="card">
            <div>
                <div class="title">
                    <img src="img/time-limited.png" alt="logo de chronomètre">
                    <h4>DÉLAIS</h4>
                </div>
                <hr>
                <p>Nous assurons une mise en relations rapide avec les artisans</p>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="title">
                    <img src="img/local.png" alt="logo de localisation">
                    <h4>PROXIMITÉ</h4>
                </div>
                <hr>
                <p>Nous privilégions des artisans à côté de chez vous</p>
            </div>
        </div>

        <div class="card">
            <div>
                <div class="title">
                    <img src="img/budget.png" alt="logo d'une bourse d'argent">
                    <h4>BUDGET</h4>
                </div>
                <hr>
                <p>Vous recevrez des devis adaptés à votre projet</p>
            </div>
        </div>
        </div>
    </div>

    <div id="p3">
        <h3>Sélectionnez votre projet</h3>
        <p id="subtitle">Cliquez sur un des choix ci-dessous et complétez le formulaire correspondant</p>
        <div>
            <div class="container-card-click">
                <a href="lpPompeChaleur/pompechaleur.php">
                    <div class="card-click">
                        <img src="img/fan-ventilator.png" alt="logo pompe à chaleur">
                        <p class="title-card"><strong>Pompe à chaleur</strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour installer votre pompe à chaleur</p>
                    </div>
                </a>

                <a href="poele_granules/poele_granule.php">
                    <div class="card-click">
                        <img src="img/fire.png" alt="logo de flamme">
                        <p class="title-card"><strong>Poêle à granulés</strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour installer votre poêle à granulés</p>
                    </div>
                </a>

                <a href="lp_energy_solar/solar_energy.php">
                    <div class="card-click">
                        <img src="img/solar-panel.png" alt="logo de panneaux solaires" class="space">
                        <p class="title-card"><strong>Panneaux solaires</strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour installer vos panneaux solaires</p>
                    </div>
                </a>

            </div>
            
            <div class="container-card-click">

                <a href="window/window.php">
                    <div class="card-click">
                        <img src="img/window.png" alt="logo de fenêtres" class="other-space">
                        <p class="title-card"><strong>Fenêtres</strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour installer vos fenêtres</p>
                    </div>
                </a>

                <a href="isolation/isolation.php">
                    <div class="card-click">
                        <img src="img/climate-control.png" alt="logo de maison" class="space">
                        <p class="title-card"><strong>Isolation thermique extérieure</strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour faire votre isolation thermique extérieur</p>
                    </div>
                </a>

                <a href="renovation/renov.php">
                    <div class="card-click">
                        <img src="img/building-construction.png" alt="logo d'une grue" class="other-space">
                        <p class="title-card"><strong> Rénovation globale </strong></p>
                        <hr>
                        <p>Obtenez votre devis gratuit pour réaliser une rénovation globale</p>
                    </div>
                </a>


            </div>
        </div>
    </div>

    <footer>
        <p>
            ©2023 Tous droits réservés.| EcoConfortSolutions.com | <a href="/cgu.html">CGU</a>
        </p>
    </footer>

</body>
</html>
    </p>
</footer>
</body>
</html>
