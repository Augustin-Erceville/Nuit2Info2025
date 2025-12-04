<?php
/**
 * Fichier : src/modele/Reonditionnement.php
 * Modèle représentant un réonditionnement de la table `reonditionnement`.
 */

class Reonditionnement
{
    private $id_reonditionnement;
    private $id_materiel;
    private $id_utilisateur;
    private $date_reonditionnement;
    private $etat_initial;
    private $etat_final;
    private $description;
    private $cout;
    private $duree_travaux;
    private $statut;

    public function __construct(
        ?int $id_reonditionnement = null,
        int $id_materiel = 0,
        int $id_utilisateur = 0,
        ?string $date_reonditionnement = null,
        string $etat_initial = '',
        string $etat_final = '',
        string $description = '',
        ?float $cout = null,
        ?int $duree_travaux = null,
        string $statut = 'planifie'
    ) {
        $this->id_reonditionnement = $id_reonditionnement;
        $this->id_materiel = $id_materiel;
        $this->id_utilisateur = $id_utilisateur;
        $this->date_reonditionnement = $date_reonditionnement ?? date('Y-m-d H:i:s');
        $this->etat_initial = $etat_initial;
        $this->etat_final = $etat_final;
        $this->description = $description;
        $this->cout = $cout;
        $this->duree_travaux = $duree_travaux;
        $this->statut = $statut;
    }

    // Getters
    public function getIdReonditionnement(): ?int
    {
        return $this->id_reonditionnement;
    }

    public function getIdMateriel(): int
    {
        return $this->id_materiel;
    }

    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }

    public function getDateReonditionnement(): string
    {
        return $this->date_reonditionnement;
    }

    public function getEtatInitial(): string
    {
        return $this->etat_initial;
    }

    public function getEtatFinal(): string
    {
        return $this->etat_final;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCout(): ?float
    {
        return $this->cout;
    }

    public function getDureeTravaux(): ?int
    {
        return $this->duree_travaux;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    // Setters
    public function setIdReonditionnement(?int $id_reonditionnement): void
    {
        $this->id_reonditionnement = $id_reonditionnement;
    }

    public function setIdMateriel(int $id_materiel): void
    {
        $this->id_materiel = $id_materiel;
    }

    public function setIdUtilisateur(int $id_utilisateur): void
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setDateReonditionnement(string $date_reonditionnement): void
    {
        $this->date_reonditionnement = $date_reonditionnement;
    }

    public function setEtatInitial(string $etat_initial): void
    {
        $this->etat_initial = $etat_initial;
    }

    public function setEtatFinal(string $etat_final): void
    {
        $this->etat_final = $etat_final;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCout(?float $cout): void
    {
        $this->cout = $cout;
    }

    public function setDureeTravaux(?int $duree_travaux): void
    {
        $this->duree_travaux = $duree_travaux;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    // Méthodes utilitaires
    public function getDureeFormatee(): string
    {
        if ($this->duree_travaux === null) {
            return 'Non spécifiée';
        }
        
        $heures = floor($this->duree_travaux / 60);
        $minutes = $this->duree_travaux % 60;
        
        $result = [];
        if ($heures > 0) {
            $result[] = $heures . 'h';
        }
        if ($minutes > 0 || empty($result)) {
            $result[] = $minutes . 'min';
        }
        
        return implode(' ', $result);
    }

    public function getCoutFormate(): string
    {
        return $this->cout !== null ? number_format($this->cout, 2, ',', ' ') . ' €' : 'Non spécifié';
    }
}
