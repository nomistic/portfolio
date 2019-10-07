<?php


namespace App\Controller;

use App\Entity\Client;
use App\Form\NewWorkType;
use App\Form\EditWorkType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Work;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProjectController extends Controller{
    /**
     * @Route("/works", name="work_list")
     * @Method("GET")
     */
    public function index()
    {

        $works = $this->getDoctrine()->getRepository(Work::class)->workSubmitted();

            //return new Response('<html><body>Hello World</body></html>');
        return $this->render('works/index.html.twig', array(
            'works' => $works
        ));

    }


    //API output tool

    /**
     * @Route("/output/work.json", name="json_output")
     * @Method("GET")
     */
    public function outputWork()
    {

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        $work = $this->getDoctrine()->getRepository(Work::class)->authoredWorks();

        $jsonContent = $serializer->serialize($work, 'json');

        return new Response($jsonContent, 200, ['Content-Type' => 'application/json']);

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

            return $this->redirectToRoute('work_detail', array('id' => $id) );
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