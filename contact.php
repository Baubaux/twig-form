<?php

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

// activation du système d'autoloading de Composer
require __DIR__.'/vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new FilesystemLoader(__DIR__.'/templates');

// instanciation du moteur de template
$twig = new Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension DebugExtension
$twig->addExtension(new DebugExtension());

// traitement des données
$errors = [];

if ($_POST) {

    $maxLength = 190;

    if (empty($_POST['email'])) {
        $errors['email'] = 'merci de renseigner ce champ';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'merci de renseigner un email valide';
    } elseif (strlen($_POST['email']) >= 190) {
        $errors['email'] = "merci de renseigner un email dont la longueur ne dépasse pas {$maxLength} caractères";
    }

    $minLenght = 3;
    $maxLength = 190;

    if (empty($_POST['subject'])) {
        $errors['subject'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['subject']) <= 3 || strlen($_POST['subject']) >= 190) {
        $errors['subject'] = "merci de renseigner un sujet dont la longueur soit comprise entre {$minLenght} et {$maxLength} caractères";
    }

    $minLenght = 3;
    $maxLengthMessage = 1000;

    if (empty($_POST['message'])) {
        $errors['message'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['message']) <= 3 || strlen($_POST['message']) >= 1000) {
        $errors['message'] = "merci de renseigner un sujet dont la longueur soit comprise entre {$minLenght} et {$maxLengthMessage} caractères";
    } elseif (preg_match('/^[a-zA-Z]+$/', $_POST['message']) === 0) {
        $errors['message'] = 'merci de renseigner un login composé uniquement de lettres de l\'alphabet sans accent';
    }
}

// affichage du rendu d'un template
echo $twig->render('contact.html.twig', [
    'errors' => $errors,
]);