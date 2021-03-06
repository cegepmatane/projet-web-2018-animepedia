<?php
/**
 * Created by PhpStorm.
 * User: max77
 * Date: 25/02/2018
 * Time: 20:10
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/configuration.php';
require_once ANIMEDAO;

$animeDAO = new AnimeDAO();
$listeAnimes = $animeDAO->obtenirListeAnimes();

require_once GENREDAO;

$genreDAO = new GenreDAO();
$listeGenres = $genreDAO->obtenirListeGenres();
?>
<div class="table-wrapper">
    <div class="table-title">
        <div class="row">
            <div class="col-sm-12">
                <a href="#ajouterAnimeModal" class="btn btn-success" data-toggle="modal"><span><?php echo _("Ajouter un anime")?></span></a>
            </div>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th><?php echo _("Nom")?></th>
            <th><?php echo _("Description")?></th>
            <th><?php echo _("Genre")?></th>
            <th><?php echo _("Auteur")?></th>
            <th><?php echo _("Studio")?></th>
            <th><?php echo _("Nombres d'episodes")?></th>
            <th><?php echo _("Chemin de l'image")?></th>
            <th><?php echo _("Opening")?></th>
            <th><?php echo _("Description Détaillé")?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $nb_elem_per_page = 9;
        $page = isset($_GET['page-anime'])?intval($_GET['page-anime']-1):0;
        $number_of_pages = intval(count($listeAnimes)/$nb_elem_per_page)+1;

        foreach (array_slice($listeAnimes, $page*$nb_elem_per_page, $nb_elem_per_page) as $anime) :
            echo '<tr>';
            echo '<td>' . $anime->getNom() . '</td>';
            echo '<td>' . $anime->getDescription() . '</td>';
            echo '<td>' . $genreDAO->obtenirGenreParId($anime->getGenre())->getNom() . '</td>';
            echo '<td>' . $anime->getAuteur() . '</td>';
            echo '<td>' . $anime->getStudio() . '</td>';
            echo '<td>' . $anime->getNbEpisodes() . '</td>';
            echo '<td>' . $anime->getImgPath() . '</td>';
            echo '<td>' . $anime->getLienTrailer() . '</td>';
            echo '<td>' . $anime->getDescriptionDetaillee() . '</td>';
            echo '<td>';?>
            <a href="#modifierAnimeModal" onclick="afficherAnime('<?php echo $anime->getId()?>','<?php echo $anime->getNom()?>','<?php echo htmlspecialchars($anime->getDescription())?>','<?php echo $anime->getGenre()?>','<?php echo $anime->getAuteur()?>','<?php echo $anime->getStudio()?>','<?php echo $anime->getNbEpisodes()?>','<?php echo $anime->getImgPath()?>','<?php echo $anime->getLienTrailer()?>','<?php echo htmlspecialchars($anime->getDescriptionDetaillee())?>')" class="edit" data-toggle="modal"><span class="fa fa-edit"></span></a>
            <a href="#supprimerAnimeModal" onclick="afficherAnimeSupprimer('<?php echo $anime->getNom()?>')" class="delete pl-2" data-toggle="modal"><span class="fa fa-trash"></span></a>
            </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <ul id="paginator" class="pagination pt-4 flex-wrap" style="justify-content: center;">
        <?php
        for($i=1;$i<=$number_of_pages;$i++){
            if($i == 1)
            {
                echo '
                <li id="page-' . $i . '" class="' . (('page-' . ($page + 1)=='page-' .$i)?'page-item active':'') . '"><a class="page-link" href="' . SITE . 'admin/anime/page/' . $i . '">' . $i . '</a></li>
                ';
            }
            else
            {
                echo '
                <li id="page-' . $i . '" class="' . (('page-' . ($page + 1)=='page-' .$i)?'page-item active':'') . '"><a class="page-link" href="' . SITE . 'admin/anime/page/' . $i . '">' . $i . '</a></li>
                ';
            }
        }
        ?>
    </ul>
</div>
</div>
<!-- Edit Modal HTML -->
<div id="ajouterAnimeModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="<?php echo SITE  . "admin"?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo _("Ajouter un anime")?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['nom'])) {
                        foreach ($anime->listeErreursActives['nom'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Nom")?></label>
                    <input id="ajouterNomAnime" name="ajouterNomAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['description'])) {
                        foreach ($anime->listeErreursActives['description'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Description")?></label>
                    <textarea id="ajouterDescriptionAnime" name="ajouterDescriptionAnime" class="form-control" required></textarea>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['genre'])) {
                        foreach ($anime->listeErreursActives['genre'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Genre")?></label>
                    <select class="form-control" id="select-genre-ajouter-anime">
                        <?php
                        foreach ($listeGenres as $genre) :?>
                            <option onclick="changeGenreAjouter()" value="<?php echo $genre->getId() ?>"><?php echo $genre->getNom() ?></option>
                        <?php endforeach;?>
                    </select>
                    <input id="ajouterGenreAnime" name="ajouterGenreAnime" type="hidden" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['auteur'])) {
                        foreach ($anime->listeErreursActives['auteur'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Auteur")?></label>
                    <input id="ajouterAuteurAnime" name="ajouterAuteurAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['studio'])) {
                        foreach ($anime->listeErreursActives['studio'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Studio")?></label>
                    <input id="ajouterStudioAnime" name="ajouterStudioAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['nbEpisodes'])) {
                        foreach ($anime->listeErreursActives['nbEpisodes'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Nombres d'episodes")?></label>
                    <input id="ajouterNbEpisodeAnime" name="ajouterNbEpisodeAnime" type="number" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['cheminImage'])) {
                        foreach ($anime->listeErreursActives['cheminImage'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                }
                if(isset($_SESSION["erreurImageAjouter"])) {
                    echo '<div class="alert alert-danger" role="alert">' .
                        $_SESSION["erreurImageAjouter"] .
                        '</div>';
                    $_SESSION["erreurImageAjouter"] = null;
                } ?>
                <div class="form-group">
                    <label><?php echo _("Image")?></label>
                    <input class="form-control" type="file" name="imageAnimeAjouter" id="imageAnimeAjouter" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['lienTrailer'])) {
                        foreach ($anime->listeErreursActives['lienTrailer'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Opening")?></label>
                    <input id="ajouterOpeningAnime" name="ajouterOpeningAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['descriptionDetaillee'])) {
                        foreach ($anime->listeErreursActives['descriptionDetaillee'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Description détaillé")?></label>
                    <textarea id="ajouterDescriptionDetailleAnime" name="ajouterDescriptionDetailleAnime" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                <button type="submit" class="btn btn-success" name="ajouterAnime"><?php echo _("Ajouter")?></button>
            </div>
    </div>
    </form>
</div>
</div>
<!-- Edit Modal HTML -->
<div id="modifierAnimeModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="<?php echo SITE  . "admin"?>" enctype="multipart/form-data">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo _("Modification de l'anime")?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input id="modifierIdAnime" name="modifierIdAnime" type="hidden" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['nom'])) {
                        foreach ($anime->listeErreursActives['nom'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Nom")?></label>
                    <input id="modifierNomAnime" name="modifierNomAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['description'])) {
                        foreach ($anime->listeErreursActives['description'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Description")?></label>
                    <textarea id="modifierDescriptionAnime" name="modifierDescriptionAnime" class="form-control" required></textarea>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['genre'])) {
                        foreach ($anime->listeErreursActives['genre'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Genre")?></label>
                    <select class="form-control" id="select-genre-modifier-anime">
                        <?php
                        foreach ($listeGenres as $genre) :?>
                            <option onclick="changeGenreModifier()" value="<?php echo $genre->getId() ?>"><?php echo $genre->getNom() ?></option>
                        <?php endforeach;?>
                    </select>
                    <input id="modifierGenreAnime" name="modifierGenreAnime" type="hidden" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['auteur'])) {
                        foreach ($anime->listeErreursActives['auteur'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Auteur")?></label>
                    <input id="modifierAuteurAnime" name="modifierAuteurAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['studio'])) {
                        foreach ($anime->listeErreursActives['studio'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Studio")?></label>
                    <input id="modifierStudioAnime" name="modifierStudioAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['nbEpisodes'])) {
                        foreach ($anime->listeErreursActives['nbEpisodes'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Nombres d'episodes")?></label>
                    <input id="modifierNbEpisodeAnime" name="modifierNbEpisodeAnime" type="number" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['cheminImage'])) {
                        foreach ($anime->listeErreursActives['cheminImage'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <?php
                if(isset($_SESSION["erreurImage"])) {
                    echo '<div class="alert alert-danger" role="alert">' .
                        $_SESSION["erreurImage"] .
                        '</div>';
                    $_SESSION["erreurImage"] = null;
                } ?>
                <div class="form-group">
                    <label><?php echo _("Chemin de l'image")?></label>
                    <input id="modifierCheminImageAnime" name="modifierCheminImageAnime" type="text" class="form-control" required>
                    <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['lienTrailer'])) {
                        foreach ($anime->listeErreursActives['lienTrailer'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Opening")?></label>
                    <input id="modifierOpeningAnime" name="modifierOpeningAnime" type="text" class="form-control" required>
                </div>
                <?php
                if(isset($_SESSION["anime"])) {
                    $anime = $_SESSION["anime"];
                    if(!empty($anime->listeErreursActives['descriptionDetaillee'])) {
                        foreach ($anime->listeErreursActives['descriptionDetaillee'] as $erreur) {
                            echo '<div class="alert alert-danger" role="alert">' .
                                $erreur .
                                '</div>';
                        }
                    }
                } ?>
                <div class="form-group">
                    <label><?php echo _("Description Détaillé")?></label>
                    <textarea id="modifierDescriptionDetailleAnime" name="modifierDescriptionDetailleAnime" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                <button type="submit" class="btn btn-info" name="modifierAnime"><?php echo _("Sauvegarder")?></button>
            </div>
    </div>
    </form>
</div>
</div>
<!-- Delete Modal HTML -->
<div id="supprimerAnimeModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="<?php echo SITE  . "admin"?>">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo _("Suppression de l'anime")?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <p><?php echo _("Voulez-vous vraiment supprimer cet anime ?")?></p>
                <input id="supprimerAnimeNom" name="supprimerAnimeNom"></input>
                <p class="text-warning"><small><?php echo _("Cette action est irréversible !")?></small></p>
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                <button type="submit" class="btn btn-danger" name="supprimerAnime"><?php echo _("Supprimer")?></button>
            </div>
        </form>
    </div>
</div>
