<?php
/**
 * Created by PhpStorm.
 * User: lyanke
 * Date: 17/02/2018
 * Time: 09:31
 */
class BaseDeDonnees {
    private static $instance = NULL;

    private function __construct() {}

    private function __clone() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$instance = new PDO(TYPEBDD . ':host=' . HOTEBDD . ';dbname='. NOMBDD .';charset=' . ENCODAGE, '', '', $pdo_options);
            if(self::$instance == NULL)
                echo('Erreur de connexion');
        }
        return self::$instance;
    }
}

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
define("HOMEPAGE", "url: https://animepedia.fr/home");
define("SITE", "https://animepedia.fr/");
define("LIENS", $_SERVER['DOCUMENT_ROOT'] .'/links.html');

define("MODELE", $_SERVER['DOCUMENT_ROOT'] . '/modele');
define("MODELEANIME", MODELE . '/Anime.php');
define("MODELEUTILISATEUR", MODELE . '/Utilisateur.php');
define("MODELEGENRE", MODELE . '/Genre.php');
define("MODELEPRIVILEGE", MODELE . '/Privilege.php');
define("MODELEPAIEMENT", MODELE . '/Paiement.php');

define("CONTROLEUR", '../controleur');
define("CONTROLEURINDEX", CONTROLEUR . '/ControleurIndex.php');
define("CONTROLEURANIME", CONTROLEUR . '/ControleurAnime.php');
define("CONTROLEURPROFIL", CONTROLEUR . '/ControleurProfil.php');
define("CONTROLEURINSCRIPTION", CONTROLEUR . '/ControleurRegister.php');
define("CONTROLEURCONNEXION", CONTROLEUR . '/ControleurLogin.php');
define("CONTROLEURDECONNEXION", CONTROLEUR . '/ControleurLogout.php');
define("CONTROLEURADMIN", CONTROLEUR . '/ControleurAdmin.php');
define("CONTROLEURWIZARD", CONTROLEUR . '/ControleurWizard.php');
define("CONTROLEURCONTACT", CONTROLEUR . '/ControleurContact.php');

define("DAO", $_SERVER['DOCUMENT_ROOT'] . '/dao');
define("ANIMEDAO", DAO . '/AnimeDAO.php');
define("GENREDAO", DAO . '/GenreDAO.php');
define("PRIVILEGEDAO", DAO . '/PrivilegeDAO.php');
define("UTILISATEURDAO", DAO . '/UtilisateurDAO.php');
define("PAIEMENTDAO", DAO . '/PaiementDAO.php');

define("JS", SITE . "/js");
define("JSWIZARD", JS . "/wizard.js");
define("JSANIMES", JS . "/animes.js");
define("JSADMIN", JS . "/admin.js");
define("JSHEADER", JS . "/header.js");
define("JSDASHBOARD", JS . "/dashboard.js");

define("CSS", SITE . "/css");
define("CSS_PROFIL", CSS . "/profil_.css");
define("CSS_404", CSS . '/404_.css');
define("CSS_ADMIN", CSS . '/admin_.css');
define("CSS_ANIMES", CSS . '/animes_.css');
define("CSS_CONTACT", CSS . '/contact_.css');
define("CSS_PIEDDEPAGE", CSS . '/footer_.css');
define("CSS_ENTETE", CSS . "/header_.css");
define("CSS_INDEX", CSS . '/index_.css');
define("CSS_CONNEXION", CSS . "/login_.css");
define("CSS_INSCRIPTION", CSS . "/register_.css");
define("CSS_ABONNEMENT", CSS . "/subscribe_.css");
define("CSS_WIZARD", CSS . "/wizard_.css");


define('TYPEBDD', 'mysql');
define("HOTEBDD", "animepedao77.mysql.db");
define("NOMBDD", "animepedao77" );
define("ENCODAGE", "utf8");
define("VUES", $_SERVER['DOCUMENT_ROOT'] . "/public");
define("ENTETE",VUES . "/header.php");
define("PIEDDEPAGE", VUES . '/footer.php');

putenv('LC_ALL=fr_FR');
setlocale(LC_ALL, 'fr_FR');

?>
