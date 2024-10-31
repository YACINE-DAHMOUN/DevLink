<?php
// paramètres de connexion a la base de données 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reseau_social";

try {
    // connexion a la base de données avec pdo
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC

    ]);
} catch (Exception $e) {
    die ("Erreur : " . $e->getMessage());

}
// Vérifier que les données sont envoyées par la méthode POST
if ($_SERVER["REQUEST_METHOD"]  == "POST") {
    // Vérification des champs requis

    if (empty($_POST["user_firstname"]) ||
        empty($_POST["user_lastname"]) || 
        empty($_POST["user_email"]) ||  
        empty($_POST["user_phone"])) {

        echo "Tous les champs sont requis !";

    } elseif (!filter_var($_POST["user_email"], FILTER_VALIDATE_EMAIL)) { // Correction ici
        echo "Format de l'email invalide !";
    } elseif
        (empty($_POST["user_password"]) || empty($_POST["user_confirm_password"])) {
            echo "Les champs mots de passe sont requis !";
    }elseif ($_POST["user_password"] !== $_POST["user_confirm_password"]) {
        echo "Les mots de passe ne correspondent pas !";
    }else {
        // Récupérer les données du formulaire
        $firstname = htmlspecialchars($_POST['user_firstname']);
        $lastname = htmlspecialchars($_POST['user_lastname']);
        $birthdate = htmlspecialchars($_POST['user_birthdate']);
        $email = htmlspecialchars($_POST['user_email']);
        $phone = htmlspecialchars($_POST['user_phone']);
        $gender = htmlspecialchars($_POST['user_gender']);
        $password = password_hash ($_POST['user_password'], PASSWORD_DEFAULT);
        $confirm_password = htmlspecialchars($_POST['user_confirm_password']);

        $sql = "INSERT INTO utilisateurs (firstname, lastname, birthdate, email, phone, gender, password)
                VALUES (:firstname, :lastname, :birthdate, :email, :phone, :gender, :password)";

        //préparer et exécuter la reqête 
        $stm = $pdo->prepare($sql);
        $execution = $stm->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':birthdate' => $birthdate,
            ':email' => $email,
            'phone' => $phone,
            'gender' => $gender,
            'password' => $password
        ]);
        if ($execution) {
                // Afficher les informations récupérées
        echo "<p>Merci : $firstname $lastname pour votre inscription. <br>";
        echo "Un e-mail de validation vous a été envoyé à l'adresse : $email  .</p>";
    
} else {
    echo "Veuillez renseigner tous les champs requis <br>";
}
}
}
?>