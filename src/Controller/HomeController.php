<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index():Response
    {
        /** @var \App\Entity\User $user */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if ($user)
        {
            $connectedUser = $user->getFirstname();
        }
        else
        {
            $connectedUser = '- Connectez-vous';
        }
        return $this-> render('index.html.twig', ['connected_user' => $user->getFirstname()]);
    }
}