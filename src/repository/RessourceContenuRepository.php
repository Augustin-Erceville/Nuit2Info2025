<?php
namespace repository;

require_once __DIR__ . '/../Bdd/config.php';
require_once __DIR__ . '/../modele/RessourceContenu.php';

use PDO;
use PDOException;
use RessourceContenu;

class RessourceContenuRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(RessourceContenu $ressource): ?RessourceContenu
    {
        try {
            $query = "INSERT INTO ressources_contenu (
                        titre, description, contenu, type_contenu, 
                        id_createur, est_public, categorie, mots_cles
                     ) VALUES (
                        :titre, :description, :contenu, :type_contenu, 
                        :id_createur, :est_public, :categorie, :mots_cles
                     )";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'titre' => $ressource->getTitre(),
                'description' => $ressource->getDescription(),
                'contenu' => $ressource->getContenu(),
                'type_contenu' => $ressource->getTypeContenu(),
                'id_createur' => $ressource->getIdCreateur(),
                'est_public' => $ressource->estPublic() ? 1 : 0,
                'categorie' => $ressource->getCategorie(),
                'mots_cles' => $ressource->getMotsCles()
            ]);

            $ressource->setIdRessource($this->bdd->lastInsertId());
            return $ressource;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création de la ressource : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id, bool $inclurePrive = false): ?RessourceContenu
    {
        try {
            $query = "SELECT * FROM ressources_contenu WHERE id_ressource = :id";
            if (!$inclurePrive) {
                $query .= " AND (est_public = 1 OR id_createur = :user_id)";
            }

            $stmt = $this->bdd->prepare($query);
            $params = ['id' => $id];

            if (!$inclurePrive && isset($_SESSION['user_id'])) {
                $params['user_id'] = $_SESSION['user_id'];
            }

            $stmt->execute($params);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return $this->createRessourceFromData($data);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération de la ressource : ' . $e->getMessage());
            return null;
        }
    }

    public function update(RessourceContenu $ressource): bool
    {
        try {
            $query = "UPDATE ressources_contenu SET 
                     titre = :titre,
                     description = :description,
                     contenu = :contenu,
                     type_contenu = :type_contenu,
                     date_modification = NOW(),
                     est_public = :est_public,
                     categorie = :categorie,
                     mots_cles = :mots_cles,
                     note_moyenne = :note_moyenne
                     WHERE id_ressource = :id_ressource";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'titre' => $ressource->getTitre(),
                'description' => $ressource->getDescription(),
                'contenu' => $ressource->getContenu(),
                'type_contenu' => $ressource->getTypeContenu(),
                'est_public' => $ressource->estPublic() ? 1 : 0,
                'categorie' => $ressource->getCategorie(),
                'mots_cles' => $ressource->getMotsCles(),
                'note_moyenne' => $ressource->getNoteMoyenne(),
                'id_ressource' => $ressource->getIdRessource()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour de la ressource : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $this->bdd->beginTransaction();

            $this->supprimerCommentaires($id);

            $query = "DELETE FROM ressources_contenu WHERE id_ressource = :id";
            $stmt = $this->bdd->prepare($query);
            $result = $stmt->execute(['id' => $id]);

            $this->bdd->commit();
            return $result;
        } catch (\Exception $e) {
            $this->bdd->rollBack();
            error_log('Erreur lors de la suppression de la ressource : ' . $e->getMessage());
            return false;
        }
    }

    private function supprimerCommentaires(int $id_ressource): void
    {
        $query = "DELETE FROM commentaires WHERE id_ressource = :id_ressource";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute(['id_ressource' => $id_ressource]);
    }

    public function incrementerVues(int $id_ressource): bool
    {
        try {
            $query = "UPDATE ressources_contenu SET 
                     nombre_vues = nombre_vues + 1 
                     WHERE id_ressource = :id_ressource";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id_ressource' => $id_ressource]);
        } catch (PDOException $e) {
            error_log('Erreur lors de l\'incrémentation des vues : ' . $e->getMessage());
            return false;
        }
    }

    public function search(string $term, array $filtres = []): array
    {
        try {
            $query = "SELECT * FROM ressources_contenu 
                     WHERE (titre LIKE :term OR description LIKE :term OR contenu LIKE :term OR mots_cles LIKE :term)";

            $params = ['term' => "%$term%"];

            if (!empty($filtres['categorie'])) {
                $query .= " AND categorie = :categorie";
                $params['categorie'] = $filtres['categorie'];
            }

            if (!empty($filtres['type_contenu'])) {
                $query .= " AND type_contenu = :type_contenu";
                $params['type_contenu'] = $filtres['type_contenu'];
            }

            if (empty($filtres['inclure_prive'])) {
                $query .= " AND est_public = 1";
                if (isset($_SESSION['user_id'])) {
                    $query .= " OR id_createur = :user_id";
                    $params['user_id'] = $_SESSION['user_id'];
                }
            }

            $orderBy = $filtres['order_by'] ?? 'date_creation';
            $orderDir = isset($filtres['order_dir']) && strtoupper($filtres['order_dir']) === 'ASC' ? 'ASC' : 'DESC';
            $query .= " ORDER BY $orderBy $orderDir";

            if (isset($filtres['limit'])) {
                $query .= " LIMIT :limit";
                if (isset($filtres['offset'])) {
                    $query .= " OFFSET :offset";
                }
            }

            $stmt = $this->bdd->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            if (isset($filtres['limit'])) {
                $stmt->bindValue(':limit', (int)$filtres['limit'], PDO::PARAM_INT);
                if (isset($filtres['offset'])) {
                    $stmt->bindValue(':offset', (int)$filtres['offset'], PDO::PARAM_INT);
                }
            }

            $stmt->execute();

            return $this->fetchRessources($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche de ressources : ' . $e->getMessage());
            return [];
        }
    }

    public function findByCreateur(int $id_createur, bool $inclurePrive = true): array
    {
        try {
            $query = "SELECT * FROM ressources_contenu 
                     WHERE id_createur = :id_createur";

            if (!$inclurePrive) {
                $query .= " AND est_public = 1";
            }

            $query .= " ORDER BY date_creation DESC";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id_createur' => $id_createur]);

            return $this->fetchRessources($stmt);
        } catch (PDOException $e) {
            error_log('Erreur lors de la recherche des ressources par créateur : ' . $e->getMessage());
            return [];
        }
    }

    public function getCategories(): array
    {
        try {
            $query = "SELECT DISTINCT categorie, COUNT(*) as nombre 
                     FROM ressources_contenu 
                     WHERE est_public = 1 
                     GROUP BY categorie 
                     ORDER BY nombre DESC";

            $stmt = $this->bdd->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération des catégories : ' . $e->getMessage());
            return [];
        }
    }

    public function getMotsClesPopulaires(int $limit = 10): array
    {
        try {
            $query = "SELECT mot_cle, COUNT(*) as nombre 
                     FROM (
                         SELECT TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(mots_cles, ',', n), ',', -1)) as mot_cle
                         FROM ressources_contenu
                         CROSS JOIN (
                             SELECT a.N + b.N * 10 + 1 as n
                             FROM 
                                 (SELECT 0 as N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) a,
                                 (SELECT 0 as N UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) b
                             ORDER BY n
                         ) numbers
                         WHERE n <= 1 + LENGTH(mots_cles) - LENGTH(REPLACE(mots_cles, ',', ''))
                         AND est_public = 1
                     ) mots
                     WHERE mot_cle != ''
                     GROUP BY mot_cle
                     ORDER BY nombre DESC
                     LIMIT :limit";

            $stmt = $this->bdd->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération des mots-clés populaires : ' . $e->getMessage());
            return [];
        }
    }

    private function fetchRessources($stmt): array
    {
        $ressources = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ressources[] = $this->createRessourceFromData($data);
        }
        return $ressources;
    }

    private function createRessourceFromData(array $data): RessourceContenu
    {
        return new RessourceContenu(
            $data['id_ressource'],
            $data['titre'],
            $data['description'],
            $data['contenu'],
            $data['type_contenu'],
            $data['date_creation'],
            $data['date_modification'] ?? null,
            $data['id_createur'],
            (bool)$data['est_public'],
            $data['categorie'],
            $data['mots_cles'],
            (int)$data['nombre_vues'],
            (float)$data['note_moyenne']
        );
    }
}