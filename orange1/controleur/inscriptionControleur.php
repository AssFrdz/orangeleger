<?php
include ("modele/inscriptionModele.php");



$message = "";

    if (isset($_POST['Inscription']))
    {
        $message = "on est rentré";
        $inscriptionControleur = new inscriptionControleur();
        
        $tab =array("nom"=>$_POST["nom"],"prenom"=>$_POST["prenom"],"adresse"=>$_POST["adresse"],"telephone"=>$_POST["telephone"],"email"=>$_POST["email"],"mdp"=>$_POST["mdp"],"userType"=>$_POST["userType"]);

        $uneInscription = $inscriptionControleur->inscription($tab);

        if ($uneInscription === true)
        {
            $message = "le compte a bien été créer";
        }else
        {
            $message = $uneInscription;
        }
    }

    require_once("vue/headerVue.php");

    echo $message;







    



class inscriptionControleur
{
    private $inscriptionModele;

    public function __construct()
    {
        $this->inscriptionModele = new inscriptionModele();
    }


    public function inscription($tab)
    {
        if (filter_var($tab['email'], FILTER_VALIDATE_EMAIL))
        {
            $existingUser = $this->inscriptionModele->existingUser($tab['email']);
            
            if($existingUser == null)
            {
                if(ctype_alpha($tab["prenom"]) && ctype_alpha($tab["nom"])){
                    $tab["nom"] = trim($tab["nom"]); // enleve les espaces
                    $tab["nom"] = ucfirst($tab["nom"]); //met en maj la première lettre
                    $tab["prenom"] = trim($tab["prenom"]);
                    $tab["prenom"] = ucfirst($tab["prenom"]);
                    $this->inscriptionModele->insertUser($tab);
                    return true;
                }else{
                    return "Le nom et prénom ne doivent contenir que des lettres";
                }
                
            } 
            else
            {
                return "l'email est déja utilisé";
            }

        // mettre un else if, et enchainer avec les différentes conditions : 
                //1. alphabétique 2. sans espace 3. commence par une maj
        }else
        {
            return "l'email n'est pas valide";
        }
    }
}

?>