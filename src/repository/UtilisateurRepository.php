<?php
namespace repository;
require_once __DIR__ . '/../Bdd/config.php';
require_once __DIR__ . '/../modele/Utilisateur.php';

use \PDO;
use PDOException;
use \Utilisateur;

class UtilisateurRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function Inscription($data): array {
        try {
            // Convertir objet en tableau si nécessaire
            if (is_object($data)) {
                $data = [
                    'prenom' => $data->getPrenom(),
                    'nom' => $data->getNom(),
                    'email' => $data->getEmail(),
                    'motDePasse' => $data->getMotDePasse(),
                    'dateNaissance' => $data->getDateNaissance(),
                    'adresse' => $data->getAdresse(),
                    'telephone' => $data->getTelephone(),
                ];
            }

            // Vérifier si l'email existe déjà
            $stmt = $this->bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
            $stmt->execute([$data['email']]);
            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'error' => 'Cet email est déjà utilisé.'];
            }

            // Hasher le mot de passe
            $hashedPassword = password_hash($data['motDePasse'], PASSWORD_BCRYPT);

            // Insérer l'utilisateur - NOMS DE COLONNES ADAPTÉS À VOTRE TABLE
            $stmt = $this->bdd->prepare("
                INSERT INTO utilisateur (prenom, nom, email, mot_de_passe, date_naissance, adresse, téléphone, role)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $result = $stmt->execute([
                $data['prenom'],
                $data['nom'],
                $data['email'],
                $hashedPassword,
                $data['dateNaissance'],
                $data['adresse'],
                $data['telephone'],
                'eleve' // Rôle par défaut
            ]);

            return ['success' => $result, 'error' => ''];

        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()];
        }
    }

    public function getUtilisateurParMail($email)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            $utilisateur = new Utilisateur();
            $utilisateur->setIdUtilisateur($userData['id']);
            $utilisateur->setPrenom($userData['prenom']);
            $utilisateur->setNom($userData['nom']);
            $utilisateur->setEmail($userData['email']);
            $utilisateur->setMotDePasse($userData['mot_de_passe']);
            $utilisateur->setAdresse($userData['adresse']);
            $utilisateur->setTelephone($userData['téléphone']);
            $utilisateur->setDateNaissance($userData['date_naissance']);
            return $utilisateur;
        }

        return null;
    }

    public function connexion(string $email, string $password)
    {
        $email = trim($email);
        $password = trim($password);

        if (empty($email) || empty($password)) {
            return false;
        }

        try {
            $sql = "SELECT * FROM utilisateur WHERE email = ?";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            if (password_verify($password, $user['mot_de_passe'])) {
                // Créer un objet Utilisateur avec toutes les données
                $utilisateur = new Utilisateur([
                    'id' => $user['id'],
                    'prenom' => $user['prenom'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'motDePasse' => $user['mot_de_passe'],
                    'adresse' => $user['adresse'],
                    'dateNaissance' => $user['date_naissance'],
                    'telephone' => $user['téléphone'],
                    'role' => $user['role'] ?? 'eleve'
                ]);

                return $utilisateur;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            error_log("Erreur connexion utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public function findAll(): array
    {
        try {
            $sql = "SELECT id, nom, prenom, email, adresse, téléphone, date_naissance, role
                FROM utilisateur 
                ORDER BY id ASC";
            $stmt = $this->bdd->query($sql);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erreur findAll utilisateurs : ' . $e->getMessage());
            return [];
        }
    }

    public function modifierUtilisateur(Utilisateur $utilisateur)
    {
        $req = $this->bdd->prepare('
            UPDATE utilisateur
            SET prenom = :prenom,
                nom = :nom,
                email = :email,
                adresse = :adresse,
                téléphone = :telephone,
                date_naissance = :dateNaissance,
                mot_de_passe = :motDePasse
            WHERE id = :id
        ');

        return $req->execute([
            ':id' => $utilisateur->getIdUtilisateur(),
            ':prenom' => $utilisateur->getPrenom(),
            ':nom'    => $utilisateur->getNom(),
            ':email'  => $utilisateur->getEmail(),
            ':adresse'    => $utilisateur->getAdresse(),
            ':dateNaissance'     => $utilisateur->getDateNaissance(),
            ':motDePasse'  => $utilisateur->getMotDePasse(),
            ':telephone'   => $utilisateur->getTelephone(),
        ]);
    }

    public function supprimerUtilisateur($id)
    {
        $req = $this->bdd->prepare('DELETE FROM utilisateur WHERE id = :id');
        return $req->execute([':id' => $id]);
    }
}
?>