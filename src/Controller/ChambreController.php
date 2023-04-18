<?php

namespace App\Controller;

use DateTime;
use App\Entity\Chambre;
use App\Form\ChambreFormType;
use App\Repository\ChambreRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


#[Route('/admin')]
class ChambreController extends AbstractController
{
    #[Route('/ajouter-une-chambre', name: 'create_chambre', methods: ['GET', 'POST'])]
    public function createChambre(Request $request,ChambreRepository $repository, SluggerInterface $slugger): Response
    {
        $chambre = new Chambre();
        $form = $this->createForm(ChambreFormType::class, $chambre);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $chambre->setCreatedAt(new DateTime());
            $chambre->setUpdatedAt(new DateTime());

            $newPhoto = $form->get('photo')->getData();

            if($newPhoto){
                $this->handleFile($chambre, $newPhoto, $slugger);   
            } //end  if($photo)

            $repository->save($chambre,true);
            $this->addFlash('success',"la chambre est en ligne avec succès!");
            return $this->redirectToRoute('show_dashboard');
        }//end if($form)

        return $this->render('admin/chambre/form.html.twig',[
            'form'=>$form->createView()
        ]);

    }//end createChambre()

    #[Route('/modifier-une-chambre/{id}', name: 'update_chambre', methods: ['GET','POST'])]
    public function updateChambre(Chambre $chambre, Request $request, ChambreRepository $repository, SluggerInterface $slugger): Response
    {
        $currentPhoto = $chambre->getPhoto();

        $form = $this-> createForm(ChambreFormType::class, $chambre,[
            'photo'=>$currentPhoto
        ])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chambre->setUpdatedAt(new DateTime());
            $newPhoto = $form->get('photo')->getData();

            if($newPhoto){
                $this->handleFile($chambre, $newPhoto, $slugger); 
            } else {
                $chambre->setPhoto($currentPhoto);
            }//end if($newPhoto)

            $repository->save($chambre,true);

            $this->addFlash('success',"La modification a bien été enregistré.");
            return $this->redirectToRoute('show_dashboard');
        }//end if($form)

        return $this->render('admin/chambre/form.html.twig',[
            'form'=>$form->createView(),
            'chambre'=> $chambre
        ]);
    }//end updateChambre()

    #[Route('/archiver-une-chambre/{id}', name:'soft_delete_chambre', methods:['GET'])]
    public function softDeleteChambre(Chambre $chambre, ChambreRepository $repository): Response
    {
        $chambre->setDeletedAt(new DateTime());
        
        $repository -> save($chambre,true);

        $this->addFlash('success',"La chambre a bien été archivée");
        return $this->redirectToRoute('show_dashboard');
    }

    private function handleFile(Chambre $chambre, UploadedFile $photo, SluggerInterface $slugger)
    {

        $extension='.'.$photo->guessExtension();

        $extension='.'.$photo->guessExtension();

        $safeFilename=$slugger->slug(pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME));
                
        $newFilename=$safeFilename.'_'.uniqid("",true).$extension;
   
        try{
        
            $photo->move($this->getParameter('uploads_dir'),$newFilename);
            $chambre->setPhoto($newFilename);
        }
        catch(FileException $exception) {
            $this->addFlash('warning',"le fichier photo ne s'est pas importé correctement".$exception->getMessage());
        }//end catch
    }
}// end class