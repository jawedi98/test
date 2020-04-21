<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    public function redirectAction()
    {  $authChecker=$this->container->get('security.authorization_checker');
    if($authChecker->isGranted('ROLE_ADMIN')){
        return $this->render('@App/Security/admin_home.html.twig');
    }
    else if ($authChecker->isGranted('ROLE_CLIENT')){
        return $this->render('@App/Security/user_home.html.twig');
    }
    else return $this->render('@FOSUser/Security/login.html.twig');

    }
}
