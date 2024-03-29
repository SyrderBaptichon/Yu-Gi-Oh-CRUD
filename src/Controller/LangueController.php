<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Form\LangueType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LangueController extends AbstractController
{
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LangueController.php',
        ]);
    }

    /**
     *
     * @Route("/insertLangueForm", name="musee_dummynew")
     * @Method({"GET", "POST"})
     */
    #[Route("/langue/insert", name: "langue_insert")]
    public function action(EntityManagerInterface $entityManager, Request $request): Response
    {
        $langue = new Langue();
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langue = $form->getData();
            $entityManager->persist($langue);
            // but, the original `$task` variable has also been updated
            $entityManager->flush();
            return $this->redirectToRoute('langues_show') ;
        }

        return $this->render('langue/formLangue.html.twig', array(
            'form' => $form,
        ));
    }
    public function insererLangue(EntityManagerInterface $entityManager) :Response
    {
        $langue = new Langue();
        $langue->setNomLangue("benin");
        $entityManager->persist($langue);
        $entityManager->flush();

        return new Response("La langue ".$langue->getNomLangue()." à été ajouter à la base de dponnée avec succès !");
    }
    #[Route('/langue', name: 'langues_show')]
    public function showAll(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request) :Response
    {
        $langues = $entityManager->getRepository(Langue::class)->findAll();

        // Paginer les données
        $pagination = $paginator->paginate(
            $langues, // Les données à paginer
            $request->query->getInt('page', 1), // Numéro de page à afficher, 1 par défaut
            12 // Nombre d'éléments par page
        );

        // Passer les données paginées au template Twig
        return $this->render('langue/langues.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    #[Route('/langue/{id}', name: 'product_show')]
    public function showByID(EntityManagerInterface $entityManager, int $id): Response
    {
        $langue = $entityManager->getRepository(Langue::class)->find($id);

        if (!$langue) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('edition/edition.html.twig', [
            'langue' => $langue,
        ]);
    }

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
    #[Route("/langue/{id}/update", name: "langue_update")]
    public function formActionUpdate(EntityManagerInterface $entityManager,int $id, Request $request) :Response
    {
        $langue = $entityManager->getRepository(Langue::class)->find($id);
        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $langue = $form->getData();
            $entityManager->persist($langue);
            // but, the original `$task` variable has also been updated
            $entityManager->flush();
            return $this->redirectToRoute('langues_show');
        }

        return $this->render('langue/formLangue.html.twig', array(
            'form' => $form,
        ));}

    #[Route('/langue/{id}/delete', name: 'delete_langue')]
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

        return $this->redirectToRoute('langues_show') ;

    }

}
