<?php


namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Client;
use App\Entity\Work;
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
    public function editClient(Request $request, Client $client)
    {

        $form = $this->createForm(NewClientType::class, $client);

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
        $works = $this->getDoctrine()->getRepository(Work::class)->submittedWork($id);
        $wips = $this->getDoctrine()->getRepository(Work::class)->inProgressWork($id);

        $parents = $this->getDoctrine()->getRepository(Client::class)->findBy(array('parent' => $id));
        $earnings = $this->getDoctrine()->getRepository(Work::class)->clientMonthlyEarnings($id);
        $child_earnings = $this->getDoctrine()->getRepository(Work::class)->childMonthlyEarnings($id);
        $total = $this->getDoctrine()->getRepository(Work::class)->clientTotal($id);
        $child = $this->getDoctrine()->getRepository(Work::class)->childTotal($id);



        $monthly = [];
        $monthly_sum = [];

        foreach ($earnings as $earn) {
            $month = $earn['month_year'];
            $pay = $earn['pay'];
            array_push($monthly, $month);
            array_push($monthly_sum, $pay);
        }

        $child_monthly = [];
        $child_monthly_sum = [];
        foreach ($child_earnings as $child_earn) {
            $child_month = $child_earn['month_year'];
            $child_pay = $child_earn['pay'];
            array_push($child_monthly, $child_month);
            array_push($child_monthly_sum, $child_pay);
        }


        return $this->render('clients/detail.html.twig', array(
            'wips' => $wips,
            'client' => $client,
            'works' => $works,
            'parents' => $parents,
            'monthly' => $monthly,
            'monthly_sum' => $monthly_sum,
            'child_monthly' => $child_monthly,
            'child_monthly_sum' => $child_monthly_sum,
            'total'  => $total,
            'child' => $child
        ));

    }


}