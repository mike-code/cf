<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\Request;

class LoanDto
{
	/**
	 * @var string
	 */
	private $first_name;

	/**
	 * @var string
	 */
	private $last_name;

	/**
	 * @var string
	 */
	private $street;

	/**
	 * @var int
	 */
	private $zip;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var float
	 */
	private $amount;

	/**
	 * @var int
	 */
	private $term;

	public static function fromRequest(Request $request)
	{
		$dto = new self;

		$dto->setFirstName($request->get('firstName'));
		$dto->setLastName($request->get('lastName'));
		$dto->setStreet($request->get('street'));
		$dto->setZipCode($request->get('zipCode'));
		$dto->setCity($request->get('city'));
		$dto->setLoanAmount($request->get('loanAmount'));
		$dto->setLoanTerm($request->get('loanTerm'));

		return $dto;
	}

	public function toArray(): array
	{
		return [
			'first_name' => $this->getFirstName(),
			'last_name'  => $this->getLastName(),
			'street'     => $this->getStreet(),
			'zip'        => $this->getZipCode(),
			'city'       => $this->getCity(),
			'amount'     => $this->getLoanAmount(),
			'term'       => $this->getLoanTerm(),
		];
	}

	public function getFirstName(): string
	{
		return $this->first_name;
	}

	public function getLastName(): string
	{
		return $this->last_name;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function getZipCode(): int
	{
		return $this->zip;
	}

	public function getCity(): string
	{
		return $this->city;
	}

	public function getLoanAmount(): float
	{
		return $this->amount;
	}

	public function getLoanTerm(): int
	{
		return $this->term;
	}

	public function setFirstName(string $first_name)
	{
		$this->first_name = $first_name;

		return $this;
	}

	public function setLastName(string $last_name)
	{
		$this->last_name = $last_name;

		return $this;
	}

	public function setStreet(string $street)
	{
		$this->street = $street;

		return $this;
	}

	public function setZipCode(int $zip)
	{
		$this->zip = $zip;

		return $this;
	}

	public function setCity(string $city)
	{
		$this->city = $city;

		return $this;
	}

	public function setLoanAmount(float $amount)
	{
		$this->amount = $amount;

		return $this;
	}

	public function setLoanTerm(int $term)
	{
		$this->term = $term;

		return $this;
	}
}









