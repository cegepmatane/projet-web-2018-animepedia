<?php
/**
 * Created by PhpStorm.
 * User: max77
 * Date: 17/02/2018
 * Time: 21:06
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/configuration.php';
require_once MODELEANIME;
require_once MODELEUTILISATEUR;
require_once MODELEGENRE;
require_once ANIMEDAO;
require_once UTILISATEURDAO;
require_once GENREDAO;
require_once PRIVILEGEDAO;
require_once MODELEPRIVILEGE;

class ControleurAdmin
{
    public function obtenirListesDesMembres()
    {
        try{
            $utilisateurDAO = new UtilisateurDAO();
            $listeMembres = $utilisateurDAO->obtenirListeUtilisateurs();
            return $listeMembres;
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
    public function obtenirListesAnimes()
    {
        try{
            $animeDAO = new AnimeDAO();
            $listeAnimes = $animeDAO->obtenirListeAnimes();
            return $listeAnimes;
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }

    public function obtenirListesGenres()
    {
        try{
            $genreDAO = new GenreDAO();
            $listeGenres = $genreDAO->obtenirListeGenres();
            return $listeGenres;
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }

    public function obtenirListesPrivileges()
    {
        try{
            $privilegeDAO = new PrivilegeDAO();
            $listePrivileges = $privilegeDAO->obtenirListePrivileges();
            return $listePrivileges;
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (isset($_POST['supprimerAnime'])) {

        try {
            $animeDAO= new AnimeDAO();

            $nom = $_POST['supprimerAnimeNom'];

            $animeTemporaire = $animeDAO->obtenirAnimeParString($nom);

            $animeDAO->supprimerUnAnime($animeTemporaire);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['ajouterAnime'])) {

        try {
            $animeDAO= new AnimeDAO();

            $nom = $_POST['ajouterNomAnime'];
            $description = $_POST['ajouterDescriptionAnime'];
            $genre = $_POST['ajouterGenreAnime'];
            $auteur = $_POST['ajouterAuteurAnime'];
            $studio = $_POST['ajouterStudioAnime'];
            $nbepisode = $_POST['ajouterNbEpisodeAnime'];
            $cheminepisode = $_POST['ajouterCheminEpisodeAnime'];

            $anime = new Anime(0, $nom, $description, $genre, $auteur, $studio, $nbepisode, $cheminepisode);
            $animeDAO->ajouterUnAnime($anime);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['modifierAnime'])) {

        try {
            $animeDAO= new AnimeDAO();

            $nom = $_POST['modifierNomAnime'];
            $description = $_POST['modifierDescriptionAnime'];
            $genre = $_POST['modifierGenreAnime'];
            $auteur = $_POST['modifierAuteurAnime'];
            $studio = $_POST['modifierStudioAnime'];
            $nbepisode = $_POST['modifierNbEpisodeAnime'];
            $cheminepisode = $_POST['modifierCheminImageAnime'];

            $animeTemporaire = $animeDAO->obtenirAnimeParString($nom);
            $id = $animeTemporaire->getId();

            $anime = new Anime(intval($id), $nom, $description, $genre, $auteur, $studio, $nbepisode, $cheminepisode);

            $animeDAO->modifierUnAnime($anime);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
    else if (isset($_POST['supprimerMembre'])) {

        try {
            $utilisateurDAO = new UtilisateurDAO();

            $pseudo = $_POST['supprimerPseudoMembre'];

            $membreTemporaire = $utilisateurDAO->obtenirUtilisateurParString($pseudo);

            $utilisateurDAO->supprimerUnUtilisateur($membreTemporaire);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['ajouterMembre'])) {

        try {
            $utilisateurDAO = new UtilisateurDAO();

            $pseudo = $_POST['ajouterPseudoMembre'];
            $email = $_POST['ajouterEmailMembre'];
            $privilege = $_POST['ajouterPrivilegeMembre'];
            $image = $_POST['ajouterImageMembre'];
            $description = $_POST['ajouterDescriptionMembre'];

            $mdp = password_hash('test', PASSWORD_BCRYPT);

            $utilisateur = new Utilisateur(0, $pseudo, $mdp, $email, $privilege, $image, $description);
            $utilisateurDAO->AjouterUnUtilisateur($utilisateur);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['modifierMembre'])) {

        try {
            $utilisateurDAO = new UtilisateurDAO();

            $pseudo = $_POST['modifierPseudoMembre'];
            $email = $_POST['modifierEmailMembre'];
            $privilege = $_POST['modifierPrivilegeMembre'];
            $image = $_POST['modifierImageMembre'];
            $description = $_POST['modifierDescriptionMembre'];

            $utilisateurTemporaire = $utilisateurDAO->obtenirUtilisateurParString($pseudo);
            $id = $utilisateurTemporaire->getId();

            $utilisateur = new Utilisateur($id, $pseudo, '', $email, $privilege, $image, $description);

            $utilisateurDAO->modifierUnUtilisateur($utilisateur);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
    else if (isset($_POST['supprimerGenre'])) {

        try {
            $genreDAO = new GenreDAO();

            $nom = $_POST['supprimerGenreNom'];

            $genreTemporaire = $genreDAO->obtenirGenreParString($nom);

            $genreDAO->SupprimerUnGenre($genreTemporaire);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['ajouterGenre'])) {

        try {
            $genreDAO = new GenreDAO();

            $nom = $_POST['ajouterGenreNom'];

            $genre = new Genre(0, $nom);
            $genreDAO->AjouterUnGenre($genre);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['modifierGenre'])) {

        try {
            $genreDAO = new GenreDAO();

            $nom = $_POST['modifierGenreNom'];

            $genreTemporaire = $genreDAO->obtenirGenreParString($nom);

            $genre = new Genre($genreTemporaire->getId(), $nom);
            $genreDAO->ModifierUnGenre($genre);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
    else if (isset($_POST['supprimerPrivilege'])) {

        try {
            $privilegeDAO = new PrivilegeDAO();

            $nom = $_POST['supprimerPrivilegeNom'];

            $privilegeTemporaire = $privilegeDAO->obtenirPrivilegeParString($nom);

            $privilegeDAO->SupprimerUnPrivilege($privilegeTemporaire);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['ajouterPrivilege'])) {

        try {
            $privilegeDAO = new PrivilegeDAO();

            $nom = $_POST['ajouterPrivilegeNom'];

            $privilege = new Privilege(0, $nom);

            $privilegeDAO->AjouterUnPrivilege($privilege);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }

    }
    else if (isset($_POST['modifierPrivilege'])) {

        try {
            $privilegeDAO = new PrivilegeDAO();

            $nom = $_POST['modifierPrivilegeNom'];

            $privilegeTemporaire = $privilegeDAO->obtenirPrivilegeParString($nom);

            $privilege = new Privilege($privilegeTemporaire->getId(), $nom);

            $privilegeDAO->ModifierUnPrivilege($privilege);

            header("location: https://dev.animepedia.fr/admin");
        }
        catch(Throwable $e) {
            $trace = $e->getTrace();
            echo $e->getMessage().' in '.$e->getFile().' on line '.$e->getLine().' called from '.$trace[0]['file'].' on line '.$trace[0]['line'];
        }
    }
}