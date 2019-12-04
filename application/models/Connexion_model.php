<?php
class Connexion_model extends CI_Model
{

    protected $pseudo;
    protected $email;
    protected $cle;
    protected $mdp;
    protected $etat;


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function recuptoutes()
    {
        $query = $this->db->get('user');
        return $query->result_array();
    }
    public function connexion(){

        $pseudo=$this->input->post('pseudo');
        $mdp=$this->input->post('mdp');

        if (empty($pseudo)||empty($mdp)){
            $_SESSION['erreur']="Veuillez remplir tous les champs.";
        } else {
            $query = $this->db->get_where('user', array('user_pseudo' => $pseudo));
            $verif_1 = $query->result_array();

            if (empty($verif_1)) {
                $_SESSION['erreur'] = "Ce pseudo n'est pas valide";
            } else {
                $hash = $verif_1[0]['user_mdp'];
                if (password_verify($mdp, $hash)) {
                    $_SESSION['pseudo'] = $pseudo;
                    $_SESSION['mail'] =$verif_1[0]['user_email'];
                } else {
                    $_SESSION['erreur'] = "Le mot de passe est invalide.";
                }

            }
        }
    }


}

