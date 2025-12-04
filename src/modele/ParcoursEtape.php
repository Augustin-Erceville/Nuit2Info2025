<?php

class ParcoursEtape
{
    private $id_etape;
    private $id_parcours;
    private $titre;
    private $description;
    private $contenu;
    private $type_contenu;
    private $ordre;
    private $est_terminee;
    private $date_creation;
    private $date_modification;

    public function __construct(
        ?int $id_etape = null,
        int $id_parcours = 0,
        string $titre = '',
        string $description = '',
        string $contenu = '',
        string $type_contenu = 'texte',
        int $ordre = 0,
        bool $est_terminee = false,
        ?string $date_creation = null,
        ?string $date_modification = null
    ) {
        $this->id_etape = $id_etape;
        $this->id_parcours = $id_parcours;
        $this->titre = $titre;
        $this->description = $description;
        $this->contenu = $contenu;
        $this->type_contenu = $type_contenu;
        $this->ordre = $ordre;
        $this->est_terminee = $est_terminee;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->date_modification = $date_modification;
    }

    public function getIdEtape(): ?int
    {
        return $this->id_etape;
    }

    public function getIdParcours(): int
    {
        return $this->id_parcours;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function getTypeContenu(): string
    {
        return $this->type_contenu;
    }

    public function getOrdre(): int
    {
        return $this->ordre;
    }

    public function estTerminee(): bool
    {
        return $this->est_terminee;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getDateModification(): ?string
    {
        return $this->date_modification;
    }

    public function setIdEtape(?int $id_etape): void
    {
        $this->id_etape = $id_etape;
    }

    public function setIdParcours(int $id_parcours): void
    {
        $this->id_parcours = $id_parcours;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function setTypeContenu(string $type_contenu): void
    {
        $this->type_contenu = $type_contenu;
    }

    public function setOrdre(int $ordre): void
    {
        $this->ordre = $ordre;
    }

    public function setEstTerminee(bool $est_terminee): void
    {
        $this->est_terminee = $est_terminee;
    }

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setDateModification(?string $date_modification): void
    {
        $this->date_modification = $date_modification;
    }

    public function marquerCommeTerminee(): void
    {
        $this->est_terminee = true;
        $this->date_modification = date('Y-m-d H:i:s');
    }

    public function estDerniereEtape(): bool
    {

        return false;
    }
}