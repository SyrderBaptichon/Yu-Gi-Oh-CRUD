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

    #[Route('/carte/insert', name: 'create_carte')]
    public function createCarte(EntityManagerInterface $entityManager){
        $carte = new Carte();
        $carte->setCarteNom("Les alliés de Ron");
        $carte->setCarteCategorie("Magie");
        $carte->setCarteImage("Indisponible");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($carte);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response("La carte ".$carte->getCarteNom()." a été ajoutée à la base de données avec succès !");
    }

    #[Route('/cartes', name: 'cartes_show')]
    public function showAll(EntityManagerInterface $entityManager) :Response
    {
        $cartes = $entityManager->getRepository(Carte::class)->findAll();

        // Générer le tableau HTML
        $table = '<h1>Voici les cartes :</h1><table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Attribut</th>
                        <th>Niveau</th>
                        <th>Image</th>
                        <th>Type</th>
                        <th>Spécificité</th>
                        <th>ATK</th>
                        <th>DEF</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($cartes as $carte) {
            $table .= '<tr>
                    <td>' . $carte->getId() . '</td>
                    <td>' . $carte->getCarteNom() . '</td>
                    <td>' . $carte->getCarteCategorie() . '</td>
                    <td>' . $carte->getCarteAttribut() . '</td>
                    <td>' . $carte->getCarteNiveau() . '</td>
                    <td>' . $carte->getCarteImage() . '</td>
                    <td>' . $carte->getCarteType() . '</td>
                    <td>' . $carte->getCarteSpecificite() . '</td>
                    <td>' . $carte->getCarteATK() . '</td>
                    <td>' . $carte->getCarteDEF() . '</td>
                    <td>' . $carte->getCarteDescription() . '</td>
                </tr>';
        }

        $table .= '</tbody></table>';

        // Retourner le tableau dans une réponse HTTP
        return new Response($table);
    }

    #[Route('/carte/{id}', name: 'carte_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $carte = $entityManager->getRepository(Carte::class)->find($id);

        if (!$carte) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Voici la carte: '.$carte->getCarteNom());
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

        return new Response('Ce qui a été mise à jour : '.$product->getCarteNom());
    }

    #[Route('/carte/delete/{id}', name: 'delete_carte')]
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
