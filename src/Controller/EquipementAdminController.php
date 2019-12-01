<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Equipement;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EquipementType;

class EquipementAdminController extends AbstractController
{
	 /**
     * @Route("/football/equipement/", name="equipement" , methods={"GET","HEAD"})
     */
    public function voir_tous_equipement(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Equipement::class);
        $equipements = $repository->Voir_tous_equipement_par_nom();
        return $this->render('blog/equipement.html.twig', [
            'equipements' => $equipements,
        ]);
    }
    /**
     * @Route("/football/equipement/{id}/supprimmer"  , name="suppr_equipement" ,methods={"GET","HEAD"})
     */
    public function supprimmer_un_equipement(Equipement $equipement =null, EntityManagerInterface $em)
    {
		if(!$equipement){
			$equipement = new Equipement();
		}

		$em = $this->getDoctrine()->getManager();
		$em->remove($equipement);
        $em->flush();
		#redirection vers l url de nom home
		return $this->redirect( $this->generateUrl('equipement'));
    }
	 /**
     * @Route("/football/info_equipement/voir/id={id}", name="equipement_voir" , methods={"GET", "HEAD"})
     */
    public function voir_un_equipement($id, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Equipement::class);
        /** @var Equipement $equipement */
        $equipement = $repository->findOneBy(['id' => $id]);
        if (!$equipement) {
            throw $this->createNotFoundException(sprintf('pas d equipement pour l indexe "%d"', $id));
        }
        return $this->render('blog/info_equipement.html.twig', [
            'equipement' => $equipement,
        ]);
    }

	 /**
     * @Route("/football/equipement/creation", name="c_equipement")
     * @Route("/football/equipement/{id}/maj", name="maj_equipement")
     */
	public function formulaire(Equipement $equipement = null,Request $request, EntityManagerInterface $em)
    {
		#Si equipement est null donc on creer une classe equipement
		if(!$equipement){
			$equipement = new Equipement();
		}

		#creation du formulaire
        $form = $this->createForm(EquipementType::class, $equipement);
		# execution du requete pour prendre les donnees du formulaire
		$form->handleRequest($request);
		#dump($equipement); //verification si la classe est vide ou pas apres submit
		if ($form->isSubmitted() && $form->isValid()) {

				#ICI POUR LES REQUETES DE CREATION ET DE MODIFICATION
				$em->persist($equipement);
				$em->flush();

				#REDIRECTION VERS LE ELLE MEME(SITE)
			return $this->render('blog/ajouter.html.twig', [
				'form' => $form->createView(),
				'majMode' => $equipement-> getId() !== null
			]);
		}

		return $this->render('blog/ajouter.html.twig', [
			'form' => $form->createView(),
			'majMode' => $equipement-> getId() !== null
		]);
        // ...
    }
}
