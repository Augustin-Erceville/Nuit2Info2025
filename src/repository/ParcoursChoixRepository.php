<?php
namespace repository;

require_once __DIR__ . '/../bdd/Bdd.php';
require_once __DIR__ . '/../modele/ParcoursChoix.php';

use PDO;
use PDOException;
use ParcoursChoix;

class ParcoursChoixRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(ParcoursChoix $choix): ?ParcoursChoix
    {
        try {
            $query = "INSERT INTO parcours_choix (
                        id_parcours, id_etape_suivante, libelle_choix, 
                        est_correct, ordre, points
                     ) VALUES (
                        :id_parcours, :id_etape_suivante, :libelle_choix, 
                        :est_correct, :ordre, :points
                     )";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_parcours' => $choix->getIdParcours(),
                'id_etape_suivante' => $choix->getIdEtapeSuivante(),
                'libelle_choix' => $choix->getLibelleChoix(),
                'est_correct' => $choix->estCorrect() ? 1 : 0,
                'ordre' => $choix->getOrdre(),
                'points' => $choix->getPoints()
            ]);

            $choix->setIdChoix($this->bdd->lastInsertId());
            return $choix;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création du choix de parcours : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?ParcoursChoix
    {
        try {
            $query = "SELECT * FROM parcours_choix WHERE id_choix = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return null;
            }

            return $this->createParcoursChoixFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération du choix de parcours : ' . $e->getMessage());
            return null;
        }
    }

    public function update(ParcoursChoix $choix): bool
    {
        try {
            $query = "UPDATE parcours_choix SET 
                     id_parcours = :id_parcours,
                     id_etape_suivante = :id_etape_suivante,
                     libelle_choix = :libelle_choix,
                     est_correct = :est_correct,
                     ordre = :ordre,
                     points = :points
                     WHERE id_choix = :id_choix";
            
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'id_parcours' => $choix->getIdParcours(),
                'id_etape_suivante' => $choix->getIdEtapeSuivante(),
                'libelle_choix' => $choix->getLibelleChoix(),
                'est_correct' => $choix->estCorrect() ? 1 : 0,
                'ordre' => $choix->getOrdre(),
                'points' => $choix->getPoints(),
                'id_choix' => $choix->getIdChoix()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du choix de parcours : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM parcours_choix WHERE id_choix = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression du choix de parcours : ' . $e->getMessage());
            return false;
        }
    }

    public function findByParcours(int $id_parcours): array
    {
        try {
            $query = "SELECT * FROM parcours_choix 
                     WHERE id_parcours = :id_parcours 
                     ORDER BY ordre, id_choix";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_parcours' => $id_parcours]);
            
            return $this->fetchParcoursChoix($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des choix de parcours : ' . $e->getMessage());
            return [];
        }
    }

    public function findByEtape(int $id_etape): array
    {
        try {
            $query = "SELECT pc.* FROM parcours_choix pc
                     JOIN parcours_etapes pe ON pc.id_etape_suivante = pe.id_etape
                     WHERE pe.id_etape = :id_etape
                     ORDER BY pc.ordre, pc.id_choix";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_etape' => $id_etape]);
            
            return $this->fetchParcoursChoix($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des choix pour l\'étape : ' . $e->getMessage());
            return [];
        }
    }

    public function findChoixCorrects(int $id_parcours): array
    {
        try {
            $query = "SELECT * FROM parcours_choix 
                     WHERE id_parcours = :id_parcours AND est_correct = 1
                     ORDER BY ordre, id_choix";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_parcours' => $id_parcours]);
            
            return $this->fetchParcoursChoix($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des choix corrects : ' . $e->getMessage());
            return [];
        }
    }

    public function reorderChoices(int $id_parcours, array $newOrder): bool
    {
        try {
            $this->bdd->beginTransaction();
            
            $query = "UPDATE parcours_choix SET ordre = :ordre WHERE id_choix = :id_choix";
            $stmt = $this->bdd->prepare($query);
            
            foreach ($newOrder as $position => $id_choix) {
                $stmt->execute([
                    'ordre' => $position + 1,
                    'id_choix' => $id_choix
                ]);
            }
            
            $this->bdd->commit();
            return true;
            
        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors du réordonnancement des choix : ' . $e->getMessage());
            return false;
        }
    }

    private function fetchParcoursChoix($stmt): array
    {
        $choix = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $choix[] = $this->createParcoursChoixFromData($data);
        }
        return $choix;
    }

    private function createParcoursChoixFromData(array $data): ParcoursChoix
    {
        return new ParcoursChoix(
            $data['id_choix'],
            $data['id_parcours'],
            $data['id_etape_suivante'],
            $data['libelle_choix'],
            (bool)$data['est_correct'],
            (int)$data['ordre'],
            (int)($data['points'] ?? 0)
        );
    }
}
