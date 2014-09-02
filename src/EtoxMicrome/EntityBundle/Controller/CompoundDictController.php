<?php

namespace EtoxMicrome\EntityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

class CompoundDictController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function calculateTanimotoAction()
    {
        $request = $this->get('request');
        $compoundName1=$request->query->get('compoundName1');
        $compoundName2=$request->query->get('compoundName2');
        $testString="Vamos bien!!!";
        $smile1="";
        $inchi1="";
        $smile2="";
        $inchi2="";

        //Having the 2 compoundNames we need to get the entities in order to use their inChi or Smiles to calculate the Tanimoto Coefficient
        $em = $this->getDoctrine()->getManager();
        //We start with the first compound
        $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($compoundName1);
        if(count($entity)==0){
            $tanimotoString="Sorry. We have no data for $compoundName1 compound.";
            $jsonString = json_encode($tanimotoString);
            $response = new Response($jsonString);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            $inchi1=$entity->getInChi();
            $smile1=$entity->getSmile();
            if ($inchi1=="" and $smile1==""){
                $tanimotoString="Sorry. We have InChi/Smile for $compoundName1 compound.";
                $jsonString = json_encode($tanimotoString);
                $response = new Response($jsonString);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }

        //We repeat the process for the second compound
        $entity=$em->getRepository('EtoxMicromeEntityBundle:CompoundDict')->getEntityFromName($compoundName2);
        if(count($entity)==0){
            $tanimotoString="Sorry. We have no data for $compoundName2 compound.";
            $jsonString = json_encode($tanimotoString);
            $response = new Response($jsonString);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            $inchi2=$entity->getInChi();
            $smile2=$entity->getSmile();
            if ($inchi2=="" and $smile2==""){
                $tanimotoString="Sorry. We haven't got neither InChi nor Smile for $compoundName2 compound.";
                $jsonString = json_encode($tanimotoString);
                $response = new Response($jsonString);
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        }
        //Here we have data for calculate the tanimoto coeff with a python script...
        $tanimotoScriptPath=$this->get('kernel')->getRootDir(). "/../web/scripts/returnTanimotoDistance.py '$inchi1' '$inchi2' '$smile1' '$smile2' ";
        #$command="PYTHONPATH='".getenv('PYTHONPATH')."' RDBASE='".getenv('RDBASE')."' python ".$tanimotoScriptPath;
        //To execute pythonscript from here we need to pass the environment variables PythonPath and rdbase, set as global parameters from the dependency container in config.yml
        $rdbase= $this->container->getParameter('etoxMicrome.rdbase');
        $pythonpath= $this->container->getParameter('etoxMicrome.pythonpath');
        $dyld_library_path=$this->container->getParameter('etoxMicrome.dyld_library_path');

        $command="PYTHONPATH='".$pythonpath."' RDBASE='".$rdbase."' DYLD_LIBRARY_PATH='".$dyld_library_path."'  python ".$tanimotoScriptPath;
        $process = new Process($command);
        $process->run();
        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
        $output=$process->getOutput();
        #echo $output;

        $jsonString = json_encode($output);
        $response = new Response($jsonString);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
