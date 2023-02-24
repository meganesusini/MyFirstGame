<?php
// AuthController.php
class HomeController {
    public function registration() {
        $pseudo = $_POST['username']; // here
        $password = $_POST['password'];

        // Vérifier les informations d'identification de l'utilisateur ici
        if (/* authentification réussie */) {
            header('Location: index.php?controller=HomeController&action=index');
            exit();
        } else {
            // Afficher un message d'erreur ou rediriger vers une page d'erreur
        }
    }
    public function authenticate() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérifier les informations d'identification de l'utilisateur ici
        if (/* authentification réussie */) {
            header('Location: index.php?controller=HomeController&action=index');
            exit();
        } else {
            // Afficher un message d'erreur ou rediriger vers une page d'erreur
        }
    }
}
?>