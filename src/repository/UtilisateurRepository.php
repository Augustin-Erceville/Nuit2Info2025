<?php
namespace repository;
require_once __DIR__ . '/../bdd/config.php';
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

    public function inscription(array $data): array {
        try {

            $stmt = $this->bdd->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = :email");
            $stmt->execute(['email' => $data['email']]);
            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'error' => 'Email déjà utilisé.'];
            }

            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

            $stmt = $this->bdd->prepare("
    INSERT INTO utilisateur (prenom, nom, email, mdp, rue, cd, ville, status)
    VALUES (:prenom, :nom, :email, :mdp, :rue, :cd, :ville, 'Attente')
");

            $stmt->execute([
                'prenom' => $data['prenom'],
                'nom' => $data['nom'],
                'email' => $data['email'],
                'mdp' => $hashedPassword,
                'rue' => $data['rue'],
                'cd' => $data['cd'],
                'ville' => $data['ville'],
            ]);

            return ['success' => true, 'error' => ''];
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
            $utilisateur->setIdUtilisateur($userData['id_utilisateur']);
            $utilisateur->setPrenom($userData['prenom']);
            $utilisateur->setNom($userData['nom']);
            $utilisateur->setEmail($userData['email']);
            $utilisateur->setMdp($userData['mdp']);
            $utilisateur->setRole($userData['role'] ?? 'user');
            $utilisateur->setRue($userData['rue']);
            $utilisateur->setCd($userData['cd']);
            $utilisateur->setVille($userData['ville']);
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

            if (password_verify($password, $user['mdp'])) {

                return new Utilisateur(
                    $user['id_utilisateur'],
                    $user['prenom'],
                    $user['nom'],
                    $user['email'],
                    $user['mdp'], 
                    $user['role'],
                    $user['rue'],
                    $user['cd'],
                    $user['ville']
                );

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
            $sql = "SELECT id_utilisateur, nom, prenom, email, role, ville, status 
                FROM utilisateur 
                ORDER BY id_utilisateur ASC";
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
            rue = :rue,
            cd = :cd,
            ville = :ville,
            role = :role,
            status = :status
        WHERE id_utilisateur = :id_utilisateur
    ');

        return $req->execute([
            ':id_utilisateur' => $utilisateur->getIdUtilisateur(),
            ':prenom' => $utilisateur->getPrenom(),
            ':nom'    => $utilisateur->getNom(),
            ':email'  => $utilisateur->getEmail(),
            ':rue'    => $utilisateur->getRue() ?? '',
            ':cd'     => $utilisateur->getCd() ?? 0,
            ':ville'  => $utilisateur->getVille() ?? '',
            ':role'   => $utilisateur->getRole() ?? 'user',
            ':status' => $utilisateur->getStatus() ?? 'Attente',

        ]);
    }

    public function supprimerUtilisateur($id)
    {
        $req = $this->bdd->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
        return $req->execute([':id' => $id]);
    }

}

include __DIR__ . '/../vue/footer.php';

?>