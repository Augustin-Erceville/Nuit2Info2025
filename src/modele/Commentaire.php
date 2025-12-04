<?php
/**
 * Fichier : src/modele/Commentaire.php
 * Modèle représentant un commentaire de la table `commentaires`.
 */

class Commentaire
{
    private $id_commentaire;
    private $id_utilisateur;
    private $contenu;
    private $date_creation;
    private $id_ressource;
    private $id_idee;
    private $id_defi;

    public function __construct(
        ?int $id_commentaire = null,
        int $id_utilisateur = 0,
        string $contenu = '',
        ?string $date_creation = null,
        ?int $id_ressource = null,
        ?int $id_idee = null,
        ?int $id_defi = null
    ) {
        $this->id_commentaire = $id_commentaire;
        $this->id_utilisateur = $id_utilisateur;
        $this->contenu = $contenu;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->id_ressource = $id_ressource;
        $this->id_idee = $id_idee;
        $this->id_defi = $id_defi;
    }

    // Getters
    public function getIdCommentaire(): ?int
    {
        return $this->id_commentaire;
    }

    public function getIdUtilisateur(): int
    {
        return $this->id_utilisateur;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getIdRessource(): ?int
    {
        return $this->id_ressource;
    }

    public function getIdIdee(): ?int
    {
        return $this->id_idee;
    }

    public function getIdDefi(): ?int
    {
        return $this->id_defi;
    }

    // Setters
    public function setIdCommentaire(?int $id_commentaire): void
    {
        $this->id_commentaire = $id_commentaire;
    }

    public function setIdUtilisateur(int $id_utilisateur): void
    {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setIdRessource(?int $id_ressource): void
    {
        $this->id_ressource = $id_ressource;
    }

    public function setIdIdee(?int $id_idee): void
    {
        $this->id_idee = $id_idee;
    }

    public function setIdDefi(?int $id_defi): void
    {
        $this->id_defi = $id_defi;
    }
}
