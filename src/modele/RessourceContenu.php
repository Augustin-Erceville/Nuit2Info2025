<?php
/**
 * Fichier : src/modele/RessourceContenu.php
 * Modèle représentant une ressource de contenu de la table `ressources_contenu`.
 */

class RessourceContenu
{
    private $id_ressource;
    private $titre;
    private $description;
    private $contenu;
    private $type_contenu;
    private $date_creation;
    private $date_modification;
    private $id_createur;
    private $est_public;
    private $categorie;
    private $mots_cles;
    private $nombre_vues;
    private $note_moyenne;

    public function __construct(
        ?int $id_ressource = null,
        string $titre = '',
        string $description = '',
        string $contenu = '',
        string $type_contenu = 'article',
        ?string $date_creation = null,
        ?string $date_modification = null,
        ?int $id_createur = null,
        bool $est_public = true,
        string $categorie = 'general',
        string $mots_cles = '',
        int $nombre_vues = 0,
        float $note_moyenne = 0.0
    ) {
        $this->id_ressource = $id_ressource;
        $this->titre = $titre;
        $this->description = $description;
        $this->contenu = $contenu;
        $this->type_contenu = $type_contenu;
        $this->date_creation = $date_creation ?? date('Y-m-d H:i:s');
        $this->date_modification = $date_modification;
        $this->id_createur = $id_createur;
        $this->est_public = $est_public;
        $this->categorie = $categorie;
        $this->mots_cles = $mots_cles;
        $this->nombre_vues = $nombre_vues;
        $this->note_moyenne = $note_moyenne;
    }

    // Getters
    public function getIdRessource(): ?int
    {
        return $this->id_ressource;
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

    public function getDateCreation(): string
    {
        return $this->date_creation;
    }

    public function getDateModification(): ?string
    {
        return $this->date_modification;
    }

    public function getIdCreateur(): ?int
    {
        return $this->id_createur;
    }

    public function estPublic(): bool
    {
        return $this->est_public;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }

    public function getMotsCles(): string
    {
        return $this->mots_cles;
    }

    public function getNombreVues(): int
    {
        return $this->nombre_vues;
    }

    public function getNoteMoyenne(): float
    {
        return $this->note_moyenne;
    }

    // Setters
    public function setIdRessource(?int $id_ressource): void
    {
        $this->id_ressource = $id_ressource;
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

    public function setDateCreation(string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function setDateModification(?string $date_modification): void
    {
        $this->date_modification = $date_modification;
    }

    public function setIdCreateur(?int $id_createur): void
    {
        $this->id_createur = $id_createur;
    }

    public function setEstPublic(bool $est_public): void
    {
        $this->est_public = $est_public;
    }

    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function setMotsCles(string $mots_cles): void
    {
        $this->mots_cles = $mots_cles;
    }

    public function setNombreVues(int $nombre_vues): void
    {
        $this->nombre_vues = $nombre_vues;
    }

    public function setNoteMoyenne(float $note_moyenne): void
    {
        $this->note_moyenne = $note_moyenne;
    }

    // Méthodes utilitaires
    public function incrementerVues(): void
    {
        $this->nombre_vues++;
    }

    public function getMotsClesTableau(): array
    {
        return array_filter(
            array_map('trim', 
                explode(',', $this->mots_cles)
            )
        );
    }

    public function contientMotCle(string $mot): bool
    {
        $mots = $this->getMotsClesTableau();
        return in_array(strtolower($mot), array_map('strtolower', $mots));
    }

    public function getExtrait(int $longueur = 200): string
    {
        $texte = strip_tags($this->contenu);
        if (mb_strlen($texte) <= $longueur) {
            return $texte;
        }
        return mb_substr($texte, 0, $longueur) . '...';
    }
}
