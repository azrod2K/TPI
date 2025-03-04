<!-- 
Auteur: David Machado
Date: 18.05.2022
Projet: Matos    
-!>
<?php

use LDAP\Result;

class utilisateurs
{
    private $idUtilisateur;
    private $nom;
    private $prenom;
    private $noTel;
    private $pseudo;
    private $motDePasse;
    private $email;
    private $statut;
    private $isDeleted;


    /**
     * Get the value of idUtilisateur
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set the value of idUtilisateur
     *
     * @return  self
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of noTel
     */
    public function getNoTel()
    {
        return $this->noTel;
    }

    /**
     * Set the value of noTel
     *
     * @return  self
     */
    public function setNoTel($noTel)
    {
        $this->noTel = $noTel;

        return $this;
    }

    /**
     * Get the value of pseudo
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get the value of motDePasse
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set the value of motDePasse
     *
     * @return  self
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of statut
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }
    /**
     * Get the value of isDeleted
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set the value of isDeleted
     *
     * @return  self
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
    //crypter le mot de passe
    public static function Crypter($mdpClair)
    {
        return md5($mdpClair);
    }

    // verrifier les informations de connection
    public static function CheckConnected(utilisateurs $user)
    {
        $email = $user->getEMail();
        $req = MonPdo::getInstance()->prepare("SELECT * FROM utilisateurs WHERE email = :email;");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'utilisateurs'); // mettre le nom de la classe
        $req->bindParam(":email", $email);
        $req->execute();
        $result = $req->fetch();
        return $result;
    }

    //ajouter un utilisateur
    public static function AddUser(utilisateurs $user)
    {
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $noTel = $user->getNoTel();
        $pseudo = $user->getPseudo();
        $motDePasse = utilisateurs::Crypter($user->getMotDePasse());
        $email = $user->getEmail();
        $statut = 1;
        $isDeleted = 0;
        $req = MonPdo::getInstance()->prepare("INSERT INTO utilisateurs(nom,prenom,noTel,pseudo,motDePasse,email,statut,isDeleted) VALUES (:Nom,:Prenom,:NoTel,:Pseudo,:MotDePasse,:Email,:Statut,:IsDeleted)");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'utilisateurs');
        $req->bindParam(':Nom', $nom);
        $req->bindParam(':Prenom', $prenom);
        $req->bindParam(':NoTel', $noTel);
        $req->bindParam(':Pseudo', $pseudo);
        $req->bindParam(':MotDePasse', $motDePasse);
        $req->bindParam(':Email', $email);
        $req->bindParam(':Statut', $statut);
        $req->bindParam(':IsDeleted', $isDeleted);
        $req->execute();
    }
    public static function Update(utilisateurs $user)
    {
        $pseudo = $user->getPseudo();
        $noTel = $user->getNoTel();
        $motDePasse = utilisateurs::Crypter($user->getMotDePasse());
        $idUtilisateur = $user->getIdUtilisateur();
        $sql = MonPdo::getInstance()->prepare("UPDATE utilisateurs SET pseudo = :pseudo, noTel = :notel, motDePasse = :mdp where idUtilisateur = :id");
        $sql->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'utilisateurs');
        $sql->bindParam(":pseudo", $pseudo);
        $sql->bindParam(":noTel", $noTel);
        $sql->bindParam(":mdp", $motDePasse);
        $sql->bindParam(":id", $idUtilisateur);
        $sql->execute();
    }

    public static function IsEmailExisting($email, $pseudo)
    {
        $req = MonPdo::getInstance()->prepare("SELECT idUtilisateur, email,pseudo FROM utilisateurs");
        $req->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'utilisateurs');
        $req->execute();
        $result = $req->fetchAll();

        foreach ($result as $r) {
            if ($r->getEmail() == $email || $r->getPseudo() == $pseudo) {
                return true;
            }
        }
        return false;
    }
    //Affichage de tous les utilisateurs
    public static function getAllUser()
    {
        $res = MonPdo::getInstance()->prepare("SELECT * FROM utilisateurs WHERE isDeleted = 0 ORDER BY statut DESC");
        $res->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'utilisateurs');
        $res->execute();

        $result = $res->fetchAll();
        echo "<div class='table-responsive'>";
        echo "<table class='table table-info table-responsive' >";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>E-mail</th>";
        echo "<th scope='col'>Pseudo</th>";
        echo "<th scope='col'>Numéro de téléphone</th>";
        echo "<th scope='col'>Statut</th>";
        echo "<th></th>";
        echo "</tr>";
        foreach ($result as $value) {
            echo "<tr>";
            echo "<td>" . $value->getEmail() . "</td>";
            echo "<td>" . $value->getPseudo() . "</td>";
            echo "<td>" . $value->getNoTel() . "</td>";
            if ($value->getStatut() == 1) {
                echo "<td>🙍‍♂️ enseigants</td>";
            } else if ($value->getStatut() == 2) {
                echo "<td>⭐ admin</td>";
            }
            echo "<td style='text-align: center;'><a href='index.php?uc=admin&action=delete&idUtilisateur=" . $value->getIdUtilisateur() . "' style='border: 1px solid black;font-size: 100%;' class='btn btn-outline-danger''>Supprimer</a></td>";
            echo "</tr>";
        }
        echo "</thead>";
        echo "</table>";
        echo "</div>";
    }
}
