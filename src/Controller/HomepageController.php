<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/premium', name: 'app_premium', methods: ['POST', 'GET'])]
    public function put_premium(): Response
    {
        $user = $this->getUser();

        // Vérifiez que l'utilisateur est connecté
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour devenir premium.');
        }

        // Récupérer les rôles existants
        $roles = $user->getRoles();

        // Ajouter le rôle 'ROLE_PREMIUM' si non présent
        if (!in_array('ROLE_PREMIUM', $roles, true)) {
            $roles[] = 'ROLE_PREMIUM';
            $this->addFlash('success', 'Vous êtes maintenant premium, veuillez vous reconnecter !');
            $user->setRoles($roles);

            // Sauvegarder dans la base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_login');
    }





}
