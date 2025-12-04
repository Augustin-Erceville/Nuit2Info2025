<?php
namespace repository;

require_once __DIR__ . '/../bdd/Bdd.php';
require_once __DIR__ . '/../modele/Idee.php';

use PDO;
use PDOException;
use Idee;

class IdeeRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Idee $idee): ?Idee
    {
        try {
            $query = "INSERT INTO idee (
                        titre, description, id_createur, statut, 
                        categorie, note_moyenne, nombre_votes
                     ) VALUES (
                        :titre, :description, :id_createur, :statut, 
                        :categorie, :note_moyenne, :nombre_votes
                     )";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'titre' => $idee->getTitre(),
                'description' => $idee->getDescription(),
                'id_createur' => $idee->getIdCreateur(),
                'statut' => $idee->getStatut(),
                'categorie' => $idee->getCategorie(),
                'note_moyenne' => $idee->getNoteMoyenne(),
                'nombre_votes' => $idee->getNombreVotes()
            ]);

            $idee->setIdIdee($this->bdd->lastInsertId());
            return $idee;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création de l\'idée : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Idee
    {
        try {
            $query = "SELECT * FROM idee WHERE id_idee = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return null;
            }

            return $this->createIdeeFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération de l\'idée : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Idee $idee): bool
    {
        try {
            $query = "UPDATE idee SET 
                     titre = :titre,
                     description = :description,
                     statut = :statut,
                     categorie = :categorie,
                     note_moyenne = :note_moyenne,
                     nombre_votes = :nombre_votes
                     WHERE id_idee = :id_idee";
            
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'titre' => $idee->getTitre(),
                'description' => $idee->getDescription(),
                'statut' => $idee->getStatut(),
                'categorie' => $idee->getCategorie(),
                'note_moyenne' => $idee->getNoteMoyenne(),
                'nombre_votes' => $idee->getNombreVotes(),
                'id_idee' => $idee->getIdIdee()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de l\'idée : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM idee WHERE id_idee = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression de l\'idée : ' . $e->getMessage());
            return false;
        }
    }

    public function findApproved(): array
    {
        return $this->findByStatus('approuve');
    }

    public function findByCreateur(int $id_createur): array
    {
        try {
            $query = "SELECT * FROM idee WHERE id_createur = :id_createur ORDER BY date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_createur' => $id_createur]);
            
            return $this->fetchIdees($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des idées par créateur : ' . $e->getMessage());
            return [];
        }
    }

    public function findByCategorie(string $categorie): array
    {
        try {
            $query = "SELECT * FROM idee WHERE categorie = :categorie AND statut = 'approuve' ORDER BY note_moyenne DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['categorie' => $categorie]);
            
            return $this->fetchIdees($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des idées par catégorie : ' . $e->getMessage());
            return [];
        }
    }

    public function findTopRated(int $limit = 10): array
    {
        try {
            $query = "SELECT * FROM idee WHERE statut = 'approuve' AND nombre_votes > 0 
                     ORDER BY note_moyenne DESC, nombre_votes DESC LIMIT :limit";
            $stmt = $this->bdd->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            return $this->fetchIdees($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des idées les mieux notées : ' . $e->getMessage());
            return [];
        }
    }

    public function search(string $term): array
    {
        try {
            $query = "SELECT * FROM idee 
                     WHERE (titre LIKE :term OR description LIKE :term) 
                     AND statut = 'approuve' 
                     ORDER BY note_moyenne DESC, date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $searchTerm = "%$term%";
            $stmt->execute(['term' => $searchTerm]);
            
            return $this->fetchIdees($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche d\'idées : ' . $e->getMessage());
            return [];
        }
    }

    public function addVote(int $id_idee, float $note): bool
    {
        try {
            $this->bdd->beginTransaction();
            
            // Récupérer les données actuelles
            $idee = $this->findById($id_idee);
            if (!$idee) {
                throw new \Exception("Idée non trouvée");
            }
            
            // Mettre à jour la note
            $idee->ajouterVote($note);
            
            // Mettre à jour en base
            $query = "UPDATE idee SET 
                     note_moyenne = :note_moyenne,
                     nombre_votes = :nombre_votes
                     WHERE id_idee = :id_idee";
            
            $stmt = $this->bdd->prepare($query);
            $result = $stmt->execute([
                'note_moyenne' => $idee->getNoteMoyenne(),
                'nombre_votes' => $idee->getNombreVotes(),
                'id_idee' => $id_idee
            ]);
            
            $this->bdd->commit();
            return $result;
            
        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors de l\'ajout d\'un vote : ' . $e->getMessage());
            return false;
        }
    }

    private function findByStatus(string $statut): array
    {
        try {
            $query = "SELECT * FROM idee WHERE statut = :statut ORDER BY date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['statut' => $statut]);
            
            return $this->fetchIdees($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des idées par statut : ' . $e->getMessage());
            return [];
        }
    }

    private function fetchIdees($stmt): array
    {
        $idees = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idees[] = $this->createIdeeFromData($data);
        }
        return $idees;
    }

    private function createIdeeFromData(array $data): Idee
    {
        return new Idee(
            $data['id_idee'],
            $data['titre'],
            $data['description'],
            $data['date_creation'],
            $data['id_createur'],
            $data['statut'] ?? 'en_attente',
            $data['categorie'] ?? 'general',
            (float)($data['note_moyenne'] ?? 0.0),
            (int)($data['nombre_votes'] ?? 0)
        );
    }
}
