<?php

class Idee
{
    private $id_idee;
    private $titre;
    private $description;
    private $date_creation;
    private $id_createur;
    private $statut;
    private $categorie;
    private $note_moyenne;
    private $nombre_votes;

    public function __construct(
        ?int $id_idee = null,
        string $titre = '',
        string $description = '',
        ?string $date_creation = null,
        int $id_createur = 0,
        string $statut = 'en_attente',
        string $categorie = 'general',
        float $note_moyenne = 0.0,
        int $nombre_votes = 0
    ) {
        $this->id_idee = $id_idee;
        $this->titre = $titre;
        $this->description = $description;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->id_createur = $id_createur;
        $this->statut = $statut;
        $this->categorie = $categorie;
        $this->note_moyenne = $note_moyenne;
        $this->nombre_votes = $nombre_votes;
    }

    public function getIdIdee(): ?int
    {
        return $this->id_idee;
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

    public function getIdCreateur(): int
    {
        return $this->id_createur;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function getNoteMoyenne(): float
    {
        return $this->note_moyenne;
    }

    public function getNombreVotes(): int
    {
        return $this->nombre_votes;
    }

    public function setIdIdee(?int $id_idee): void
    {
        $this->id_idee = $id_idee;
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

    public function setIdCreateur(int $id_createur): void
    {
        $this->id_createur = $id_createur;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function setNoteMoyenne(float $note_moyenne): void
    {
        $this->note_moyenne = $note_moyenne;
    }

    public function setNombreVotes(int $nombre_votes): void
    {
        $this->nombre_votes = $nombre_votes;
    }

    public function ajouterVote(float $note): void
    {
        $total_notes = $this->note_moyenne * $this->nombre_votes;
        $this->nombre_votes++;
        $this->note_moyenne = ($total_notes + $note) / $this->nombre_votes;
    }
}