<?php

namespace EtoxMicrome\FrontendBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;


class StateController extends FOSRestController
{
    public function getStateAction()
    {
        $data = array("name"=>"BeCalm", "method"=>"getState", "becalm_key"=>"616c202a947a0b9fed34");
        $view = $this->view($data, 200)
            ->setFormat('jsonp')
        ;
        return $this->handleView($view);
    }

}