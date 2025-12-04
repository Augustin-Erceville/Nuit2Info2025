<?php

class Materiel
{
    private $id_materiel;
    private $nom;
    private $description;
    private $quantite_disponible;
    private $quantite_totale;
    private $etat;
    private $date_ajout;
    private $id_etablissement;

    public function __construct(
        ?int $id_materiel = null,
        string $nom = '',
        string $description = '',
        int $quantite_disponible = 0,
        int $quantite_totale = 0,
        string $etat = 'bon',
        ?string $date_ajout = null,
        ?int $id_etablissement = null
    ) {
        $this->id_materiel = $id_materiel;
        $this->nom = $nom;
        $this->description = $description;
        $this->quantite_disponible = $quantite_disponible;
        $this->quantite_totale = $quantite_totale;
        $this->etat = $etat;
        $this->date_ajout = $date_ajout ?? date('Y-m-d H:i:s');
        $this->id_etablissement = $id_etablissement;
    }

    public function getIdMateriel(): ?int
    {
        return $this->id_materiel;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getQuantiteDisponible(): int
    {
        return $this->quantite_disponible;
    }

    public function getQuantiteTotale(): int
    {
        return $this->quantite_totale;
    }

    public function getEtat(): string
    {
        return $this->etat;
    }

    public function getDateAjout(): string
    {
        return $this->date_ajout;
    }

    public function getIdEtablissement(): ?int
    {
        return $this->id_etablissement;
    }

    public function setIdMateriel(?int $id_materiel): void
    {
        $this->id_materiel = $id_materiel;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setQuantiteDisponible(int $quantite): void
    {
        $this->quantite_disponible = $quantite;
    }

    public function setQuantiteTotale(int $quantite): void
    {
        $this->quantite_totale = $quantite;
    }

    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }

    public function setDateAjout(string $date_ajout): void
    {
        $this->date_ajout = $date_ajout;
    }

    public function setIdEtablissement(?int $id_etablissement): void
    {
        $this->id_etablissement = $id_etablissement;
    }

    public function estDisponible(): bool
    {
        return $this->quantite_disponible > 0;
    }

    public function emprunter(int $quantite = 1): bool
    {
        if ($quantite <= 0 || $quantite > $this->quantite_disponible) {
            return false;
        }
        $this->quantite_disponible -= $quantite;
        return true;
    }

    public function retourner(int $quantite = 1): bool
    {
        if ($quantite <= 0 || ($this->quantite_disponible + $quantite) > $this->quantite_totale) {
            return false;
        }
        $this->quantite_disponible += $quantite;
        return true;
    }
}