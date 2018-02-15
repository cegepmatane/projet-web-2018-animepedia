<?php
/**
 * Created by PhpStorm.
 * User: max77
 * Date: 14/02/2018
 * Time: 11:33
 */

require_once '../modele/Utilisateur.php';
require_once '../dao/UtilisateurDAO.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['buttonLogin'])) { //user registering

        try{
            session_start();

            $utilisateurDAO = new UtilisateurDAO();

            $pass = $_POST['loginPassword'];
            $username = $_POST['loginUser'];

            $_SESSION['username'] = $_POST['loginUser'];

            $utilisateurTemporaire = new Utilisateur($username, "", "none", 0,"","");

            if($utilisateurDAO->CheckIfUserExist($utilisateurTemporaire))
            {
                $utilisateur = $utilisateurDAO->GetUtilisateurByString($utilisateurTemporaire->getPseudo());

                $_SESSION['message'] = $utilisateur->getPseudo() . ' '. $utilisateur->getMdp() . ' ' . $utilisateur->getEmail();
                if ( password_verify($pass, $utilisateur->getMdp()) )
                {
                    $_SESSION['logged_in'] = true;

                    $_SESSION['message'] = "";
                    header("location: https://www.dev.animepedia.fr/home");
                }
                else
                {
                   // $_SESSION['message'] = 'Mot de passe incorrect';
                    header("location: https://www.dev.animepedia.fr/login");

                }
            }
            else
            {
                $_SESSION['message'] = 'Utilisateur inconnu';
                header("location: https://www.dev.animepedia.fr/login");
            }
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
}