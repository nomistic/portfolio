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
        $wips = $this->getDoctrine()->getRepository(Work::class)->workInProgress();
        $jobs = $this->getDoctrine()->getRepository(Work::class)->MostJobsByClient();
        $earnings = $this->getDoctrine()->getRepository(Work::class)->monthlyEarnings();
        $user = $this->getUser();

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

        $monthly = [];
        $monthly_sum = [];
        foreach ($earnings as $earn) {
            $month = $earn['month_year'];
            $pay   = $earn['pay'];
            array_push($monthly, $month);
            array_push($monthly_sum, $pay);
        }



        //return new Response('<html><body>Hello World</body></html>');
        return $this->render('index.html.twig', array(
            'works' => $works,
            'wips'  => $wips,
            'clientss' => $clients,
            'amounts' => $amounts,
            'j_clients' => $j_clients,
            'j_jobs' => $j_jobs,
            'monthly' => $monthly,
            'monthly_sum' => $monthly_sum,
            'user' => $user
        ));

    }

    /**
     * @Route("/reports", name="reports")
     * @Method("GET")
     */
    public function showWorkTotal()
    {
        $works = $this->getDoctrine()->getRepository(Work::class)->totalByClient();
        $types = $this->getDoctrine()->getRepository(Work::class)->totalWritingByType();
        $totals = $this->getDoctrine()->getRepository(Work::class)->totalCounts();
        $annuals = $this->getDoctrine()->getRepository(Work::class)->annualEarnings();
        $last12 = $this->getDoctrine()->getRepository(Work::class)->last12();
        $prev12 = $this->getDoctrine()->getRepository(Work::class)->prev12();
        $recentClients = $this->getDoctrine()->getRepository(Client::class)->recentClients();

        $yearly = [];
        $yearly_sum = [];
        foreach ($annuals as $annual) {
            $year = $annual['year_sub'];
            $year_sum = $annual['pay'];
            array_push($yearly, $year);
            array_push($yearly_sum, $year_sum);
        }

        $type_list = [];
        $type_count = [];
        foreach ($types as $type) {
            $type_group = $type['name'];
            $type_sum = $type['total'];
            array_push($type_list, $type_group);
            array_push($type_count, $type_sum);
        }

        $monthly12 = [];
        $monthly12_sum = [];
        foreach ($last12 as $earn) {
            $month = $earn['month_year'];
            $pay   = $earn['pay'];
            array_push($monthly12, $month);
            array_push($monthly12_sum, $pay);
        }

        $p_monthly12 = [];
        $p_sum = [];
        foreach ($prev12 as $prev) {
            $month = $prev['month_year'];
            $pay = $prev['pay'];
            array_push($p_monthly12, $month);
            array_push($p_sum, $pay);
        }

        return $this->render('reports/index.html.twig', array(
            'works' => $works,
            'totals' => $totals,
            'annuals' => $annuals,
            'yearly' => $yearly,
            'yearly_sum' => $yearly_sum,
            'last12' => $last12,
            'monthly12' => $monthly12,
            'monthly12_sum' => $monthly12_sum,
            'p_monthly12' => $p_monthly12,
            'p_sum' => $p_sum,
            'recent_clients' => $recentClients,
            'types' => $types,
            'type_list' => $type_list,
            'type_count' => $type_count
        ));


    }




}