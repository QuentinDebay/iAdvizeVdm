<?php

namespace IAdvize\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VdmRestController extends Controller
{
    public function getPostsAction (Request $request){
        //Récupération des paramètres en GET
        $param = new \stdClass;
        $param->from = $request->query->get('from');
        $param->to = $request->query->get('to');
        $param->author = $request->query->get('author');

        //Convertit la date en Datetime, ou null si elle est incorrecte
        $param->from = $this->convertirDate($param->from);
        $param->to = $this->convertirDate($param->to);

        //Récupère les VDM suivant les critères
        $em = $this->getDoctrine()->getManager();
        $vdms = $em->getRepository('IAdvizeVdmBundle:Vdm')->getVdmFromParam($param);
        //Nombre de Vdm
        $count = count($vdms);
        //Formate les VDM
        $retour = $this->formaterVdm($vdms);
        
        return array('posts' => $retour,
            'count' => $count);
  }
  
  /**
   * Formate les VDM pour le rendu
   * 
   * @param array $vdms
   * @return array
   */
    private function formaterVdm($vdms) {
        $aRetourVdm = array();
      
        foreach($vdms as $vdm) {
            $aRetourVdm[]['id'] = $vdm->getVdmId();
            $aRetourVdm[count($aRetourVdm) - 1]['content'] = $vdm->getContenu();
            $aRetourVdm[count($aRetourVdm) - 1]['date'] = $vdm->getDatep()->format("Y-m-d H:i:s");
            $aRetourVdm[count($aRetourVdm) - 1]['author'] = $vdm->getAuteur();
        }
        return $aRetourVdm;
    }
  
    private function convertirDate($date) {
        if(!is_null($date)) {
            $date = \DateTime::createFromFormat('Y-m-d', $date);
            if(!$date) {
                $date = null;
            }
            else {
                $date = $date->format('Y/m/d');
            }
        }
    }
}