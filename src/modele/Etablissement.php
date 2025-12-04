<?php

class Etablissement
{
    private $id_etablissement;
    private $nom;
    private $adresse;
    private $code_postal;
    private $ville;
    private $pays;
    private $telephone;
    private $email;
    private $type_etablissement;
    private $date_creation;
    private $statut;

    public function __construct(
        ?int $id_etablissement = null,
        string $nom = '',
        string $adresse = '',
        string $code_postal = '',
        string $ville = '',
        string $pays = 'France',
        ?string $telephone = null,
        ?string $email = null,
        string $type_etablissement = 'scolaire',
        ?string $date_creation = null,
        string $statut = 'actif'
    ) {
        $this->id_etablissement = $id_etablissement;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->code_postal = $code_postal;
        $this->ville = $ville;
        $this->pays = $pays;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->type_etablissement = $type_etablissement;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->statut = $statut;
    }

    public function getIdEtablissement(): ?int
    {
        return $this->id_etablissement;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getCodePostal(): string
    {
        return $this->code_postal;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getTypeEtablissement(): string
    {
        return $this->type_etablissement;
    }

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setIdEtablissement(?int $id_etablissement): void
    {
        $this->id_etablissement = $id_etablissement;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setAdresse(string $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function setCodePostal(string $code_postal): void
    {
        $this->code_postal = $code_postal;
    }

    public function setVille(string $ville): void
    {
        $this->ville = $ville;
    }

    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setTypeEtablissement(string $type_etablissement): void
    {
        $this->type_etablissement = $type_etablissement;
    }

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}