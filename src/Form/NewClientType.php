<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Format;
use App\Entity\Type;
use App\Entity\Platform;
//use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class NewClientType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

        $client = new Client();

        $builder->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_last', TextType::class, array('required' => false,'attr' => array('class' => 'form-control' )))
            ->add('client_first', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('url', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control')))
            ->add('parent', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false,
                'class' => Client::class,
                'data' => null
            ))
            ->add('notes', TextareaType::class, array('attr' => array('class' => 'form-control'), 'required' => false))

            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

    }

}