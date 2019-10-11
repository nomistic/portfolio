<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\NewStageType;
use App\Form\EditStageType;
use App\Form\EditWorkType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Work;
use App\Entity\Stage;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\DateTime;

class StageController extends Controller {

    /**
     * @Route("/stages/{id}", name="project_stages")
     * @Method("GET")
     */
    public function index($id)
    {
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);

        $stages = $this->getDoctrine()->getRepository(Stage::class)->findBy(array('work_id'=>$id));

        return $this->render('works/stages.html.twig', array(
            'stages' => $stages,
            'work' => $work
        ));

    }

    /**
     * @Route("/stage/new/{id}", name="new_stage")
     * @Method({"GET", "POST"})
     */
    public function newStage(Request $request, $id)
    {
        $stage = new Stage();
        $form = $this->createForm(NewStageType::class, $stage);
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $stage = $form->getData();
            $stage->setWorkId($work);
            $stage->setDateCreated(new \DateTime());
            $stage->setLastUpdated(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('works/new_stage.html.twig', array(
                'work' => $work,
                'form' => $form->createView())
        );

    }


    /**
     * @Route("/stage/edit/{id}", name="edit_stage")
     * @Method({"GET", "POST"})
     */
    public function editStage(Request $request, $id)
    {
        //$work = new Work();
        //$work = $this->getDoctrine()->getRepository(Work::class)->find($id);
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        $work_id = $stage->getWorkId();
        $work = $this->getDoctrine()->getRepository(Work::class)->findOneBy(array('id' =>$work_id ));


        $form = $this->createForm(EditStageType::class, $stage);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $stage->setLastUpdated(new \DateTime());
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('project_stages', array('id' => $work->getId()) );
        }

        return $this->render('works/edit_stage.html.twig', array(
            'work' => $work,
            'form' => $form->createView())
        );

    }

    /**
     * @Route("/stage/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id)
    {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($stage);
        $em->flush();

        $response = new Response();
        $response->send();

    }

    /**
     * @Route("/work/submit_date/{id}", name="mark_complete")
     * @Method({"GET"})
     */
    public function markComplete($id){
        $work = $this->getDoctrine()->getRepository(Work::class)->find($id);
        $work->setDateSubmitted(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($work);
        $em->flush();

        return $this->redirectToRoute('dashboard');

    }

}