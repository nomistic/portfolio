<?php


namespace App\Controller;

use App\Entity\Client;
use App\Repository\WorkRepository;
use App\Form\NewWorkType;
use App\Form\EditWorkType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Work;


class DashboardController extends Controller{
    /**
     * @Route("/", name="dashboard")
     * @Method("GET")
     */
    public function index()
    {

        $works = $this->getDoctrine()->getRepository(Work::class)->findAll();

        //return new Response('<html><body>Hello World</body></html>');
        return $this->render('index.html.twig', array(
            'works' => $works
        ));

    }

    /**
     * @Route("/reports", name="reports")
     * @Method("GET")
     */
    public function showWorkTotal()
    {
        $works = $this->getDoctrine()->getRepository(Work::class)->totalByClient();

        return $this->render('reports/index.html.twig', array(
            'works' => $works
        ));


    }




}