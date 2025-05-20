<?php

namespace App\Controller;

use App\Entity\Origin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ListController extends AbstractController
{
    /*
     * List of origin texts
     */
    public function list(EntityManagerInterface $entityManager): Response
    {
        $origins = $entityManager->getRepository(Origin::class)->findAll();

        return $this->render('list.html.twig', [
            'origins' => $origins
        ]);
    }

}