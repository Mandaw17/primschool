<?php

namespace App\Controller;

use App\Entity\Rv;
use App\Entity\Note;
use App\Entity\Eleve;
use App\Entity\Users;
use App\Entity\Classe;
use App\Entity\Seance;
use App\Entity\Demande;
use App\Entity\Matiere;
use App\Entity\Controle;
use App\Entity\Enseignant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/",name="home")
     */
    public function home()
    {
        $eleves = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->findAll();
        $enseignants = $this->getDoctrine()
                ->getRepository(Enseignant::class)
                ->findAll(); 
        $classes = $this->getDoctrine()
                ->getRepository(Classe::class)
                ->findAll();
        $rvs = $this->getDoctrine()
            ->getRepository(Rv::class)
            ->findAll();
        $demandes = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findAll();    
        
            
        return $this->render('default/home.html.twig',array(
            'eleves' => $eleves,
            'enseignants' => $enseignants,
            'classes' => $classes,
            'rvs' => $rvs,
            'demandes' => $demandes

        ));
    }


    /**
     * @Route("/classe/{id}",name="classe{id}") 
     */
    public function classeAction($id)
    {
        $eleves = $this->getDoctrine()
            ->getRepository(Eleve::class)
            ->findAll();
        $classe = $this->getDoctrine()
            ->getRepository(Classe::class)
            ->find($id);    
        $matieres = $this->getDoctrine()
            ->getRepository(Matiere::class)
            ->findAll();
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();    
        $tableauMatieres = $classe->getMatiere();
          
        return $this->render('default/classe.html.twig',array(
            'users' => $users,
            'eleves' => $eleves,
            'classe' => $classe,
            'matieres' => $matieres,
            'tableau' => $tableauMatieres
        ));  
    }

    

    /**
     * @Route("/modifierEleve/{id}",name="modifierEleve")
     */
    public function modifierEleve($id,Request $request)
    {   
        $classe = $this->getDoctrine()
        ->getRepository(Classe::class)
        ->findAll();
        $eleve = $this->getDoctrine()
        ->getRepository(Eleve::class)
        ->find($id);

        $eleve->setNom($eleve->getNom());
        $eleve->setPrenom($eleve->getPrenom());
        $eleve->setDateNaiss($eleve->getDateNaiss());
        $eleve->setLieuNaiss($eleve->getLieuNaiss());
        $eleve->setSexe($eleve->getSexe());
        $eleve->setClasseIn($eleve->getClasseIn());
        $eleve->setNomParent($eleve->getNomParent());
        $eleve->setPrenomParent($eleve->getPrenomParent());
        $eleve->setTelephoneParent($eleve->getTelephoneParent());
        $eleve->setAdresse($eleve->getAdresse());
        $eleve->setEmailParent($eleve->getEmailParent());
        
        $form = $this->createFormBuilder($eleve)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('prenom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('dateNaiss',DateType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('lieuNaiss',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        //->add('classeIn',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('sexe',ChoiceType::class,array('choices'=>array('F'=>'F','M'=>'M'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('classeIn',EntityType::class,array('class'=>Classe::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('nomParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('prenomParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('telephoneParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('adresse',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('emailParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name=$form['nom']->getData();
            $surname=$form['prenom']->getData();
            $dateNaiss=$form['dateNaiss']->getData();
            $lieuNaiss=$form['lieuNaiss']->getData();
            $sexe=$form['sexe']->getData();
            $classe=$form['classeIn']->getData();
           // $classe = $cr->getNom();
            $nomParent=$form['nomParent']->getData();
            $prenomParent=$form['prenomParent']->getData();
            $telephoneParent=$form['telephoneParent']->getData();
            $adresse=$form['adresse']->getData();
            $emailParent=$form['emailParent']->getData();

            $em=$this->getDoctrine()->getManager();
            $eleve=$em->getRepository(Eleve::class)
                      ->find($id);

            $eleve->setNom($name);
            $eleve->setPrenom($surname);
            $eleve->setDateNaiss($dateNaiss);
            $eleve->setLieuNaiss($lieuNaiss);
            $eleve->setSexe($sexe);
            $eleve->setClasseIn($classe);
            $eleve->setNomParent($nomParent);
            $eleve->setPrenomParent($prenomParent);
            $eleve->setTelephoneParent($telephoneParent);
            $eleve->setAdresse($adresse);
            $eleve->setEmailParent($emailParent);

            $em->flush();

            $this->addFlash(
                'notice',
                'eleve ajoute avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        
        return $this->render('default/modifierEleve.html.twig',array(
            'eleve'=>$eleve,
            'form'=>$form->createView()
        ));
    }

    /**
     * @Route("/deleteEleve/{id}",name="deleteEleve")
     */
    public function deleteEleve($id)
    {
        $em=$this->getDoctrine()->getManager();
        $eleve=$em->getRepository(Eleve::class)
                  ->find($id);
        $em->remove($eleve);
        $em->flush();

        $this->addFlash(
            'notice',
            'eleve ajoute avec succes'
        );

        return $this->redirectToRoute('listeClasses');
    }

    /**
     * @Route("/profilsEleves/{id}",name="profilsEleves")
     */
    public function profilsElevesAction($id)
    {
        $eleve = $this->getDoctrine()
            ->getRepository(Eleve::class)
            ->find($id);

        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findAll();    
        $users = $this->getDoctrine()
            ->getRepository(Users::class)    
            ->findAll();    
        return $this->render('default/profilsEleves.html.twig',array(
            'users' => $users,
            'eleve' => $eleve,
            'notes' => $notes
        ));  
    }

    /**
     * @Route("/listeClasses",name="listeClasses")
     */
    public function listeClassesAction(){
        $classes = $this->getDoctrine()
            ->getRepository(Classe::class)
            ->findAll();
        return $this->render('default/listeClasses.html.twig',array(
            'classes' => $classes,
        ));  
    }

    /**
     * @Route("/addClasse",name="addClasse")
     */
    public function addClasse(Request $request){
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findAll();
        $classe = new Classe;
        
        $form1 = $this->createFormBuilder($classe)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('idEns',EntityType::class,array('class'=>Enseignant::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $name=$form1['nom']->getData();
            $enseignant=$form1['idEns']->getData();

            $classe->setNom($name);
            $classe->setIdens($enseignant);

            $em=$this->getDoctrine()->getManager();

            $em->persist($classe);
            $em->flush();

            $this->addFlash(
                'notice',
                'classe ajoutee avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        
        return $this->render('default/addClasse.html.twig',array(
            'form1' => $form1->createView()
        ));
    }

    /**
     * @Route("/modifierClasse/{id}",name="modifierClasse")
     */
    public function modifierClasse($id,Request $request)
    {
        $enseignant = $this->getDoctrine()
        ->getRepository(Enseignant::class)
        ->findAll();
        $classe = $this->getDoctrine()
        ->getRepository(Classe::class)
        ->find($id);

        $classe->setNom($classe->getNom());
        $classe->setIdens($classe->getIdens());
        
        $form1 = $this->createFormBuilder($classe)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('idEns',EntityType::class,array('class'=>Enseignant::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $form1->handleRequest($request);

        if($form1->isSubmitted() && $form1->isValid()){
            $name=$form1['nom']->getData();
            $enseignant=$form1['idEns']->getData();

            
            $em=$this->getDoctrine()->getManager();
            $classe=$em->getRepository(Classe::class)->find($id);


            $classe->setNom($name);
            $classe->setIdens($enseignant);

            $em->flush();

            $this->addFlash(
                'notice',
                'classe modifiee avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        return $this->render('default/modifierClasse.html.twig',array(
            'classe'=>$classe,
            'form1' =>$form1->createView()
        ));
    }

    /**
     * @Route("/enseignants",name="enseignants") 
     */
    public function enseignantAction()
    {
        $enseignants = $this->getDoctrine()
            ->getRepository(Enseignant::class)
            ->findAll();
        $users = $this->getDoctrine()
            ->getRepository(Users::class)    
            ->findAll();
        return $this->render('default/enseignants.html.twig',array(
            'users' => $users,
            'enseignants' => $enseignants
        ));  
    }

    /**
     * @Route("/profilsEnseignants/{id}",name="profilsEnseignants")
     */
    public function profilsEnseignantsAction($id)
    {
        $enseignant= $this->getDoctrine()
            ->getRepository(Enseignant::class)
            ->find($id);
        return $this->render('default/profilsEnseignants.html.twig',array(
            'enseignant' => $enseignant
        ));  
    }

    /**
     * @Route("/addEnseignant",name="addEnseignant")
     */
    public function addEnseignant(Request $request)
    {
        $enseignant = new Enseignant;
        
        $form2 = $this->createFormBuilder($enseignant)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('prenom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('sexe',ChoiceType::class,array('choices'=>array('F'=>'F','M'=>'M'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('dateNaiss',BirthdayType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('lieuNaiss',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('adresse',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('classe',EntityType::class,array('class'=>Classe::class,'choice_label'=>'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('tel',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('diplome',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()){
            $nom=$form2['nom']->getData();
            $prenom=$form2['prenom']->getData();
            $sexe=$form2['sexe']->getData();
            $dateNaiss=$form2['dateNaiss']->getData();
            $lieuNaiss=$form2['lieuNaiss']->getData();
            $adresse=$form2['adresse']->getData();
            $classe=$form2['classe']->getData();
            $tel=$form2['tel']->getData();
            $diplome=$form2['diplome']->getData();

            $enseignant->setNom($nom);
            $enseignant->setPrenom($prenom);
            $enseignant->setSexe($sexe);
            $enseignant->setDatenaiss($dateNaiss);
            $enseignant->setLieunaiss($lieuNaiss);  
            $enseignant->setAdresse($adresse);
            $enseignant->setClasse($classe);
            $enseignant->setTel($tel);
            $enseignant->setDiplome($diplome);

            $em=$this->getDoctrine()->getManager();

            $em->persist($enseignant);
            $em->flush();

            $this->addFlash(
                'notice',
                'enseignant ajoute avec succes'
            );

            return $this->redirectToRoute('enseignants');
        }
        
        return $this->render('default/addEnseignant.html.twig',array(
            'form2' => $form2->createView()
        ));
    }

     /**
     * @Route("/modifierEnseignant/{id}",name="modifierEnseignant")
     */
    public function modifierEnseignant($id,Request $request)
    {
       // $enseignant = new Enseignant;
        $enseignant = $this->getDoctrine()
                    ->getRepository(Enseignant::class)
                    ->find($id); 

        $enseignant->setNom($enseignant->getNom());
        $enseignant->setPrenom($enseignant->getPrenom());
        $enseignant->setSexe($enseignant->getSexe());
        $enseignant->setDatenaiss($enseignant->getDateNaiss());
        $enseignant->setLieunaiss($enseignant->getLieuNaiss());  
        $enseignant->setAdresse($enseignant->getAdresse());
        $enseignant->setClasse($enseignant->getClasse());
        $enseignant->setTel($enseignant->getTel());
        $enseignant->setDiplome($enseignant->getDiplome());


        $form2 = $this->createFormBuilder($enseignant)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('prenom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('sexe',ChoiceType::class,array('choices'=>array('F'=>'F','M'=>'M'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('dateNaiss',DateType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('lieuNaiss',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('adresse',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('classe',EntityType::class,array('class'=>Classe::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('tel',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('diplome',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()){
            $nom=$form2['nom']->getData();
            $prenom=$form2['prenom']->getData();
            $sexe=$form2['sexe']->getData();
            $dateNaiss=$form2['dateNaiss']->getData();
            $lieuNaiss=$form2['lieuNaiss']->getData();
            $adresse=$form2['adresse']->getData();
            $classe=$form2['classe']->getData();
            $tel=$form2['tel']->getData();
            $diplome=$form2['diplome']->getData();

            $em=$this->getDoctrine()->getManager();
            $enseignant=$em->getRepository(Enseignant::class)
                      ->find($id);

            $enseignant->setNom($nom);
            $enseignant->setPrenom($prenom);
            $enseignant->setSexe($sexe);
            $enseignant->setDatenaiss($dateNaiss);
            $enseignant->setLieunaiss($lieuNaiss);  
            $enseignant->setAdresse($adresse);
            $enseignant->setClasse($classe);
            $enseignant->setTel($tel);
            $enseignant->setDiplome($diplome);

            $em->flush();

            $this->addFlash(
                'notice',
                'enseignant modifie avec succes'
            );

            return $this->redirectToRoute('enseignants');
        }
        return $this->render('default/modifierEnseignant.html.twig',array(
            'form2' => $form2->createView()
        ));
    }


      /**
     * @Route("/deleteClasse/{id}",name="deleteClasse")
     */
    public function deleteClasse($id)
    {
        $em=$this->getDoctrine()->getManager();
        $classe=$em->getRepository(Classe::class)
                  ->find($id);
        $em->remove($classe);
        $em->flush();

        $this->addFlash(
            'notice',
            'classe supprimee avec succes'
        );

        return $this->redirectToRoute('listeClasses');
    }

      /**
     * @Route("/deleteEnseignant/{id}",name="deleteEnseignant")
     */
    public function deleteEnseignant($id)
    {
        $em=$this->getDoctrine()->getManager();
        $enseignant=$em->getRepository(Enseignant::class)
                  ->find($id);
        $em->remove($enseignant);
        $em->flush();

        $this->addFlash(
            'notice',
            'enseignant supprime avec succes'
        );

        return $this->redirectToRoute('enseignants');
    }

    /**
     * @Route("/planning/{id}",name="planning")
     */
    public function controleAction($id)
    {
        $controles = $this->getDoctrine()
            ->getRepository(Controle::class)
            ->findAll();
        $classe = $this->getDoctrine()
            ->getRepository(Classe::class)
            ->find($id);    

        $seances = $this->getDoctrine()
        ->getRepository(Seance::class)
        ->findAll();

        return $this->render('default/planning.html.twig',array(
            'seances' => $seances,
            'controles' => $controles,
            'classe' => $classe
        ));  
    }
    /**
     * @Route("/addControle",name="addControle")
     */
    public function addControle(Request $request)
    {
        $controle = new Controle;

        $formControle = $this->createFormBuilder($controle)
        ->add('datecontrol',DateType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('duree',TimeType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('matiere',EntityType::class,array('class'=>Matiere::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('classe',EntityType::class,array('class'=>Classe::class,'choice_label'=> 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm();

        $formControle->handleRequest($request);

        if($formControle->isSubmitted() && $formControle->isValid()){
            $date=$formControle['datecontrol']->getData();
            $duree=$formControle['duree']->getData();
            $classe=$formControle['classe']->getData();
            $matiere=$formControle['matiere']->getData();

            $controle->setDatecontrol($date);
            $controle->setDuree($duree);
            $controle->setMatiere($matiere);
            $controle->setClasse($classe);

            $em=$this->getDoctrine()->getManager();

            $em->persist($controle);
            $em->flush();

            $this->addFlash(
                'notice',
                'controle programme avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        return $this->render("default/addControle.html.twig",array(
            'controle' => $controle,
            'formControle'=> $formControle->createView()
        ));            
    }

    /**
     * @Route("/noterEleve/{id}",name="noterEleve")
     */
    public function noterEleve($id,Request $request)
    {
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        $controles = $this->getDoctrine()
                ->getRepository(Controle::class)
                ->findAll();        
        $note = new Note;

        $formNote = $this->createFormBuilder($note)
        ->add('controle',EntityType::class,array('class'=>Controle::class,'choice_label' => 'id','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('note',NumberType::class,array('attr'=>array('min'  => 0,'max'  => 20,'class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $controle = $formNote['controle']->getData();
            $noteEl = $formNote['note']->getData();

            $note->setControle($controle);
            $note->setNote($noteEl);
            $note->setEleve($eleve);

            $em=$this->getDoctrine()->getManager();

            $em->persist($note);
            $em->flush();

            $this->addFlash(
                'notice',
                'note attribuee avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        return $this->render('default/noterEleve.html.twig',array(
            'eleve' => $eleve,
            'controles' => $controles,
            'formNote' => $formNote->createView()
        ));
    }

    /**
     * @Route("/modifierNote/{id}", name="modifierNote")
     */
    public function modifierNote($id,Request $request)
    {
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->findAll();
        $note = $this->getDoctrine()
                ->getRepository(Note::class)
                ->find($id);
       
        $note->setControle($note->getControle());
        $note->setNote($note->getNote());
        
        $formNote = $this->createFormBuilder($note)
        ->add('controle',EntityType::class,array('class'=>Controle::class,'choice_label' => 'id','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('note',NumberType::class,array('attr'=>array('min'  => 0,'max'  => 20,'class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $formNote->handleRequest($request);

        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $controle = $formNote['controle']->getData();
            $noteEl = $formNote['note']->getData();

            $em=$this->getDoctrine()->getManager();
            $note= $em->getRepository(Note::class)
                    ->find($id);

            $note->setControle($controle);
            $note->setNote($noteEl);
            $note->setEleve($eleve);

            $em->flush();

            $this->addFlash(
                'notice',
                'note modifiee avec succes'
            );    
            return $this->redirectToRoute('listeClasses');
        }
        return $this->render('default/modifierNote.html.twig',array(
            'eleve' => $eleve,
            'formNote' => $formNote->createView()
        ));
    }

    /**
     * @Route("/deleteNote/{id}", name="deleteNote")
     */
    public function deleteNote($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $note=$em->getRepository(Note::class)
                  ->find($id);

        $em->remove($enseignant);
        $em->flush();

        $this->addFlash(
            'notice',
            'note supprimee avec succes'
        );

        return $this->redirectToRoute('listeClasses');
    }

    /**
     * @Route("/affecterMatiereClasse/{id}", name="affecterMatiereClasse")
     */
    public function affecterMatiereClasse($id,Request $request)
    {
        $classe = $this->getDoctrine()
                ->getRepository(Classe::class)
                ->find($id);
        $matiere = $this->getDoctrine()
                ->getRepository(Matiere::class)
                ->findAll();

        $formNote = $this->createFormBuilder($matiere)
        ->add('nom',EntityType::class,array('class'=>Matiere::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $formNote->handleRequest($request);
        
        if ($formNote->isSubmitted() && $formNote->isValid()) {
            $nom = $formNote['nom']->getData();

         //  $matiere->setNom($nom);
            $classe->addMatiere($nom);

            $em=$this->getDoctrine()->getManager();

            
            $em->flush();

            $this->addFlash(
                'notice',
                'affectation reussie'
            );

            return $this->redirectToRoute('listeClasses');
        } 
        
        return $this->render('default/affecterMatiereClasse.html.twig',array(
            'classe' => $classe,
            'formNote' => $formNote->createView()
        ));

               
    }

    /**
     * @Route("/creerSeance/{id}", name="creerSeance")
     */
    public function creerSceance($id, Request $request)
    {
        $classe = $this->getDoctrine()
                ->getRepository(Classe::class)
                ->find($id);

        $seance = new Seance;

        $form = $this->createFormBuilder($seance)
        ->add('jour',ChoiceType::class,array('choices'=>array('Lundi'=>'Lundi','Mardi'=>'Mardi','Mercredi'=>'Mercredi','Jeudi'=>'Jeudi','Vendredi'=>'Vendredi','Samedi'=>'Samedi'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('matiere',EntityType::class,array('class'=>Matiere::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('heure',TimeType::class,array('attr'=>array('min'  => 0,'max'  => 20,'class'=>'form-control','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',submitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();
       
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jour = $form['jour']->getData();
            $matiere = $form['matiere']->getData();
            $heure = $form['heure']->getData();

            $seance->setJour($jour);
            $seance->setMatiere($matiere);
            $seance->setHeure($heure);
            $seance->setClasse($classe);
            //$classe->addSceances($seance);

            $em=$this->getDoctrine()->getManager();

            $em->persist($seance);
            $em->flush();

            $this->addFlash(
                'notice',
                'affectation reussie'
            );

            return $this->redirectToRoute('listeClasses');
        }
        return $this->render('default/creerSeance.html.twig',array(
            'seance'=>$seance,
            'form' => $form->createView()
        ));
    }
}
