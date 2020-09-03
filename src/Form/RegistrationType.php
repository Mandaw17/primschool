<?php

namespace App\Form;

use App\Entity\Eleve;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
            ->add('username',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
            ->add('password',PasswordType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
            ->add('role',TextType::class,array('attr'=>array('class'=>'form-control','width'=>'80%','style'=>'margin-bottom:15px','style'=>'margin-right:15px')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
