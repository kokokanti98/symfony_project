<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Acteur;
use App\Form\ActeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ActeurAdminController extends AbstractController
{
    /**
     * @Route("/football/acteur/{id}/supprimmer"  , name="suppr_acteur" ,methods={"GET","HEAD"})
     */
    public function supprimmer_un_acteur(Acteur $acteur =null, EntityManagerInterface $em)
    {
		if(!$acteur){
			$acteur = new Acteur();
		}

		$em = $this->getDoctrine()->getManager();
		$em->remove($acteur);
        $em->flush();
		#redirection vers l url de nom home
		return $this->redirect( $this->generateUrl('home'));
    }
	/**
     * @Route("/football/", name="home" , methods={"GET","HEAD"})
     */
	 public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Acteur::class);
        $acteurs = $repository->Voir_tous_acteur_par_nom();
        return $this->render('blog/home.html.twig', [
            'acteurs' => $acteurs,
        ]);
    }
	/**
     * @Route("/football/acteur/creation", name="c_acteur")
     * @Route("/football/acteur/{id}/maj", name="maj_acteur")
     */
	public function formulaire(Acteur $acteur = null,Request $request, EntityManagerInterface $em)
    {
		#Si acteur est null donc on creer une classe acteur
		if(!$acteur){
			$acteur = new Acteur();
		}

		#creation du formulaire
        $form = $this->createForm(ActeurType::class, $acteur);
		# execution du requete pour prendre les donnees du formulaire
		$form->handleRequest($request);
		#dump($acteur); //verification si la classe est vide ou pas apres submit
		if ($form->isSubmitted() && $form->isValid()) {

				#ICI POUR LES REQUETES DE CREATION ET DE MODIFICATION
				$em->persist($acteur);
				$em->flush();

				#REDIRECTION VERS LE ELLE MEME(SITE)
			return $this->render('blog/ajouter.html.twig', [
			'form' => $form->createView(),
			]);
		}

		return $this->render('blog/ajouter.html.twig', [
			'form' => $form->createView(),
			'majMode' => $acteur-> getId() !== null
		]);
        // ...
    }

}
