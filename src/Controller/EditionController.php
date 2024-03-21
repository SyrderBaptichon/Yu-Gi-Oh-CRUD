<?php

namespace App\Controller;

use App\Entity\Edition;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EditionController extends AbstractController
{
    #[Route('/editions', name: 'app_edition')]
    public function showAll(EntityManagerInterface $entityManager): Response
    {
        $editions = $entityManager->getRepository(Edition::class)->findAll();

        if (!$editions) {
            throw $this->createNotFoundException('Aucune édition trouvée !');
        }

        $tableRows = '';
        foreach ($editions as $edition) {
            $tableRows .= '
            <tr>
                <td>' . $edition->getNomEdition() . '</td>
                <td>' . $edition->getId() . '</td>
                <td>' . $edition->getDateEdition()->format('Y-m-d') . '</td>
            </tr>
        ';
        }

        $html = '
        <h1>Voici les éditions :</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>Nom de l\'édition</th>
                    <th>Numéro de l\'édition</th>
                    <th>Date de l\'édition</th>
                </tr>
            </thead>
            <tbody>
                ' . $tableRows . '
            </tbody>
        </table>
    ';

        return new Response($html);
    }


    #[Route('/edition/insert/', name: 'create_editon')]
    public function createEdition(EntityManagerInterface $entityManager): Response
    {
        $edition = new Edition();
        $edition->setNomEdition('aaa');
        $date = new DateTime();
        $edition->setDateEdition($date);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($edition);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response("L'édition ".$edition->getNomEdition()." à été ajouter à la base de donnée avec succès !");
    }

    #[Route('/edition/{id}', name: 'show_editon')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Voici l\'édition: '.$edition->getNomEdition());
    }

    #[Route('/edition/update/{id}', name: 'update_edition')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $edition->setNomEdition('aaa');
        $entityManager->flush();

        return new Response('Ce qui a été mise à jour : '.$edition->getNomEdition());

    }

    #[Route('/edition/delete/{id}', name: 'delete_edition')]
    public function delete(EntityManagerInterface $entityManager, int $id): Response
    {
        $edition = $entityManager->getRepository(Edition::class)->find($id);

        if (!$edition) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($edition);
        $entityManager->flush();

        return new Response('Ce qui a été supprimer : '.$edition->getNomEdition());
    }
}
