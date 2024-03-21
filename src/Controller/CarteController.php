<?php

namespace App\Controller;

use App\Entity\Carte;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarteController extends AbstractController
{
    #[Route('/carte', name: 'app_carte')]
    public function index(): Response
    {
        return $this->render('carte/index.html.twig', [
            'controller_name' => 'CarteController',
        ]);
    }

    #[Route('/cartes', name: 'cartes_show')]
    public function showAll(EntityManagerInterface $entityManager) :Response
    {
        $cartes = $entityManager->getRepository(Carte::class)->findAll();
        $chaine=" <br/>";
        if(!$cartes){
            throw $this->createNotFoundException('rien !');
        }
        foreach ($cartes as $carte){
            $chaine.=$carte->getCarteNom()."<br/>";
        }
        return new Response("Voici les cartes : \n".$chaine);
    }

    #[Route('/carte/{id}', name: 'product_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $carte = $entityManager->getRepository(Carte::class)->find($id);

        if (!$carte) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$carte->getCarteNom());
    }

    #[Route('/carte/insert', name: 'create_carte')]
    public function createCarte(EntityManagerInterface $entityManager){
        $carte = new Carte();
        $carte->setNumCarte(5);
        $carte->setCarteNom("Les alliés de Ron");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($carte);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$carte->getCarteNom());
    }

    #[Route('/carte/update/{id}', name: 'update_carte')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Carte::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setCarteNom($product->getCarteNom()." modifié");
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }

    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Carte::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response('Ce qui a été supprimer : '.$product->getCarteNom());

    }


}
