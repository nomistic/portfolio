<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Format;
use App\Entity\Type;
use App\Entity\Subject;
use App\Entity\Platform;
//use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\SubjectRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Work;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class EditWorkType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

        $work = new Work();

        $builder
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_id', EntityType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'class' => Client::class,
                    'query_builder' => function(ClientRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    },
                    'label' => 'Client',
                    'placeholder' => 'Choose a client',

                )

            )
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))

            ->add('notes', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('subjects',EntityType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control'),
                'class' => Subject::class,
                'query_builder' => function(SubjectRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'multiple' => true,
                //'expanded' => true,
            ))


            ->add('pub_url', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))
            ->add('priv_url', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))

            ->add('ghost_ind', CheckboxType::class, [
                'label'    => 'Ghosted  ',
                'required' => false,
            ])

            ->add('type', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'class' => Type::class,
                'label' => 'Type',
                'placeholder' => 'Choose a type',

            ))

            ->add('net_pay', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))
            ->add('hourly', ChoiceType::class, array(
                'attr' => array('class' => 'form-control'),
                'choices' => ['Yes' => true, 'No' => false],
                //'label' => 'Ghosted'
            ))
            ->add('hours', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))


            ->add('format', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'class' => Format::class,
                //'label' => 'Type',
                'placeholder' => 'Choose a format',

            ))

            ->add('date_submitted', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control'),
                'required' => false))

            ->add('date_published', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('class' => 'form-control'),
                'required' => false))

            ->add('platform', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'class' => Platform::class,
                //'label' => 'Type',
                'placeholder' => 'Choose a platform',
                'required' => false

            ))

            ->add('work_type', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))

            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

    }

}