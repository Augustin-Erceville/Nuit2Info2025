<?php
/**
 * Fichier : src/modele/Quiz.php
 * Modèle représentant un quiz de la table `quiz`.
 */

class Quiz
{
    private $id_quiz;
    private $titre;
    private $description;
    private $id_createur;
    private $date_creation;
    private $date_modification;
    private $est_public;
    private $niveau_difficulte;
    private $duree_minutes;
    private $est_actif;

    public function __construct(
        ?int $id_quiz = null,
        string $titre = '',
        string $description = '',
        ?int $id_createur = null,
        ?string $date_creation = null,
        ?string $date_modification = null,
        bool $est_public = false,
        string $niveau_difficulte = 'moyen',
        ?int $duree_minutes = null,
        bool $est_actif = true
    ) {
        $this->id_quiz = $id_quiz;
        $this->titre = $titre;
        $this->description = $description;
        $this->id_createur = $id_createur;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->date_modification = $date_modification;
        $this->est_public = $est_public;
        $this->niveau_difficulte = $niveau_difficulte;
        $this->duree_minutes = $duree_minutes;
        $this->est_actif = $est_actif;
    }

    // Getters
    public function getIdQuiz(): ?int
    {
        return $this->id_quiz;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIdCreateur(): ?int
    {
        return $this->id_createur;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getDateModification(): ?string
    {
        return $this->date_modification;
    }

    public function estPublic(): bool
    {
        return $this->est_public;
    }

    public function getNiveauDifficulte(): string
    {
        return $this->niveau_difficulte;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->duree_minutes;
    }

    public function estActif(): bool
    {
        return $this->est_actif;
    }

    // Setters
    public function setIdQuiz(?int $id_quiz): void
    {
        $this->id_quiz = $id_quiz;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setIdCreateur(?int $id_createur): void
    {
        $this->id_createur = $id_createur;
    }

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setDateModification(?string $date_modification): void
    {
        $this->date_modification = $date_modification;
    }

    public function setEstPublic(bool $est_public): void
    {
        $this->est_public = $est_public;
    }

    public function setNiveauDifficulte(string $niveau_difficulte): void
    {
        $this->niveau_difficulte = $niveau_difficulte;
    }

    public function setDureeMinutes(?int $duree_minutes): void
    {
        $this->duree_minutes = $duree_minutes;
    }

    public function setEstActif(bool $est_actif): void
    {
        $this->est_actif = $est_actif;
    }

    // Méthodes utilitaires
    public function marquerCommeModifie(): void
    {
        $this->date_modification = date('Y-m-d H:i:s');
    }

    public function getDureeFormatee(): string
    {
        if ($this->duree_minutes === null) {
            return 'Illimité';
        }
        
        $heures = floor($this->duree_minutes / 60);
        $minutes = $this->duree_minutes % 60;
        
        $result = [];
        if ($heures > 0) {
            $result[] = $heures . 'h';
        }
        if ($minutes > 0 || empty($result)) {
            $result[] = $minutes . 'min';
        }
        
        return implode(' ', $result);
    }
}
