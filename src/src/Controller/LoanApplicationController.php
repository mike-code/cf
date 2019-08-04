<?php
namespace App\Controller;

use App\Dto\LoanDto;
use App\SaveLoanRequest;
use App\Service\LoanApplicationHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanApplicationController extends AbstractController
{
	private $service;

	public function __construct(LoanApplicationHandler $service)
	{
		$this->service = $service;
	}

	public function index()
	{
		return $this->render('apply.html.twig');
	}

	public function store(Request $request)
	{
		$dto = LoanDto::fromRequest($request);
		$this->service->save($dto);

		return new Response(null, 201);
	}
}
