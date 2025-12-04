<?php

class Defi
{
    private $id_defi;
    private $titre;
    private $description;
    private $date_creation;
    private $date_limite;
    private $id_createur;
    private $statut;
    private $recompense;
    private $niveau_difficulte;

    public function __construct(
        ?int $id_defi = null,
        string $titre = '',
        string $description = '',
        ?string $date_creation = null,
        ?string $date_limite = null,
        int $id_createur = 0,
        string $statut = 'actif',
        ?string $recompense = null,
        string $niveau_difficulte = 'moyen'
    ) {
        $this->id_defi = $id_defi;
        $this->titre = $titre;
        $this->description = $description;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->date_limite = $date_limite;
        $this->id_createur = $id_createur;
        $this->statut = $statut;
        $this->recompense = $recompense;
        $this->niveau_difficulte = $niveau_difficulte;
    }

    public function getIdDefi(): ?int
    {
        return $this->id_defi;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getDateLimite(): ?string
    {
        return $this->date_limite;
    }

    public function getIdCreateur(): int
    {
        return $this->id_createur;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getRecompense(): ?string
    {
        return $this->recompense;
    }

    public function getNiveauDifficulte(): string
    {
        return $this->niveau_difficulte;
    }

    public function setIdDefi(?int $id_defi): void
    {
        $this->id_defi = $id_defi;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setDateLimite(?string $date_limite): void
    {
        $this->date_limite = $date_limite;
    }

    public function setIdCreateur(int $id_createur): void
    {
        $this->id_createur = $id_createur;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setRecompense(?string $recompense): void
    {
        $this->recompense = $recompense;
    }

    public function setNiveauDifficulte(string $niveau_difficulte): void
    {
        $this->niveau_difficulte = $niveau_difficulte;
    }
}