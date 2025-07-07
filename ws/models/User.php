<?php
    require_once __DIR__ . '/../inc/db.php';

    class User {
        private $id;
        private $idDepartement;
        private $nom;
        private $prenom;
        private $password;

        public function __construct($id, $idDepartement, $nom, $prenom, $password) {
            $this->id = $id;
            $this->idDepartement = $idDepartement;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->password = $password;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getIdDepartement() { return $this->idDepartement; }
        public function getNom() { return $this->nom; }
        public function getPrenom() { return $this->prenom; }
        public function getPassword() { return $this->password; }

        // CRUD Operations
        public static function getAll() {
            $db = getDB();
            $stmt = $db->query("SELECT * FROM user");
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User(
                    $row['id'],
                    $row['id_departement'],
                    $row['nom'],
                    $row['prenom'],
                    $row['password']
                );
            }
            return $users;
        }

        public static function getById($id) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new User(
                $row['id'],
                $row['id_departement'],
                $row['nom'],
                $row['prenom'],
                $row['password']
            ) : null;
        }

        public static function create(User $user) {
            $db = getDB();
            $stmt = $db->prepare("INSERT INTO user (id_departement, nom, prenom, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $user->getIdDepartement(),
                $user->getNom(),
                $user->getPrenom(),
                password_hash($user->getPassword(), PASSWORD_DEFAULT)
            ]);
            return $db->lastInsertId();
        }

        public static function update(User $user) {
            $db = getDB();
            $stmt = $db->prepare("UPDATE user SET 
                                id_departement = ?, 
                                nom = ?, 
                                prenom = ?, 
                                password = ? 
                                WHERE id = ?");
            $stmt->execute([
                $user->getIdDepartement(),
                $user->getNom(),
                $user->getPrenom(),
                password_hash($user->getPassword(), PASSWORD_DEFAULT),
                $user->getId()
            ]);
        }

        public static function delete($id) {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM user WHERE id = ?");
            $stmt->execute([$id]);
        }

        public static function authenticate($email, $password) {
            $db = getDB();
            $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                return new User(
                    $user['id'],
                    $user['id_departement'],
                    $user['nom'],
                    $user['prenom'],
                    $user['password']
                );
            }
            return null;
        }
    }
?>