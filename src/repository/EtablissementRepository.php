<?php
namespace repository;

require_once __DIR__ . '/../bdd/config.php.php';
require_once __DIR__ . '/../modele/Etablissement.php';

use PDO;
use PDOException;
use Etablissement;

class EtablissementRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Etablissement $etablissement): ?Etablissement
    {
        try {
            $query = "INSERT INTO etablissements (
                        nom, adresse, code_postal, ville, pays, 
                        telephone, email, type_etablissement, statut
                     ) VALUES (
                        :nom, :adresse, :code_postal, :ville, :pays, 
                        :telephone, :email, :type_etablissement, :statut
                     )";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'nom' => $etablissement->getNom(),
                'adresse' => $etablissement->getAdresse(),
                'code_postal' => $etablissement->getCodePostal(),
                'ville' => $etablissement->getVille(),
                'pays' => $etablissement->getPays(),
                'telephone' => $etablissement->getTelephone(),
                'email' => $etablissement->getEmail(),
                'type_etablissement' => $etablissement->getTypeEtablissement(),
                'statut' => $etablissement->getStatut()
            ]);

            $etablissement->setIdEtablissement($this->bdd->lastInsertId());
            return $etablissement;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création de l\'établissement : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Etablissement
    {
        try {
            $query = "SELECT * FROM etablissements WHERE id_etablissement = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return null;
            }

            return $this->createEtablissementFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération de l\'établissement : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Etablissement $etablissement): bool
    {
        try {
            $query = "UPDATE etablissements SET 
                     nom = :nom,
                     adresse = :adresse,
                     code_postal = :code_postal,
                     ville = :ville,
                     pays = :pays,
                     telephone = :telephone,
                     email = :email,
                     type_etablissement = :type_etablissement,
                     statut = :statut
                     WHERE id_etablissement = :id_etablissement";
            
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'nom' => $etablissement->getNom(),
                'adresse' => $etablissement->getAdresse(),
                'code_postal' => $etablissement->getCodePostal(),
                'ville' => $etablissement->getVille(),
                'pays' => $etablissement->getPays(),
                'telephone' => $etablissement->getTelephone(),
                'email' => $etablissement->getEmail(),
                'type_etablissement' => $etablissement->getTypeEtablissement(),
                'statut' => $etablissement->getStatut(),
                'id_etablissement' => $etablissement->getIdEtablissement()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de l\'établissement : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "UPDATE etablissements SET statut = 'inactif' WHERE id_etablissement = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression de l\'établissement : ' . $e->getMessage());
            return false;
        }
    }

    public function findAllActive(): array
    {
        return $this->findByStatus('actif');
    }

    public function findByVille(string $ville): array
    {
        try {
            $query = "SELECT * FROM etablissements WHERE ville = :ville AND statut = 'actif' ORDER BY nom";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['ville' => $ville]);
            
            return $this->fetchEtablissements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des établissements par ville : ' . $e->getMessage());
            return [];
        }
    }

    public function findByType(string $type): array
    {
        try {
            $query = "SELECT * FROM etablissements WHERE type_etablissement = :type AND statut = 'actif' ORDER BY nom";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['type' => $type]);
            
            return $this->fetchEtablissements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des établissements par type : ' . $e->getMessage());
            return [];
        }
    }

    public function search(string $term): array
    {
        try {
            $query = "SELECT * FROM etablissements 
                     WHERE (nom LIKE :term OR ville LIKE :term OR code_postal LIKE :term) 
                     AND statut = 'actif' 
                     ORDER BY nom";
            $stmt = $this->bdd->prepare($query);
            $searchTerm = "%$term%";
            $stmt->execute(['term' => $searchTerm]);
            
            return $this->fetchEtablissements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche d\'établissements : ' . $e->getMessage());
            return [];
        }
    }

    private function findByStatus(string $statut): array
    {
        try {
            $query = "SELECT * FROM etablissements WHERE statut = :statut ORDER BY nom";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['statut' => $statut]);
            
            return $this->fetchEtablissements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des établissements par statut : ' . $e->getMessage());
            return [];
        }
    }

    private function fetchEtablissements($stmt): array
    {
        $etablissements = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etablissements[] = $this->createEtablissementFromData($data);
        }
        return $etablissements;
    }

    private function createEtablissementFromData(array $data): Etablissement
    {
        return new Etablissement(
            $data['id_etablissement'],
            $data['nom'],
            $data['adresse'],
            $data['code_postal'],
            $data['ville'],
            $data['pays'] ?? 'France',
            $data['telephone'],
            $data['email'],
            $data['type_etablissement'] ?? 'scolaire',
            $data['date_creation'],
            $data['statut'] ?? 'actif'
        );
    }
}
