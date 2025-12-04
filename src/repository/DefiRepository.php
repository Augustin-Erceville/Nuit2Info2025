<?php
namespace repository;

require_once __DIR__ . '/../bdd/Bdd.php';
require_once __DIR__ . '/../modele/Defi.php';

use PDO;
use PDOException;
use Defi;

class DefiRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Defi $defi): ?Defi
    {
        try {
            $query = "INSERT INTO defis (titre, description, date_limite, id_createur, statut, recompense, niveau_difficulte) 
                     VALUES (:titre, :description, :date_limite, :id_createur, :statut, :recompense, :niveau_difficulte)";
            
            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'titre' => $defi->getTitre(),
                'description' => $defi->getDescription(),
                'date_limite' => $defi->getDateLimite(),
                'id_createur' => $defi->getIdCreateur(),
                'statut' => $defi->getStatut(),
                'recompense' => $defi->getRecompense(),
                'niveau_difficulte' => $defi->getNiveauDifficulte()
            ]);

            $defi->setIdDefi($this->bdd->lastInsertId());
            return $defi;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création du défi : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Defi
    {
        try {
            $query = "SELECT * FROM defis WHERE id_defi = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);
            
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data) {
                return null;
            }

            return new Defi(
                $data['id_defi'],
                $data['titre'],
                $data['description'],
                $data['date_creation'],
                $data['date_limite'],
                $data['id_createur'],
                $data['statut'],
                $data['recompense'],
                $data['niveau_difficulte']
            );
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération du défi : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Defi $defi): bool
    {
        try {
            $query = "UPDATE defis SET 
                     titre = :titre,
                     description = :description,
                     date_limite = :date_limite,
                     statut = :statut,
                     recompense = :recompense,
                     niveau_difficulte = :niveau_difficulte
                     WHERE id_defi = :id_defi";
            
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'titre' => $defi->getTitre(),
                'description' => $defi->getDescription(),
                'date_limite' => $defi->getDateLimite(),
                'statut' => $defi->getStatut(),
                'recompense' => $defi->getRecompense(),
                'niveau_difficulte' => $defi->getNiveauDifficulte(),
                'id_defi' => $defi->getIdDefi()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du défi : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM defis WHERE id_defi = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression du défi : ' . $e->getMessage());
            return false;
        }
    }

    public function findAllActive(): array
    {
        return $this->findByStatus('actif');
    }

    public function findByCreateur(int $id_createur): array
    {
        try {
            $query = "SELECT * FROM defis WHERE id_createur = :id_createur ORDER BY date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_createur' => $id_createur]);
            
            return $this->fetchDefis($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des défis par créateur : ' . $e->getMessage());
            return [];
        }
    }

    public function findByStatus(string $statut): array
    {
        try {
            $query = "SELECT * FROM defis WHERE statut = :statut ORDER BY date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['statut' => $statut]);
            
            return $this->fetchDefis($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des défis par statut : ' . $e->getMessage());
            return [];
        }
    }

    private function fetchDefis($stmt): array
    {
        $defis = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $defis[] = new Defi(
                $data['id_defi'],
                $data['titre'],
                $data['description'],
                $data['date_creation'],
                $data['date_limite'],
                $data['id_createur'],
                $data['statut'],
                $data['recompense'],
                $data['niveau_difficulte']
            );
        }
        return $defis;
    }
}
