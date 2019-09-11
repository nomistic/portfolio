<?php


namespace App\Controller;

use App\Entity\Client;
use App\Form\NewWorkType;
use App\Form\EditWorkType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Work;


class ProjectController extends Controller{
    /**
     * @Route("/works", name="work_list")
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
        $form = $this->createForm(NewWorkType::class, $work);

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
        //$work = new Work();
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);

        $form = $this->createForm(EditWorkType::class, $work);

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


}