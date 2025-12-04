<?php
/**
 * Fichier : src/modele/Utilisateur.php
 * Modèle représentant un utilisateur de la table `utilisateur`.
 *
 * Ce modèle est compatible avec UtilisateurRepository :
 *  - new Utilisateur($id, $prenom, $nom, $email, $mdp, $role, $rue, $cd, $ville)
 *  - getters : getIdUtilisateur(), getPrenom(), getNom(), getEmail(),
 *              getRue(), getCd(), getVille(), getRole(), getStatus()
 */

class Utilisateur
{
    private $id_utilisateur;
    private $prenom;
    private $nom;
    private $email;
    private $mdp;
    private $role;
    private $rue;
    private $cd;
    private $ville;
    private $status;
    public function __construct(
        ?int $id_utilisateur = null,
        string $prenom = '',
        string $nom = '',
        string $email = '',
        string $mdp = '',
        string $role = 'user',
        ?string $rue = null,
        ?int $cd = null,
        ?string $ville = null,
        string $status = 'Attente'
    ) {
        $this->id_utilisateur = $id_utilisateur;
        $this->prenom         = $prenom;
        $this->nom            = $nom;
        $this->email          = $email;
        $this->mdp            = $mdp;
        $this->role           = $role;
        $this->rue            = $rue;
        $this->cd             = $cd;
        $this->ville          = $ville;
        $this->status         = $status;
    }
    public function getIdUtilisateur(): ?int
    {
        return $this->id_utilisateur;
    }
    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getMdp(): string
    {
        return $this->mdp;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getRue(): ?string
    {
        return $this->rue;
    }
    public function getCd(): ?int
    {
        return $this->cd;
    }
    public function getVille(): ?string
    {
        return $this->ville;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function setIdUtilisateur(?int $id_utilisateur): void
    {
        $this->id_utilisateur = $id_utilisateur;
    }
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setMdp(string $mdp): void
    {
        $this->mdp = $mdp;
    }
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
    public function setRue(?string $rue): void
    {
        $this->rue = $rue;
    }
    public function setCd(?int $cd): void
    {
        $this->cd = $cd;
    }
    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
    public function getNomComplet(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }
    public function toArray(): array
    {
        return [
            'id_utilisateur' => $this->id_utilisateur,
            'prenom'         => $this->prenom,
            'nom'            => $this->nom,
            'email'          => $this->email,
            'mdp'            => $this->mdp,
            'role'           => $this->role,
            'rue'            => $this->rue,
            'cd'             => $this->cd,
            'ville'          => $this->ville,
            'status'         => $this->status,
        ];
    }
}
