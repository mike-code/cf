<?php

namespace App\Service;

use App\Dto\LoanDto;
use Aws\S3\S3Client;
use Carbon\Carbon;
use League\Csv;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoanApplicationHandler
{
	public function __construct(S3Client $client)
	{
		$client->registerStreamWrapper();
		$this->client = $client;
	}

	public function paymentSchedule(int $offset)
	{
		$reader = Csv\Reader::createFromPath('s3:///files/loans.csv', 'r', stream_context_create(['s3' => ['seekable' => true]]));

		list($first_name, $last_name, $_, $_, $_, $total, $term) = $reader->fetchOne($offset);

		$total *= 2; // YEAH. PAY 200% BACK

		$schedule  = [];
		$amounts   = array_fill(0, $term - 1, round($total/$term, 2));
		$amounts[] = round($total - array_sum($amounts), 2);
		$today     = Carbon::now();

		foreach ($amounts as $amount) {
			$schedule[] = [
				'month'  => $today->addMonths(1)->format('M Y'),
				'amount' => $amount,
			];
		}

		return [
			'name'      => "{$first_name} {$last_name}",
			'repayment' => $schedule,
			'total'     => $total,
		];
	}

	public function fetch(): array
	{
		$reader = Csv\Reader::createFromPath('s3:///files/loans.csv', 'r', stream_context_create(['s3' => ['seekable' => true]]));

		return iterator_to_array($reader->getRecords());
	}

	public function save(LoanDto $dto)
	{
		try {
			$writer = Csv\Writer::createFromPath('s3:///files/loans.csv', 'a');
			$writer->insertOne($dto->toArray());
		} catch (Csv\CannotInsertRecord $e) {
			throw new HttpException(500, sprintf('Could not save loan data %s', $e->getRecords()));
		}
	}
}
