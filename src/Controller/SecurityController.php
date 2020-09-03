<?php

namespace App\Controller;

use App\Entity\Rv;
use App\Entity\Note;

use App\Entity\Eleve;
use App\Entity\Users;
use App\Entity\Classe;
use App\Entity\Demande;
use App\Entity\Plainte;
use App\Entity\Enseignant;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symf0ony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscrire/{id}",name="security_registration")
     */
    public function registration($id ,Request $request , ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        $users = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findAll();        
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          //  $ide = $form['id']->getData();
            $idel = $eleve->getId();
            $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setId($idel); 

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listeUsers');
        }

        return $this->render('security/registration.html.twig',array(
            'eleve' => $eleve,
            'users' => $users,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/inscrireEns/{id}",name="security_registration_enseignant")
     */
    public function registrationEns($id ,Request $request , ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new Users();
        $enseignant = $this->getDoctrine()
                ->getRepository(Enseignant::class)
                ->find($id);
        $users = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findAll();                
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          //  $ide = $form['id']->getData();
            $idel = $enseignant->getId();
            $hash = $encoder->encodePassword($user, $user->getPassword()); 
            $user->setPassword($hash);
            $user->setId(100000000+$idel); 

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('listeUsers');
        }

        return $this->render('security/registrationEns.html.twig',array(
            'enseignant' => $enseignant,
            'users' => $users,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/addEleve",name="addEleve")
     */
    public function addEleve(Request $request, ObjectManager $em, UserPasswordEncoderInterface $encoder)
    {
        $classe = $this->getDoctrine()
        ->getRepository(Classe::class)
        ->findAll();
        $eleve = new Eleve;
        //$user = new Users();

       // $cr = $eleve->nomClasse;
        
        //$formIns = $this->createForm(RegistrationType::class, $user);

        //$formIns->handleRequest($request);

        $form = $this->createFormBuilder($eleve)
        ->add('nom',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('prenom',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('dateNaiss',BirthdayType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('lieuNaiss',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        //->add('classeIn',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('sexe',ChoiceType::class,array('choices'=>array('F'=>'F','M'=>'M'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('classeIn',EntityType::class,array('class'=>Classe::class,'choice_label' => 'nom','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('nomParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('prenomParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('telephoneParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('adresse',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('emailParent',TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
        ->add('Enregistre',SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-bottom:15px')))
        ->getForm(); 

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
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

            $em=$this->getDoctrine()->getManager();

            $em->persist($eleve);
            $em->flush();

            $this->addFlash(
                'notice',
                'eleve ajoute avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        
        return $this->render('security/addEleve.html.twig',array(
       //     'formIns' => $formIns->createView(),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/bulletin/{id}", name="bulletin")
     */
    public function bulletin($id)
    {
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        $notes = $this->getDoctrine()
                ->getRepository(Note::class)
                ->findAll(); 
        return $this->render("security/bulletin.html.twig",array(
            'eleve' => $eleve,
            'notes' => $notes
        ));
    }

    /**
     * @Route("/plainte/{id}", name="plainte")
     */
    public function plainte($id)
    {
        $plaintes = $this->getDoctrine()
                ->getRepository(Plainte::class)
                ->findAll();
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        return $this->render("security/plainte.html.twig",array(
            'eleve' => $eleve,
            'plaintes' => $plaintes
        ));
    }

    /**
     * @Route("/addPlainte/{id}", name="addPlainte")
     */
    public function addPlainte($id,Request $request)
    {
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        $plainte = new Plainte;
        
        $form = $this->createFormBuilder($plainte)
        ->add('lib',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('commentaire',TextareaType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $lib = $form['lib']->getData();
            $commentaire = $form['commentaire']->getData();

            $plainte->setLib($lib);
            $plainte->setCommentaire($commentaire);
            $plainte->setEleve($eleve);

            $em=$this->getDoctrine()->getManager();

            $em->persist($plainte);
            $em->flush();

            $this->addFlash(
                'notice',
                'plainte ajoutee avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }
        return $this->render("security/addPlainte.html.twig",array(
            'eleve' => $eleve,
            'form' => $form->createView()
        ));
    }       

    /**
     * @Route("/rendezvous/{id}", name="rendezvous")
     */
    public function rendezvous($id)
    {
        $rvs = $this->getDoctrine()
            ->getRepository(Rv::class)
            ->findAll();
        $eleve = $this->getDoctrine()
            ->getRepository(Eleve::class)
            ->find($id);
            
        return $this->render("security/rendezvous.html.twig",array(
            'rvs' => $rvs,
            'eleve' => $eleve
        ));    
    }

    /**
     * @Route("/addRv/{id}", name="addRv")
     */
    public function addRv($id, Request $request)
    {
        $rv = new Rv;
        
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);

        $form = $this->createFormBuilder($rv)
        ->add('date',DateType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('heure',TimeType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ->add('Enregistre',SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $heure = $form['heure']->getData();
            $date = $form['date']->getData();

            $rv->setHeure($heure);
            $rv->setDate($date);
            $rv->setEleve($eleve);

            $em=$this->getDoctrine()->getManager();

            $em->persist($rv);
            $em->flush();

            $this->addFlash(
                'notice',
                'Rendez-Vous ajouté avec succes'
            );

            return $this->redirectToRoute('listeClasses');
        }        
        return $this->render("security/addRv.html.twig",array(
            'eleve' => $eleve,
            'rv' => $rv,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/demanderRv/{id}", name="demanderRv") 
     */
    public function demanderRv($id, Request $request)
    {
        $eleve = $this->getDoctrine()
                ->getRepository(Eleve::class)
                ->find($id);
        $demande = new Demande;
        
        $demande->setEleve($eleve);
        $form = $this->createFormBuilder($demande)
        ->add('Demander',SubmitType::class,array('attr'=>array('class'=>'btn btn-primary','style'=>'margin-top:15px')))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            
          //  $idel = $form['idEleve']->getData();

            $demande->setEleve($eleve);

            $em=$this->getDoctrine()->getManager();

            $em->persist($demande);
            $em->flush();

            $this->addFlash(
                'notice',
                'Rendez-Vous demandé '
            );

            return $this->redirectToRoute('home');

        }
        return $this->render("security/demanderRv.html.twig",array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dgHome", name="dgHome")
     */
    public function dgHome()
    {
        $demandes = $this->getDoctrine()
                    ->getRepository(Demande::class)
                    ->findAll();
        $rvs = $this->getDoctrine()
                ->getRepository(Rv::class)
                ->findAll();

        return $this->render("security/dgHome.html.twig",array(
            'demandes' => $demandes,
            'rvs' => $rvs
        ));        
    }

    /**
     * @Route("/listeUsers", name="listeUsers")
     */
    public function listeUsers(Request $request)
    {
        $users = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findAll();
        
        return $this->render('security/listeUsers.html.twig',array(
            'users' => $users
        ));
    }
    /**
     * @Route("/connexion", name="securityLogin")
     */
    public function login()
    {
        return $this->render("security/login.html.twig");
    }

    /**
     * @Route("/deconnection", name="securityLogout")
     */
    public function logout()
    {
        
    }

    /**
     * @Route("/deleteEl/{id}",name="deleteEl")
     */
    public function deleteEl($id)
    {
        $em=$this->getDoctrine()->getManager();
        $eleve=$em->getRepository(Eleve::class)
                  ->find($id);
        

        return $this->render('security/deleteEl.html.twig',array(
            'eleve' => $eleve
        ));
    }

    /**
     * @Route("/deleteEns/{id}",name="deleteEns")
     */
    public function deleteEns($id)
    {
        $em=$this->getDoctrine()->getManager();
        $enseignant=$em->getRepository(Enseignant::class)
                  ->find($id);
        

        return $this->render('security/deleteEl.html.twig',array(
            'eleve' => $enseignant
        ));
    }
}
