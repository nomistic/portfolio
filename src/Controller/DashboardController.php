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

       // $works = $this->getDoctrine()->getRepository(Work::class)->findAll();
        $works = $this->getDoctrine()->getRepository(Work::class)->TopTotalByClient();
        $jobs = $this->getDoctrine()->getRepository(Work::class)->MostJobsByClient();
        $clients = [];
        $amounts = [];

        foreach ($works as $work) {
            $client = $work['name'];
            $amount = $work['amount'];
            array_push($clients, $client);
            array_push($amounts, $amount);

        }

        $j_clients = [];
        $j_jobs = [];
        foreach ($jobs as $job) {

            $j_client = $job['name'];
            $j_job = $job['jobs'];
            array_push($j_jobs, $j_job);
            array_push($j_clients, $j_client);
        }



        //return new Response('<html><body>Hello World</body></html>');
        return $this->render('index.html.twig', array(
            'works' => $works,
            'clientss' => $clients,
            'amounts' => $amounts,
            'j_clients' => $j_clients,
            'j_jobs' => $j_jobs
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