<?php
namespace repository;

require_once __DIR__ . '/../bdd/Bdd.php';
require_once __DIR__ . '/../modele/Repondre.php';

use PDO;
use PDOException;
use Repondre;

class RepondreRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Repondre $reponse): ?Repondre
    {
        try {
            $query = "INSERT INTO repondre (
                        id_utilisateur, id_question, id_choix, 
                        date_reponse, est_correct, temps_reponse
                     ) VALUES (
                        :id_utilisateur, :id_question, :id_choix, 
                        :date_reponse, :est_correct, :temps_reponse
                     )";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_utilisateur' => $reponse->getIdUtilisateur(),
                'id_question' => $reponse->getIdQuestion(),
                'id_choix' => $reponse->getIdChoix(),
                'date_reponse' => $reponse->getDateReponse(),
                'est_correct' => $reponse->estCorrect(),
                'temps_reponse' => $reponse->getTempsReponse()
            ]);

            $reponse->setIdReponse($this->bdd->lastInsertId());
            return $reponse;
        } catch (PDOException $e) {
            error_log('Erreur lors de l\'enregistrement de la réponse : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Repondre
    {
        try {
            $query = "SELECT * FROM repondre WHERE id_reponse = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return null;
            }

            return $this->createRepondreFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération de la réponse : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Repondre $reponse): bool
    {
        try {
            $query = "UPDATE repondre SET 
                     id_utilisateur = :id_utilisateur,
                     id_question = :id_question,
                     id_choix = :id_choix,
                     date_reponse = :date_reponse,
                     est_correct = :est_correct,
                     temps_reponse = :temps_reponse
                     WHERE id_reponse = :id_reponse";
            
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'id_utilisateur' => $reponse->getIdUtilisateur(),
                'id_question' => $reponse->getIdQuestion(),
                'id_choix' => $reponse->getIdChoix(),
                'date_reponse' => $reponse->getDateReponse(),
                'est_correct' => $reponse->estCorrect() ? 1 : 0,
                'temps_reponse' => $reponse->getTempsReponse(),
                'id_reponse' => $reponse->getIdReponse()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de la réponse : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM repondre WHERE id_reponse = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression de la réponse : ' . $e->getMessage());
            return false;
        }
    }

    public function findByUtilisateurEtQuestion(int $id_utilisateur, int $id_question): ?Repondre
    {
        try {
            $query = "SELECT * FROM repondre 
                     WHERE id_utilisateur = :id_utilisateur 
                     AND id_question = :id_question";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_utilisateur' => $id_utilisateur,
                'id_question' => $id_question
            ]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $data ? $this->createRepondreFromData($data) : null;
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche de la réponse : ' . $e->getMessage());
            return null;
        }
    }

    public function findReponsesUtilisateur(int $id_utilisateur, int $id_quiz = null): array
    {
        try {
            $query = "SELECT r.* FROM repondre r
                     JOIN question q ON r.id_question = q.id_question";
            
            $params = ['id_utilisateur' => $id_utilisateur];
            
            if ($id_quiz !== null) {
                $query .= " WHERE q.id_quiz = :id_quiz AND r.id_utilisateur = :id_utilisateur";
                $params['id_quiz'] = $id_quiz;
            } else {
                $query .= " WHERE r.id_utilisateur = :id_utilisateur";
            }
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute($params);
            
            return $this->fetchReponses($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des réponses de l\'utilisateur : ' . $e->getMessage());
            return [];
        }
    }

    public function getStatistiquesQuestion(int $id_question): array
    {
        try {
            // Nombre total de réponses
            $query = "SELECT 
                         COUNT(*) as total_reponses,
                         SUM(CASE WHEN est_correct = 1 THEN 1 ELSE 0 END) as bonnes_reponses,
                         AVG(temps_reponse) as temps_moyen
                      FROM repondre 
                      WHERE id_question = :id_question";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_question' => $id_question]);
            
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Pourcentage de bonnes réponses
            if ($stats['total_reponses'] > 0) {
                $stats['pourcentage_reussite'] = round(($stats['bonnes_reponses'] / $stats['total_reponses']) * 100, 2);
            } else {
                $stats['pourcentage_reussite'] = 0;
            }
            
            // Arrondir le temps moyen
            $stats['temps_moyen'] = $stats['temps_moyen'] !== null ? round($stats['temps_moyen']) : null;
            
            return $stats;
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération des statistiques de la question : ' . $e->getMessage());
            return [
                'total_reponses' => 0,
                'bonnes_reponses' => 0,
                'temps_moyen' => null,
                'pourcentage_reussite' => 0
            ];
        }
    }

    private function fetchReponses($stmt): array
    {
        $reponses = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reponses[] = $this->createRepondreFromData($data);
        }
        return $reponses;
    }

    private function createRepondreFromData(array $data): Repondre
    {
        return new Repondre(
            $data['id_reponse'],
            $data['id_utilisateur'],
            $data['id_question'],
            $data['id_choix'],
            $data['date_reponse'],
            $data['est_correct'] !== null ? (bool)$data['est_correct'] : null,
            $data['temps_reponse'] !== null ? (int)$data['temps_reponse'] : null
        );
    }
}
