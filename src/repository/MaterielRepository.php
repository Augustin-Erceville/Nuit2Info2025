<?php
namespace repository;

require_once __DIR__ . '/../Bdd/config.php';
require_once __DIR__ . '/../modele/Materiel.php';

use PDO;
use PDOException;
use Materiel;

class MaterielRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Materiel $materiel): ?Materiel
    {
        try {
            $query = "INSERT INTO materiel (
                        nom, description, quantite_disponible, quantite_totale, 
                        etat, id_etablissement
                     ) VALUES (
                        :nom, :description, :quantite_disponible, :quantite_totale, 
                        :etat, :id_etablissement
                     )";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'nom' => $materiel->getNom(),
                'description' => $materiel->getDescription(),
                'quantite_disponible' => $materiel->getQuantiteDisponible(),
                'quantite_totale' => $materiel->getQuantiteTotale(),
                'etat' => $materiel->getEtat(),
                'id_etablissement' => $materiel->getIdEtablissement()
            ]);

            $materiel->setIdMateriel($this->bdd->lastInsertId());
            return $materiel;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création du matériel : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Materiel
    {
        try {
            $query = "SELECT * FROM materiel WHERE id_materiel = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return $this->createMaterielFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération du matériel : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Materiel $materiel): bool
    {
        try {
            $query = "UPDATE materiel SET 
                     nom = :nom,
                     description = :description,
                     quantite_disponible = :quantite_disponible,
                     quantite_totale = :quantite_totale,
                     etat = :etat,
                     id_etablissement = :id_etablissement
                     WHERE id_materiel = :id_materiel";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'nom' => $materiel->getNom(),
                'description' => $materiel->getDescription(),
                'quantite_disponible' => $materiel->getQuantiteDisponible(),
                'quantite_totale' => $materiel->getQuantiteTotale(),
                'etat' => $materiel->getEtat(),
                'id_etablissement' => $materiel->getIdEtablissement(),
                'id_materiel' => $materiel->getIdMateriel()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du matériel : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM materiel WHERE id_materiel = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression du matériel : ' . $e->getMessage());
            return false;
        }
    }

    public function findByEtablissement(int $id_etablissement): array
    {
        try {
            $query = "SELECT * FROM materiel WHERE id_etablissement = :id_etablissement ORDER BY nom";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_etablissement' => $id_etablissement]);

            return $this->fetchMateriels($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche du matériel par établissement : ' . $e->getMessage());
            return [];
        }
    }

    public function findDisponibles(int $id_etablissement = null): array
    {
        try {
            $query = "SELECT * FROM materiel WHERE quantite_disponible > 0";
            $params = [];

            if ($id_etablissement !== null) {
                $query .= " AND id_etablissement = :id_etablissement";
                $params['id_etablissement'] = $id_etablissement;
            }

            $query .= " ORDER BY nom";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute($params);

            return $this->fetchMateriels($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche du matériel disponible : ' . $e->getMessage());
            return [];
        }
    }

    public function search(string $term, ?int $id_etablissement = null): array
    {
        try {
            $query = "SELECT * FROM materiel 
                     WHERE (nom LIKE :term OR description LIKE :term)";

            $params = ['term' => "%$term%"];

            if ($id_etablissement !== null) {
                $query .= " AND id_etablissement = :id_etablissement";
                $params['id_etablissement'] = $id_etablissement;
            }

            $query .= " ORDER BY nom";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute($params);

            return $this->fetchMateriels($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche de matériel : ' . $e->getMessage());
            return [];
        }
    }

    public function emprunterMateriel(int $id_materiel, int $quantite = 1): bool
    {
        try {
            $this->bdd->beginTransaction();

            $materiel = $this->findById($id_materiel);
            if (!$materiel || !$materiel->emprunter($quantite)) {
                $this->bdd->rollBack();
                return false;
            }

            $query = "UPDATE materiel SET 
                     quantite_disponible = quantite_disponible - :quantite
                     WHERE id_materiel = :id_materiel";

            $stmt = $this->bdd->prepare($query);
            $result = $stmt->execute([
                'quantite' => $quantite,
                'id_materiel' => $id_materiel
            ]);

            if ($result) {
                $this->bdd->commit();
                return true;
            } else {
                $this->bdd->rollBack();
                return false;
            }

        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors de l\'emprunt de matériel : ' . $e->getMessage());
            return false;
        }
    }

    public function retournerMateriel(int $id_materiel, int $quantite = 1): bool
    {
        try {
            $this->bdd->beginTransaction();

            $materiel = $this->findById($id_materiel);
            if (!$materiel || !$materiel->retourner($quantite)) {
                $this->bdd->rollBack();
                return false;
            }

            $query = "UPDATE materiel SET 
                     quantite_disponible = LEAST(quantite_disponible + :quantite, quantite_totale)
                     WHERE id_materiel = :id_materiel";

            $stmt = $this->bdd->prepare($query);
            $result = $stmt->execute([
                'quantite' => $quantite,
                'id_materiel' => $id_materiel
            ]);

            if ($result) {
                $this->bdd->commit();
                return true;
            } else {
                $this->bdd->rollBack();
                return false;
            }

        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors du retour du matériel : ' . $e->getMessage());
            return false;
        }
    }

    private function fetchMateriels($stmt): array
    {
        $materiels = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $materiels[] = $this->createMaterielFromData($data);
        }
        return $materiels;
    }

    private function createMaterielFromData(array $data): Materiel
    {
        return new Materiel(
            $data['id_materiel'],
            $data['nom'],
            $data['description'],
            (int)$data['quantite_disponible'],
            (int)$data['quantite_totale'],
            $data['etat'] ?? 'bon',
            $data['date_ajout'],
            $data['id_etablissement']
        );
    }
}