<?php


namespace App\Controller;

use App\Entity\Client;
use App\Entity\Format;
use App\Entity\Type;
use App\Entity\Platform;
//use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

class ProjectController extends Controller{
    /**
     * @Route("/", name="work_list")
     * @Method("GET")
     */
    public function index()
    {

        $works = $this->getDoctrine()->getRepository(Work::class)->findAll();

            //return new Response('<html><body>Hello World</body></html>');
        return $this->render('works/index.html.twig', array(
            'works' => $works
        ));

    }



    /**
     * @Route("/work/new", name="new_work")
     * @Method({"GET", "POST"})
     */
    public function newWork(Request $request)
    {
        $work = new Work();

        $form = $this->createFormBuilder($work)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_id', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'class' => Client::class,
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
            ->add('pub_url', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))
            ->add('priv_url', TextType::class, array('attr' => array('class' => 'form-control'), 'required' => false))

//            ->add('ghost_ind', ChoiceType::class, array(
//                    'attr' => array('class' => 'form-control'),
//                    'choices' => ['Yes' => true, 'No' => false],
//                    'label' => 'Ghosted'
//                )
//
//            )

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
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $work = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($work);
            $em->flush();

            return $this->redirectToRoute('work_list');
        }

        return $this->render('works/new.html.twig', array(
            'form' => $form->createView())
        );

    }

    /**
     * @Route("/work/edit/{id}", name="edit_work")
     * @Method({"GET", "POST"})
     */
    public function editWork(Request $request, $id)
    {
        $work = new Work();
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);

        $form = $this->createFormBuilder($work)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_id', EntityType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'class' => Client::class,
                    'label' => 'Client'

                )

            )
            ->add('description', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('work_list');
        }

        return $this->render('works/edit.html.twig', array(
                'form' => $form->createView())
        );

    }



    /**
     * @Route("/work/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($work);
        $em->flush();

        $response = new Response();
        $response->send();

    }

    /**
     * @Route("/work/{id}", name="work_detail")
     */
    public function workDetail($id)
    {
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);
        $client_id = $work->getClientId();
        $client = $this->getDoctrine()->getRepository(Client::class)->findOneBy(array('id'=> $client_id));

        return $this->render('works/detail.html.twig', array(
            'work' => $work,
            'client' => $client
        ));

    }


//    /**
//     * @Route("/work/save")
//     * @Method("GET")
//     */
//
//    public function save()
//    {
//        $em = $this->getDoctrine()->getManager();
//        $work = new Work();
//        $work->setTitle('article 2');
//        $work->setDescription('This is the second article');
//
//        $em->persist($work);
//        $em->flush();
//
//        return new Response('saved article with the id of'. $work->getId());
//    }
}