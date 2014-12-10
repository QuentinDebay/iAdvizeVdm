<?php

namespace IAdvize\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DomCrawler\Crawler;
use IAdvize\VdmBundle\Entity\Vdm;

class GetVdmController extends Controller
{
    private $compteurVdm = 0;
    private $compteurVdmAjoutee = 0;
    
    function __construct() {

    }
    
    /**
     * 
     * @return type
     */
    public function getVdmAction()
    {
        $this->analyserVdm();
        return $this->render('IAdvizeVdmBundle:Default:index.html.twig', array('nombreVdm' => $this->compteurVdmAjoutee));
    }
    
    /**
     * Fonction pour parser le DOM et analyser les noeuds
     */
    private function analyserVdm() {
        //Compteur pour les pages à parser
        $compteurPage = 0;
        
        while($this->compteurVdm < 200) {
            //Url du DOM à récupérer
            $url = "http://www.viedemerde.fr/?page=".$compteurPage;
            
            $html = file_get_contents($url);
            $domVdm = new Crawler($html);
            //On parcours chaque node "Article"
            $compteurVdm = $domVdm->filter('div.article')->each(function ($node) {
                //Tant que 200 VDM n'ont pas été parsé, on continue
                if($this->compteurVdm < 200) {
                    //Analyse le contenu du DOM
                    $this->analyseNode($node);
                    $this->compteurVdm++;
                }
            });
            //Quand il n'y a plus de VDM sur la page en cours
            //On ajoute 1 au compteur
            $compteurPage++;
        }
    }
    
    private function analyseNode($node) {
        //Récupère les informations du DOM
        $vdmId = $this->getVdmId($node);
        $vdmContent = $this->getVdmContent($node);
        $vdmAuteur = $this->getVdmAuteur($node);
        $vdmDate = $this->getVdmDate($node);

        //Création de la nouvelle VDM
        $newVdm = new Vdm();
        $newVdm->setVdmId($vdmId);
        $newVdm->setContenu($vdmContent);
        $newVdm->setAuteur($vdmAuteur);
        $newVdm->setDateP($vdmDate);

        //On vérifie que la VDM n'est pas déjà en bdd
        $vdmDoublon = $this->getDoctrine()
            ->getRepository('IAdvizeVdmBundle:Vdm')
            ->findOneBy(array('vdmId' => $vdmId));

        if(is_null($vdmDoublon)) {
            //enregistrement de la VDM
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('IAdvizeVdmBundle:Vdm')->saveVdm($newVdm);
            $this->compteurVdmAjoutee++;
        }
    }
    
    /**
     * Fonction qui récupère l'id du node
     * 
     * @param object $node
     * @return string
     */
    private function getVdmId($node) {
        return $node->attr('id');
    }
    
    /**
     * Fonction qui récupère le contenu du node
     * 
     * @param object $node
     * @return string
     */
    private function getVdmContent($node) {
        return $node->filter('p')->first()->text();
    }
    
    /**
     * Fonction qui récupère la date du node
     * 
     * @param object $node
     * @return dateTime
     */
    private function getVdmDate($node) {
        //On récupère la contenu du <p> et on parse son contenu
        //Ps : C'est pas très propre
        $aDate = explode("-", $node->filter('div.right_part p')->eq(1)->text());
        $date = preg_replace("#[^0-9:/]# ","",$aDate[0]);
        //Convertit le string en DateTime
        $date = \DateTime::createFromFormat('d/m/Y H:i', $date);
        //Si la convertion c'est mal passé, on set la date a null
        if(!$date) {
            $date = null;
        }
        return $date;
    }
    
    /**
     * Fonction qui récupère la date du node
     * 
     * @param object $node
     * @return string
     */
    private function getVdmAuteur($node) {
        //On récupère la contenu du <p> et on parse son contenu
        //Ps : C'est pas très propre x2
        $aAuteur = explode("-", $node->filter('div.right_part p')->eq(1)->text());
        $auteur = explode(" ", substr($aAuteur[2], 5));
        return $auteur[0];
    }
}
