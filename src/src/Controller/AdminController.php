<?php
namespace App\Controller;

use App\Service\LoanApplicationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
	private $service;

	public function __construct(LoanApplicationHandler $service)
	{
		$this->service = $service;
	}

	public function index()
	{
		return $this->render('admin.html.twig', ['loans' => $this->service->fetch()]);
	}

	public function schedule(int $id)
	{
		return new JsonResponse($this->service->paymentSchedule($id));
	}
}
