<?php
/**
 * Fichier : src/modele/Repondre.php
 * Modèle représentant une réponse à un quiz de la table `repondre`.
 */

class Repondre
{
    private $id_reponse;
    private $id_utilisateur;
    private $id_question;
    private $id_choix;
    private $date_reponse;
    private $est_correct;
    private $temps_reponse;

    public function __construct(
        ?int $id_reponse = null,
        int $id_utilisateur = 0,
        int $id_question = 0,
        int $id_choix = 0,
        ?string $date_reponse = null,
        ?bool $est_correct = null,
        ?int $temps_reponse = null
    ) {
        $this->id_reponse = $id_reponse;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_question = $id_question;
        $this->id_choix = $id_choix;
        $this->date_reponse = $date_reponse ?? date('Y-m-d H:i:s');
        $this->est_correct = $est_correct;
        $this->temps_reponse = $temps_reponse;
    }

    // Getters
    public function getIdReponse(): ?int
    {
        return $this->id_reponse;
    }

    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }

    public function getIdQuestion(): int
    {
        return $this->id_question;
    }

    public function getIdChoix(): int
    {
        return $this->id_choix;
    }

    public function getDateReponse(): string
    {
        return $this->date_reponse;
    }

    public function estCorrect(): ?bool
    {
        return $this->est_correct;
    }

    public function getTempsReponse(): ?int
    {
        return $this->temps_reponse;
    }

    // Setters
    public function setIdReponse(?int $id_reponse): void
    {
        $this->id_reponse = $id_reponse;
    }

    public function setIdUtilisateur(int $id_utilisateur): void
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setIdQuestion(int $id_question): void
    {
        $this->id_question = $id_question;
    }

    public function setIdChoix(int $id_choix): void
    {
        $this->id_choix = $id_choix;
    }

    public function setDateReponse(string $date_reponse): void
    {
        $this->date_reponse = $date_reponse;
    }

    public function setEstCorrect(?bool $est_correct): void
    {
        $this->est_correct = $est_correct;
    }

    public function setTempsReponse(?int $temps_reponse): void
    {
        $this->temps_reponse = $temps_reponse;
    }

    // Méthodes utilitaires
    public function getTempsFormate(): string
    {
        if ($this->temps_reponse === null) {
            return 'N/A';
        }
        
        $minutes = floor($this->temps_reponse / 60);
        $secondes = $this->temps_reponse % 60;
        
        return sprintf('%02d:%02d', $minutes, $secondes);
    }
}
