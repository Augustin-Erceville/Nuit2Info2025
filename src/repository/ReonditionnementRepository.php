<?php
namespace repository;

require_once __DIR__ . '/../Bdd/config.php';
require_once __DIR__ . '/../modele/Reonditionnement.php';

use PDO;
use PDOException;
use Reonditionnement;

class ReonditionnementRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Reonditionnement $reonditionnement): ?Reonditionnement
    {
        try {
            $query = "INSERT INTO reonditionnement (
                        id_materiel, id_utilisateur, date_reonditionnement, 
                        etat_initial, etat_final, description, cout, 
                        duree_travaux, statut
                     ) VALUES (
                        :id_materiel, :id_utilisateur, :date_reonditionnement, 
                        :etat_initial, :etat_final, :description, :cout, 
                        :duree_travaux, :statut
                     )";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_materiel' => $reonditionnement->getIdMateriel(),
                'id_utilisateur' => $reonditionnement->getIdUtilisateur(),
                'date_reonditionnement' => $reonditionnement->getDateReonditionnement(),
                'etat_initial' => $reonditionnement->getEtatInitial(),
                'etat_final' => $reonditionnement->getEtatFinal(),
                'description' => $reonditionnement->getDescription(),
                'cout' => $reonditionnement->getCout(),
                'duree_travaux' => $reonditionnement->getDureeTravaux(),
                'statut' => $reonditionnement->getStatut()
            ]);

            $reonditionnement->setIdReonditionnement($this->bdd->lastInsertId());
            return $reonditionnement;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création du réonditionnement : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Reonditionnement
    {
        try {
            $query = "SELECT * FROM reonditionnement WHERE id_reonditionnement = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return $this->createReonditionnementFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération du réonditionnement : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Reonditionnement $reonditionnement): bool
    {
        try {
            $query = "UPDATE reonditionnement SET 
                     id_materiel = :id_materiel,
                     id_utilisateur = :id_utilisateur,
                     date_reonditionnement = :date_reonditionnement,
                     etat_initial = :etat_initial,
                     etat_final = :etat_final,
                     description = :description,
                     cout = :cout,
                     duree_travaux = :duree_travaux,
                     statut = :statut
                     WHERE id_reonditionnement = :id_reonditionnement";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'id_materiel' => $reonditionnement->getIdMateriel(),
                'id_utilisateur' => $reonditionnement->getIdUtilisateur(),
                'date_reonditionnement' => $reonditionnement->getDateReonditionnement(),
                'etat_initial' => $reonditionnement->getEtatInitial(),
                'etat_final' => $reonditionnement->getEtatFinal(),
                'description' => $reonditionnement->getDescription(),
                'cout' => $reonditionnement->getCout(),
                'duree_travaux' => $reonditionnement->getDureeTravaux(),
                'statut' => $reonditionnement->getStatut(),
                'id_reonditionnement' => $reonditionnement->getIdReonditionnement()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du réonditionnement : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM reonditionnement WHERE id_reonditionnement = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression du réonditionnement : ' . $e->getMessage());
            return false;
        }
    }

    public function findByMateriel(int $id_materiel): array
    {
        try {
            $query = "SELECT * FROM reonditionnement 
                     WHERE id_materiel = :id_materiel 
                     ORDER BY date_reonditionnement DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_materiel' => $id_materiel]);

            return $this->fetchReonditionnements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des réonditionnements par matériel : ' . $e->getMessage());
            return [];
        }
    }

    public function findByUtilisateur(int $id_utilisateur): array
    {
        try {
            $query = "SELECT * FROM reonditionnement 
                     WHERE id_utilisateur = :id_utilisateur 
                     ORDER BY date_reonditionnement DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_utilisateur' => $id_utilisateur]);

            return $this->fetchReonditionnements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des réonditionnements par utilisateur : ' . $e->getMessage());
            return [];
        }
    }

    public function findByStatut(string $statut): array
    {
        try {
            $query = "SELECT * FROM reonditionnement 
                     WHERE statut = :statut 
                     ORDER BY date_reonditionnement DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['statut' => $statut]);

            return $this->fetchReonditionnements($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des réonditionnements par statut : ' . $e->getMessage());
            return [];
        }
    }

    public function getStatistiques(): array
    {
        try {
            $query = "SELECT 
                         COUNT(*) as total,
                         SUM(cout) as cout_total,
                         SUM(duree_travaux) as duree_totale,
                         statut,
                         COUNT(*) as nombre_par_statut
                      FROM reonditionnement 
                      GROUP BY statut";

            $stmt = $this->bdd->query($query);
            $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stats = [
                'total' => 0,
                'cout_total' => 0,
                'duree_totale' => 0,
                'par_statut' => []
            ];

            foreach ($resultats as $row) {
                $stats['total'] += $row['total'];
                $stats['cout_total'] += (float)$row['cout_total'];
                $stats['duree_totale'] += (int)$row['duree_totale'];
                $stats['par_statut'][$row['statut']] = $row['nombre_par_statut'];
            }

            return $stats;
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération des statistiques de réonditionnement : ' . $e->getMessage());
            return [
                'total' => 0,
                'cout_total' => 0,
                'duree_totale' => 0,
                'par_statut' => []
            ];
        }
    }

    private function fetchReonditionnements($stmt): array
    {
        $reonditionnements = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reonditionnements[] = $this->createReonditionnementFromData($data);
        }
        return $reonditionnements;
    }

    private function createReonditionnementFromData(array $data): Reonditionnement
    {
        return new Reonditionnement(
            $data['id_reonditionnement'],
            $data['id_materiel'],
            $data['id_utilisateur'],
            $data['date_reonditionnement'],
            $data['etat_initial'],
            $data['etat_final'],
            $data['description'],
            $data['cout'] !== null ? (float)$data['cout'] : null,
            $data['duree_travaux'] !== null ? (int)$data['duree_travaux'] : null,
            $data['statut']
        );
    }
}