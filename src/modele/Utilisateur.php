<?php

class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $adresse;
    private $telephone;
    private $dateNaissance;
    private $motDePasse;
    private $role;
    private $created_at;

    public function __construct($data = []) {
        if (isset($data['id'])) $this->id = $data['id'];
        if (isset($data['nom'])) $this->nom = $data['nom'];
        if (isset($data['prenom'])) $this->prenom = $data['prenom'];
        if (isset($data['email'])) $this->email = $data['email'];
        if (isset($data['adresse'])) $this->adresse = $data['adresse'];
        if (isset($data['telephone'])) $this->telephone = $data['telephone'];
        if (isset($data['dateNaissance'])) $this->dateNaissance = $data['dateNaissance'];
        if (isset($data['motDePasse'])) $this->motDePasse = $data['motDePasse'];
        if (isset($data['role'])) $this->role = $data['role'];
        if (isset($data['created_at'])) $this->created_at = $data['created_at'];
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getIdUtilisateur() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getDateNaissance() {
        return $this->dateNaissance;
    }

    public function getMotDePasse() {
        return $this->motDePasse;
    }

    public function getRole() {
        return $this->role;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setIdUtilisateur($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setDateNaissance($dateNaissance) {
        $this->dateNaissance = $dateNaissance;
    }

    public function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    // Méthodes utiles
    public function toArray() {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'dateNaissance' => $this->dateNaissance,
            'role' => $this->role,
            'created_at' => $this->created_at
        ];
    }

    public function getNomComplet() {
        return $this->prenom . ' ' . $this->nom;
    }
}
?>