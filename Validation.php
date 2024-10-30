<?php
// Vérifier que les données sont envoyées par la méthode POST
if ($_SERVER["REQUEST_METHOD"]  == "POST") {
    // Vérification des champs requi

    if (empty($_POST["user_firstname"]) || empty($_POST["user_lastname"]) || empty($_POST["user_email"]) ||  empty($_POST["user_phone"] || empty(!$_POST["user_gendre"]) )) {
        echo "Tous les champs sont requis !";
    } elseif (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) { // Correction ici
        echo "Format de l'email invalide !";
    } else {
        // Récupérer les données du formulaire
        $firstname = htmlspecialchars($_POST['user_firstname']);
        $lastname = htmlspecialchars($_POST['user_lastname']);
        $birthday = htmlspecialchars($_POST['user_birthday']);
        $email = htmlspecialchars($_POST['user_email']);
        $phone = htmlspecialchars($_POST['user_phone']);
        $gender = htmlspecialchars($_POST['user_gender']);
        
        // Afficher les informations récupérées
        echo "<p>Merci : $firstname $lastname pour votre inscription. <br>";
        echo "Un e-mail de validation vous a été envoyé à l'adresse : $email  .</p>";
    }
} else {
    echo "Veuillez renseigner tous les champs requis <br>";
}
?>

