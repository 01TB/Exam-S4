<?php
class Interet {
    public static function getInteretInterval($moisDebut, $moisFin, $anneeDebut, $anneeFin) {
        try {
            $db = getDB();
        
            // Construction dynamique de la requête
            $sql = "SELECT SUM(ipp.montant) AS interet, ipp.mois, ipp.annee 
                    FROM interet_pret_periode ipp
                    JOIN pret p ON ipp.id_pret = p.id
                    WHERE p.statut = 'valide'";
            
            $params = [];
            
            // Ajout des conditions seulement si les paramètres ne sont pas null
            if ($moisDebut !== null && $moisFin !== null) {
                $sql .= " AND ipp.mois BETWEEN :moisDebut AND :moisFin";
                $params[':moisDebut'] = $moisDebut;
                $params[':moisFin'] = $moisFin;
            }
            
            if ($anneeDebut !== null && $anneeFin !== null) {
                $sql .= " AND ipp.annee BETWEEN :anneeDebut AND :anneeFin";
                $params[':anneeDebut'] = $anneeDebut;
                $params[':anneeFin'] = $anneeFin;
            }
            
            $sql .= " GROUP BY ipp.mois, ipp.annee ORDER BY ipp.annee, ipp.mois";
            
            $stmt = $db->prepare($sql);
            
            // Liaison des paramètres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}