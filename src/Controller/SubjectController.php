<?php


namespace App\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Subject;
use App\Entity\Work;
use App\Form\NewClientType;
use App\Form\NewSubjectType;
use App\Form\EditSubjectType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubjectController extends Controller{
    /**
     * @Route("/subjects", name="subject_list")
     * @Method("GET")
     */
    public function index()
    {

        $subjects = $this->getDoctrine()->getRepository(Subject::class)->findAll();

        //return new Response('<html><body>Hello World</body></html>');
        return $this->render('subjects/index.html.twig', array(
            'subjects' => $subjects
        ));

    }



    /**
     * @Route("/subject/new", name="new_subject")
     * @Method({"GET", "POST"})
     */
    public function newSubject(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm(NewSubjectType::class, $subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $subject = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subject_list');
        }

        return $this->render('subjects/new.html.twig', array(
                'form' => $form->createView())
        );

    }

    /**
     * @Route("/subject/edit/{id}", name="edit_subject")
     * @Method({"GET", "POST"})
     */
    public function editSubject(Request $request, Subject $subject)
    {

        $form = $this->createForm(EditSubjectType::class, $subject);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirectToRoute('subject_list');
        }

        return $this->render('subjects/edit.html.twig', array(
                'form' => $form->createView())
        );

    }

    /**
     * @Route("/work/subject/{id}", name="work_subs")
     * @Method({"GET", "POST"})
     */
    public function WorkSubject(Subject $subject, $id)
    {

        $works = $this->getDoctrine()->getRepository(Subject::class)->workSubject($id);
        //$works = $this->getDoctrine()->getRepository(Work::class)->findBy(array('subjects' => $subject));

        return $this->render('works/subject.html.twig', array(
            'subject' => $subject,
            'works' => $works
        ));


    }



    /**
     * @Route("/subject/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, Subject $subject)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($subject);
        $em->flush();

        $response = new Response();
        $response->send();

    }



}