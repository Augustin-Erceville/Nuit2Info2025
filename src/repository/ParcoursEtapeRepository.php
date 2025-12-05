<?php
namespace repository;

require_once __DIR__ . '/../Bdd/config.php';
require_once __DIR__ . '/../modele/ParcoursEtape.php';

use PDO;
use PDOException;
use ParcoursEtape;

class ParcoursEtapeRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(ParcoursEtape $etape): ?ParcoursEtape
    {
        try {
            $query = "INSERT INTO parcours_etapes (
                        id_parcours, titre, description, contenu, 
                        type_contenu, ordre, est_terminee
                     ) VALUES (
                        :id_parcours, :titre, :description, :contenu, 
                        :type_contenu, :ordre, :est_terminee
                     )";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_parcours' => $etape->getIdParcours(),
                'titre' => $etape->getTitre(),
                'description' => $etape->getDescription(),
                'contenu' => $etape->getContenu(),
                'type_contenu' => $etape->getTypeContenu(),
                'ordre' => $etape->getOrdre(),
                'est_terminee' => $etape->estTerminee() ? 1 : 0
            ]);

            $etape->setIdEtape($this->bdd->lastInsertId());
            return $etape;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création de l\'étape de parcours : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?ParcoursEtape
    {
        try {
            $query = "SELECT * FROM parcours_etapes WHERE id_etape = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return $this->createParcoursEtapeFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération de l\'étape de parcours : ' . $e->getMessage());
            return null;
        }
    }

    public function update(ParcoursEtape $etape): bool
    {
        try {
            $query = "UPDATE parcours_etapes SET 
                     id_parcours = :id_parcours,
                     titre = :titre,
                     description = :description,
                     contenu = :contenu,
                     type_contenu = :type_contenu,
                     ordre = :ordre,
                     est_terminee = :est_terminee,
                     date_modification = NOW()
                     WHERE id_etape = :id_etape";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'id_parcours' => $etape->getIdParcours(),
                'titre' => $etape->getTitre(),
                'description' => $etape->getDescription(),
                'contenu' => $etape->getContenu(),
                'type_contenu' => $etape->getTypeContenu(),
                'ordre' => $etape->getOrdre(),
                'est_terminee' => $etape->estTerminee() ? 1 : 0,
                'id_etape' => $etape->getIdEtape()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de l\'étape de parcours : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM parcours_etapes WHERE id_etape = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression de l\'étape de parcours : ' . $e->getMessage());
            return false;
        }
    }

    public function findByParcours(int $id_parcours): array
    {
        try {
            $query = "SELECT * FROM parcours_etapes 
                     WHERE id_parcours = :id_parcours 
                     ORDER BY ordre, date_creation";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_parcours' => $id_parcours]);

            return $this->fetchParcoursEtapes($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des étapes du parcours : ' . $e->getMessage());
            return [];
        }
    }

    public function findPremiereEtape(int $id_parcours): ?ParcoursEtape
    {
        try {
            $query = "SELECT * FROM parcours_etapes 
                     WHERE id_parcours = :id_parcours 
                     ORDER BY ordre ASC, date_creation ASC 
                     LIMIT 1";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_parcours' => $id_parcours]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? $this->createParcoursEtapeFromData($data) : null;
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche de la première étape : ' . $e->getMessage());
            return null;
        }
    }

    public function findEtapeSuivante(int $id_parcours, int $ordre_actuel): ?ParcoursEtape
    {
        try {
            $query = "SELECT * FROM parcours_etapes 
                     WHERE id_parcours = :id_parcours AND ordre > :ordre_actuel
                     ORDER BY ordre ASC 
                     LIMIT 1";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_parcours' => $id_parcours,
                'ordre_actuel' => $ordre_actuel
            ]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? $this->createParcoursEtapeFromData($data) : null;
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche de l\'étape suivante : ' . $e->getMessage());
            return null;
        }
    }

    public function reorderEtapes(int $id_parcours, array $newOrder): bool
    {
        try {
            $this->bdd->beginTransaction();

            $query = "UPDATE parcours_etapes SET ordre = :ordre 
                     WHERE id_etape = :id_etape AND id_parcours = :id_parcours";
            $stmt = $this->bdd->prepare($query);

            foreach ($newOrder as $position => $id_etape) {
                $stmt->execute([
                    'ordre' => $position + 1,
                    'id_etape' => $id_etape,
                    'id_parcours' => $id_parcours
                ]);
            }

            $this->bdd->commit();
            return true;

        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors du réordonnancement des étapes : ' . $e->getMessage());
            return false;
        }
    }

    public function marquerCommeTerminee(int $id_etape): bool
    {
        try {
            $query = "UPDATE parcours_etapes SET 
                     est_terminee = 1,
                     date_modification = NOW()
                     WHERE id_etape = :id_etape";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id_etape' => $id_etape]);
        } catch (PDOException $e) {
            error_log('Erreur lors du marquage de l\'étape comme terminée : ' . $e->getMessage());
            return false;
        }
    }

    public function getProgressionParcours(int $id_parcours): array
    {
        try {
            $query = "SELECT 
                         COUNT(*) as total_etapes,
                         SUM(CASE WHEN est_terminee = 1 THEN 1 ELSE 0 END) as etapes_terminees
                      FROM parcours_etapes 
                      WHERE id_parcours = :id_parcours";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_parcours' => $id_parcours]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erreur lors du calcul de la progression : ' . $e->getMessage());
            return ['total_etapes' => 0, 'etapes_terminees' => 0];
        }
    }

    private function fetchParcoursEtapes($stmt): array
    {
        $etapes = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $etapes[] = $this->createParcoursEtapeFromData($data);
        }
        return $etapes;
    }

    private function createParcoursEtapeFromData(array $data): ParcoursEtape
    {
        return new ParcoursEtape(
            $data['id_etape'],
            $data['id_parcours'],
            $data['titre'],
            $data['description'],
            $data['contenu'],
            $data['type_contenu'] ?? 'texte',
            (int)$data['ordre'],
            (bool)$data['est_terminee'],
            $data['date_creation'],
            $data['date_modification'] ?? null
        );
    }
}