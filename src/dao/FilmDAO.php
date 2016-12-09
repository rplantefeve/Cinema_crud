<?php

namespace Semeformation\Mvc\Cinema_crud\dao;

use Semeformation\Mvc\Cinema_crud\includes\DAO;
use Semeformation\Mvc\Cinema_crud\models\Film;

/**
 * Description of FilmDAO
 *
 * @author User
 */
class FilmDAO extends DAO {

    /**
     * Cr�e un film à partir d'une ligne de la BDD.
     *
     * @param array $row La ligne de r�sultat de la BDD.
     * @return Film
     */
    protected function buildBusinessObject($row) {
        $film = new Film();
        $film->setFilmId($row['FILMID']);
        $film->setTitre($row['TITRE']);
        if (array_key_exists('TITREORIGINAL', $row)) {
            $film->setTitreOriginal($row['TITREORIGINAL']);
        }
        return $film;
    }

    /**
     * M�thode qui renvoie la liste des films
     * @return array[][]
     */
    public function getMoviesList() {
        $requete   = "SELECT * FROM film";
        // on extrait les r�sultats
        $resultats = $this->extraireNxN($requete);
        // on extrait les objets m�tiers des r�sultats
        return $this->extractObjects($resultats);
    }

    /**
     * M�thode qui renvoie toutes les informations d'un film
     * @return array[]
     */
    public function getMovieByID($filmID) {
        $requete  = "SELECT * FROM film WHERE filmID = :filmID";
        $resultat = $this->extraire1xN($requete, ['filmID' => $filmID]);
        // on r�cupère l'objet Film
        $film     = $this->buildBusinessObject($resultat);
        // on retourne le r�sultat extrait
        return $film;
    }

    public function getCinemaMoviesByCinemaID($cinemaID) {
        // requ�te qui nous permet de r�cup�rer la liste des films pour un cin�ma donn�
        $requete   = "SELECT DISTINCT f.* FROM film f"
                . " INNER JOIN seance s ON f.filmID = s.filmID"
                . " AND s.cinemaID = :cinemaID";
        // on extrait les r�sultats
        $resultats = $this->extraireNxN($requete, ['cinemaID' => $cinemaID]);
        // on extrait les objets m�tiers des r�sultats
        return $this->extractObjects($resultats);
    }

    /**
     * M�thode qui ne renvoie que les films non encore marqu�s
     * comme favoris par l'utilisateur pass� en paramètre
     * @param int $userID Identifiant de l'utilisateur
     * @return Film[] Films pr�sents dans la base respectant les critères
     */
    public function getMoviesNonAlreadyMarkedAsFavorite($userID) {
        // requ�te de r�cup�ration des titres et des identifiants des films
        // qui n'ont pas encore �t� marqu�s comme favoris par l'utilisateur
        $requete   = "SELECT f.filmID, f.titre "
                . "FROM film f"
                . " WHERE f.filmID NOT IN ("
                . "SELECT filmID"
                . " FROM prefere"
                . " WHERE userID = :id"
                . ")";
        // extraction de r�sultat
        $resultats = $this->extraireNxN($requete, ['id' => $userID], false);
        // on extrait les objets m�tiers des r�sultats
        return $this->extractObjects($resultats);
    }

    /**
     * Renvoie une liste de films pas encore programm�s pour un cinema donn�
     * @param integer $cinemaID
     * @return array
     */
    public function getNonPlannedMovies($cinemaID) {
        // requ�te de r�cup�ration des titres et des identifiants des films
        // qui n'ont pas encore �t� programm�s dans ce cin�ma
        $requete  = "SELECT f.filmID, f.titre "
                . "FROM film f"
                . " WHERE f.filmID NOT IN ("
                . "SELECT filmID"
                . " FROM seance"
                . " WHERE cinemaID = :id"
                . ")";
        // extraction de r�sultat
        $resultat = $this->extraireNxN($requete, ['id' => $cinemaID], false);
        // on extrait les objets m�tiers des r�sultats
        return $this->extractObjects($resultat);
    }

}
