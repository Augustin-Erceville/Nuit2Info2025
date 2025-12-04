<?php
namespace repository;

require_once __DIR__ . '/../bdd/config.php';
require_once __DIR__ . '/../modele/Commentaire.php';

use PDO;
use PDOException;
use Commentaire;

class CommentaireRepository
{
    private $bdd;

    public function __construct(\PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function create(Commentaire $commentaire): ?Commentaire
    {
        try {
            $query = "INSERT INTO commentaires (id_utilisateur, contenu, id_ressource, id_idee, id_defi) 
                     VALUES (:id_utilisateur, :contenu, :id_ressource, :id_idee, :id_defi)";

            $stmt = $this->bdd->prepare($query);
            $stmt->execute([
                'id_utilisateur' => $commentaire->getIdUtilisateur(),
                'contenu' => $commentaire->getContenu(),
                'id_ressource' => $commentaire->getIdRessource(),
                'id_idee' => $commentaire->getIdIdee(),
                'id_defi' => $commentaire->getIdDefi()
            ]);

            $commentaire->setIdCommentaire($this->bdd->lastInsertId());
            return $commentaire;
        } catch (PDOException $e) {

            error_log('Erreur lors de la création du commentaire : ' . $e->getMessage());
            return null;
        }
    }

    public function findById(int $id): ?Commentaire
    {
        try {
            $query = "SELECT * FROM commentaires WHERE id_commentaire = :id";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['id' => $id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return null;
            }

            return new Commentaire(
                $data['id_commentaire'],
                $data['id_utilisateur'],
                $data['contenu'],
                $data['date_creation'],
                $data['id_ressource'],
                $data['id_idee'],
                $data['id_defi']
            );
        } catch (PDOException $e) {
            error_log('Erreur lors de la récupération du commentaire : ' . $e->getMessage());
            return null;
        }
    }

    public function update(Commentaire $commentaire): bool
    {
        try {
            $query = "UPDATE commentaires SET 
                     contenu = :contenu,
                     id_ressource = :id_ressource,
                     id_idee = :id_idee,
                     id_defi = :id_defi
                     WHERE id_commentaire = :id_commentaire";

            $stmt = $this->bdd->prepare($query);
            return $stmt->execute([
                'contenu' => $commentaire->getContenu(),
                'id_ressource' => $commentaire->getIdRessource(),
                'id_idee' => $commentaire->getIdIdee(),
                'id_defi' => $commentaire->getIdDefi(),
                'id_commentaire' => $commentaire->getIdCommentaire()
            ]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la mise à jour du commentaire : ' . $e->getMessage());
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = "DELETE FROM commentaires WHERE id_commentaire = :id";
            $stmt = $this->bdd->prepare($query);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Erreur lors de la suppression du commentaire : ' . $e->getMessage());
            return false;
        }
    }

    public function findByRessource(int $id_ressource): array
    {
        return $this->findByField('id_ressource', $id_ressource);
    }

    public function findByIdee(int $id_idee): array
    {
        return $this->findByField('id_idee', $id_idee);
    }

    public function findByDefi(int $id_defi): array
    {
        return $this->findByField('id_defi', $id_defi);
    }

    private function findByField(string $field, $value): array
    {
        try {
            $query = "SELECT * FROM commentaires WHERE $field = :value ORDER BY date_creation DESC";
            $stmt = $this->bdd->prepare($query);
            $stmt->execute(['value' => $value]);

            $commentaires = [];
            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $commentaires[] = new Commentaire(
                    $data['id_commentaire'],
                    $data['id_utilisateur'],
                    $data['contenu'],
                    $data['date_creation'],
                    $data['id_ressource'],
                    $data['id_idee'],
                    $data['id_defi']
                );
            }
            return $commentaires;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche des commentaires par $field: " . $e->getMessage());
            return [];
        }
    }
}