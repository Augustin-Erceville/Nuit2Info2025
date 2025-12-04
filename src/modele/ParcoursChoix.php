<?php
/**
 * Fichier : src/modele/ParcoursChoix.php
 * Modèle représentant un choix de parcours de la table `parcours_choix`.
 */

class ParcoursChoix
{
    private $id_choix;
    private $id_parcours;
    private $id_etape_suivante;
    private $libelle_choix;
    private $est_correct;
    private $ordre;
    private $points;

    public function __construct(
        ?int $id_choix = null,
        int $id_parcours = 0,
        ?int $id_etape_suivante = null,
        string $libelle_choix = '',
        bool $est_correct = false,
        int $ordre = 0,
        int $points = 0
    ) {
        $this->id_choix = $id_choix;
        $this->id_parcours = $id_parcours;
        $this->id_etape_suivante = $id_etape_suivante;
        $this->libelle_choix = $libelle_choix;
        $this->est_correct = $est_correct;
        $this->ordre = $ordre;
        $this->points = $points;
    }

    // Getters
    public function getIdChoix(): ?int
    {
        return $this->id_choix;
    }

    public function getIdParcours(): int
    {
        return $this->id_parcours;
    }

    public function getIdEtapeSuivante(): ?int
    {
        return $this->id_etape_suivante;
    }

    public function getLibelleChoix(): string
    {
        return $this->libelle_choix;
    }

    public function estCorrect(): bool
    {
        return $this->est_correct;
    }

    public function getOrdre(): int
    {
        return $this->ordre;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    // Setters
    public function setIdChoix(?int $id_choix): void
    {
        $this->id_choix = $id_choix;
    }

    public function setIdParcours(int $id_parcours): void
    {
        $this->id_parcours = $id_parcours;
    }

    public function setIdEtapeSuivante(?int $id_etape_suivante): void
    {
        $this->id_etape_suivante = $id_etape_suivante;
    }

    public function setLibelleChoix(string $libelle_choix): void
    {
        $this->libelle_choix = $libelle_choix;
    }

    public function setEstCorrect(bool $est_correct): void
    {
        $this->est_correct = $est_correct;
    }

    public function setOrdre(int $ordre): void
    {
        $this->ordre = $ordre;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
}
