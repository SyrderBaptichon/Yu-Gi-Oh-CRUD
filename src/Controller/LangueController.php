<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Form\LangueType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LangueController extends AbstractController
{
    #[Route('/langue', name: 'app_langue')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LangueController.php',
        ]);
    }
    #[Route('/langue/insert', name: 'insert_langue')]

    public function insererLangue(EntityManagerInterface $entityManager) :Response
    {
        $langue = new Langue();
        $langue->setNomLangue("benin");
        $entityManager->persist($langue);
        $entityManager->flush();

        return new Response("La langue ".$langue->getNomLangue()." à été ajouter à la base de dponnée avec succès !");
    }
    #[Route('/langues', name: 'langues')]

    public function showAll(EntityManagerInterface $entityManager) :Response
    {
        $langues = $entityManager->getRepository(Langue::class)->findAll();

        // Générer le tableau HTML
        $table = '<h1>Voici les langues :</h1><table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de la Langue</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($langues as $langue) {
            $table .= '<tr>
                    <td>' . $langue->getId() . '</td>
                    <td>' . $langue->getNomLangue() . '</td>
                </tr>';
        }

        $table .= '</tbody></table>';

        // Retourner le tableau dans une réponse HTTP
        return new Response($table);
    }
    #[Route('/langue/{id}', name: 'product_show')]
    public function showByID(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Langue::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

         return new Response('Check out this great product: '.$product->getNomLangue());
    }

    #[Route('/langue/update/{id}', name: 'product_inflate')]
    public function update(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Langue::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setNomLangue("wolaf");
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }
    #[Route("/{id}/dummy", name: 'modif_langue_form')]

    public function formActionUpdate(EntityManagerInterface $entityManager,int $id)
    {
        $langue = $entityManager->getRepository(Langue::class)->find($id);
        $dummyForm = $this->createForm(LangueType::class, $langue);
        return $this->render('langue/formLangue.html.twig', array('form' => $dummyForm));
    }

    public function formActionInsert()
    {

    }
    #[Route('/langue/delete/{id}', name: 'product_delete')]

    public function suppLangue(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Langue::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response('Ce qui a été supprimer : '.$product->getNomLangue());

    }

}
