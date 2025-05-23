<?php

class inscriptionModele extends BDD
    {
        private $inscription;
        private $hash;

        public function __construct()
        {
            parent :: __construct();
            $this->hash = parent :: getHashKey();
        }


        public function insertUser($tab)
        {
            if($tab["userType"] == 'client'){
                $requete = "CALL insererClient(:nom, :prenom, :adresse, :telephone, :email, :mdp, 'clientsimple', '1');";
            } else {
                $requete = "CALL insererTechnicien(:nom, :prenom, :adresse, :telephone, :email, :mdp, 'informatique', 'technicien');";
            }

            var_dump($tab);

            $select = $this->bdd->prepare($requete);
            $select->bindValue(":nom", $tab['nom']);
            $select->bindValue(':prenom', $tab['prenom']);
            $select->bindValue(':adresse', $tab['adresse']);
            $select->bindValue(':telephone', $tab['telephone']);
            $select->bindValue(':email', $tab['email']);
            $select->bindValue(':mdp', $tab['mdp']);

            try {
                $select->execute();
                echo "Insertion réussie !";
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }


        



        public function existingUser($email)
        {
            $requete = "SELECT * from users AS u WHERE (u.email = :email);";
            $select = $this->bdd->prepare($requete);
            $select->bindParam(":email", $email);

            $select->execute();
            return $select->fetch();
        }

        



        //getters and setters

        public function getHash()
        {
            return $this->hash;
        }
    }

?>