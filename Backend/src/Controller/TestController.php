<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test-session', name: 'test_session')]
    public function testSession(SessionInterface $session): Response
    {
        $session->set('test_key', 'Ceci est un test');
        return new Response('Session test sauvegardée !');
    }

    #[Route('/get-session', name: 'get_session')]
    public function getSession(SessionInterface $session): Response
    {
        $testValue = $session->get('test_key', 'Aucune session trouvée');
        return new Response('Valeur en session : ' . $testValue);
    }
}

