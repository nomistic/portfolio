<?php


namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use App\Form\NewClientType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientController extends Controller{
    /**
     * @Route("/clients", name="client_list")
     * @Method("GET")
     */
    public function index()
    {

        $clients = $this->getDoctrine()->getRepository(Client::class)->findAll();

        //return new Response('<html><body>Hello World</body></html>');
        return $this->render('clients/index.html.twig', array(
            'clients' => $clients
        ));

    }



    /**
     * @Route("/clients/new", name="new_client")
     * @Method({"GET", "POST"})
     */
    public function newClient(Request $request)
    {
        $client = new Client();
        $form = $this->createForm(NewClientType::class, $client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('client_list');
        }

        return $this->render('clients/new.html.twig', array(
                'form' => $form->createView())
        );

    }

    /**
     * @Route("/client/edit/{id}", name="edit_client")
     * @Method({"GET", "POST"})
     */
    public function editClient(Request $request, $id)
    {
        $client = new Client();
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        $form = $this->createForm(NewClientType::class, $client);
        $form = $this->createFormBuilder($client)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_last', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('client_first', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('parent', EntityType::class, array(
                'attr' => array('class' => 'form-control'),
                'required' => false,
                'class' => Client::class
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

            return $this->redirectToRoute('client_list');
        }

        return $this->render('clients/edit.html.twig', array(
                'form' => $form->createView())
        );

    }



    /**
     * @Route("/client/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();

        $response = new Response();
        $response->send();

    }

    /**
     * @Route("/client/{id}", name="client_detail")
     */
    public function clientDetail($id)
    {
        $client = $this->getDoctrine()->getRepository(Client::class)->find($id);
        
        $parents = $this->getDoctrine()->getRepository(Client::class)->findBy(array('parent' => $id));

        return $this->render('clients/detail.html.twig', array(
            'client' => $client,
            'parents' => $parents
        ));

    }


}