
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
                ':logement_type' => $_POST['logement_type'],
                ':nombre_fenetre' => $_POST['nombre_fenetre'],
                ':genre' => $_POST['genre'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':adresse' => $_POST['adresse'],
                ':ville' => $_POST['ville'],
                ':code_postal' => $_POST['code_postal'],
                ':telephone' => $_POST['telephone'],
                ':email' => $_POST['email'],
                //':acceptations' => $_POST['acceptations'],
                ':acceptations' => isset($_POST['acceptations']) ? 0 : 1,
                //':offre' => $_POST['offre']
                ':offre' => isset($_POST['offre']) ? 1 : 0

            );

            $query = $dbh->prepare('INSERT INTO window (status, logement_type, nombre_fenetre, genre, nom, prenom, adresse, ville, code_postal, telephone, email, acceptations, offre) VALUES(:status, :logement_type, :nombre_fenetre, :genre, :nom, :prenom, :adresse, :ville, :code_postal, :telephone, :email, :acceptations, :offre)');
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
    <title>EcoConfortSolutions - Fenêtre</title>
    <meta name="description" content="Calculez vos aides de la prime Ma prime renov' pour l'installation de fenêtres. Obtenez une estimation de vos aides financières avec notre formulaire en ligne.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/favicon.svg">
    
    <link rel="stylesheet" href="css/window.css">
</head>

<body>
<header>
    <div id="title">
        <h1>NOUVELLES AIDES 2023, INSTALLEZ VOS FENÊTRES !</h1>
    </div>

    <div id="txt-form-header">
        <p id="container-text-header">
            RÉPONDEZ A NOTRE <span>QUESTIONNAIRE RAPIDE</span> POUR NOUS PERMETTRE DE VOUS ACCOMPAGNER DANS L'INSTALLATION DE VOS <span>FENÊTRES !</span><br><br>

            DES AIDES <span>(JUSQU’A 250€ PAR FENÊTRE)</span><br><br>
            DES <span>ÉCONOMIES</span> <br><br>
            UNE CONSOMATION <span>RÉDUITE</span>
        </p>
        <div id="form">
            <p id="titre-form">Recevez la meilleure offre pour concrétiser votre projet</p>
            <form action="window.php" method="POST">
                <div class="f2pl">
                    <select id="status" name="status" required>
                        <option value="">→ Vous êtes... <sup>*</sup></option>
                        <option value="proprietaire" <?php if($_POST['status'] == 'proprietaire') echo 'selected'; ?>>Propiétaire</option>
                        <option value="locataire" <?php if($_POST['status'] == 'locataire') echo 'selected'; ?>>Locataire</option>
                    </select>
                    <label for="logement_type"></label>
                    <select id="logement_type" name="logement_type" required>
                        <option value="">→ Type de logement... <sup>*</sup></option>
                        <option value="maison" <?php if($_POST['logement_type'] == 'maison') echo 'selected'; ?>>Une maison</option>
                        <option value="appartement" <?php if($_POST['logement_type'] == 'appartement') echo 'selected'; ?>>Un appartement</option>
                        <option value="locaux_professionnels"  <?php if($_POST['logement_type'] == 'locaux_professionnels') echo 'selected'; ?>>Locaux professionnels</option>
                        <option value="autre" <?php if($_POST['logement_type'] == 'autre') echo 'selected'; ?>>Autre</option>
                    </select>
                </div>

                <div class="fl">
                    <label for="nombre_fenetre"></label>
                    <select id="nombre_fenetre" name="nombre_fenetre" required>
                        <option value="">→ Nombres de fenêtres à changter chez vous... <sup>*</sup></option>
                        <option value="1" <?php if($_POST['nombre_fenetre'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if($_POST['nombre_fenetre'] == '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if($_POST['nombre_fenetre'] == '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if($_POST['nombre_fenetre'] == '4') echo 'selected'; ?>>4</option>
                        <option value="5" <?php if($_POST['nombre_fenetre'] == '5') echo 'selected'; ?>>5</option>
                        <option value="6" <?php if($_POST['nombre_fenetre'] == '6') echo 'selected'; ?>>6</option>
                        <option value="7" <?php if($_POST['nombre_fenetre'] == '7') echo 'selected'; ?>>7</option>
                        <option value="8" <?php if($_POST['nombre_fenetre'] == '8') echo 'selected'; ?>>8</option>
                        <option value="9" <?php if($_POST['nombre_fenetre'] == '9') echo 'selected'; ?>>9</option>
                        <option value="10" <?php if($_POST['nombre_fenetre'] == '10') echo 'selected'; ?>>10</option>
                        <option value="plus_de_10" <?php if($_POST['nombre_fenetre'] == 'plus_de_10') echo 'selected'; ?>>Plus de 10</option>
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
        <img src="img/WindowCasement.gif" alt="un gif d'une fenêtre ouverte pour illustrer le texte" id="first-image">
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
        <img src="img/Window.gif" alt="un gif d'une fenêtre ouverte pour illustrer le texte" id="green-house">
    </div>
    <div class="contant-button">
        <a href="#form"><button>VÉRIFIER MON ÉLIGIBILITÉ</button></a>
    </div>
</div>

<div class="bandeau">
    <h2>TOUT SAVOIR SUR L’INSTALLATION DE FENÊTRES</h2>
</div>

<div class="contenu" id="contenu2">
    <div class="under-containt">
        <img src="img/window-installation.png" alt="illustration d'employers qui installent une fenêtres" id="illustration">
        <div class="txt-prime">
            <h3 id="pac">FENÊTRES</h3>
            <p id="bold">
                L'installation de fenêtres permet d'améliorer l'isolation thermique et acoustique de la maison,
                d'offrir une meilleure sécurité, d'embellir l'aspect extérieur et d'augmenter la valeur de la
                propriété. Les nouvelles fenêtres peuvent donc apporter un confort accru, une économie d'énergie
                et une valeur ajoutée à la maison.
            </p>
            <br><br>
            <ul>
                <li>→ <span class="green-list">Isolation,</span> les nouvelles fenêtres peuvent améliorer l'isolation thermique de la maison, ce qui permet de réduire les pertes de chaleur et donc de faire des économies d'énergie.</li>
                <li>→ <span class="green-list">Confort,</span> les nouvelles fenêtres peuvent également améliorer le confort acoustique en réduisant les bruits extérieurs.</li>
                <li>→ <span class="green-list">Sécurité,</span> les nouvelles fenêtres peuvent offrir une meilleure sécurité grâce à des technologies telles que les vitrages de sécurité ou les serrures renforcées.</li>
                <li>→ <span class="green-list">Esthétique,</span> les nouvelles fenêtres peuvent améliorer l'esthétique de la maison en donnant un aspect plus moderne et plus attrayant.</li>
                <li>→ <span class="green-list">Valeur,</span>l'installation de nouvelles fenêtres peut également augmenter la valeur de la propriété en améliorant son apparence et en augmentant son efficacité énergétique.</li>
            </ul>
            <a href="#form"><button>INSTALLER MES FENÊTRES</button></a>
        </div>
    </div>
</div>

<div class="bandeau">
    <h2>DISPOSITIF DE L’ÉTAT</h2>
    <div id="logo">
        <img src="img/Groupprimerenov.png" alt="logo de Ma prime rénov'">
        <img src="img/CEE-Certificat-Economie-Energie%201cee.png" alt="logo des certificats d'économies d'énergie">
        <img src="img/phast.png" alt="logo de France renov'">
        <img src="img/phast_1.png" alt="logo de RGE eco artisan et logo de RGE QUALIBAT">
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
