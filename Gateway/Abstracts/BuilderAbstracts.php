<?php


namespace App\libraries\Gateway\Abstracts;

use App\libraries\Gateway\Builders\FeesBuilder;
use App\libraries\Gateway\Builders\OrderMetaBuilder;
use App\libraries\Gateway\Builders\RefundBuilder;
use DateTime;
use Generator;
use Ramsey\Uuid\Uuid;

abstract class BuilderAbstracts
{
	protected \stdClass $data;

	public function get_hash(): string
	{
		return Uuid::uuid4();
	}

	abstract protected function reset();

	abstract public function get();

	abstract public function set(array $params);

	/**
	 * @param mixed $metadata
	 * @return $this
	 */
	protected function setMetadata($metadata): BuilderAbstracts
	{
		$this->data->metadata = $metadata;
		return $this;
	}

//	protected function template_metadata_generator(array $params) : Generator
//	{
//		yield([
//
//		]);
//	}

	protected function cash_lines_generator(array $arr): Generator
	{
		yield ([
			$arr['id'] ?: null,
			$arr['desc'] ?: $arr['metadata']['name'],
			$arr['invoice'],
			$arr['metadata'],
			$arr['units'] ?: $arr['metadata']['units'],
			$arr['amount'] ?: $arr['unit_amount'],
			$arr['customer']
		]);
	}

	protected function cash_refund_generator(array $arr): Generator
	{
		yield ([
			"amount" => $arr['amount'],
			"charge" => $arr['charge'],
			"metadata" => $arr['metadata'],
			"reason" => $arr['reason'],
			"status" => $arr['status']
		]);
	}

	/**
	 * @throws \Exception
	 */
	protected function format_time(string $time): string
	{
		preg_match("/[^APM]+/", $time, $match);
		return (new DateTime(trim($match[0])))->format('g:ia');
	}

	public function cash_lines_iterator_generator($lines, $builder, $invoice_id = null)
	{
		return array_reduce($lines, function ($memo, $val) use ($builder, $invoice_id) {
			foreach ($this->cash_lines_generator($val) as $line) {
				$line[2] = $invoice_id;
				$line_fmt = array_combine(['id', 'desc', 'invoice', 'metadata', 'units', 'amount', 'customer'], $line);
				$line_fmt += ['type' => 'invoice'];
				$builder->set($line_fmt);
				$memo[] = $builder->jsonSerialize();
			}
			return $memo;
		}, []);
	}

	public function refund_iterator_generator($refund, RefundBuilder $builder)
	{
		return array_reduce($refund, function ($memo, $val) use ($builder) {
			foreach ($this->cash_refund_generator($val) as $refund) {
				$builder->set($refund);
				$memo[] = $builder->jsonSerialize();
			}
			return $memo;
		}, []);
	}

	protected function format_unit_amount($param, $string = false)
	{
		if (is_array($param)) {
			return (int)round(number_format(array_sum($param), '2', '.', ''), 2, PHP_ROUND_HALF_DOWN);
		}
		if ($string) {
			return number_format(($param / 100), '2', '.', '');
		}
		return (int)round(number_format($param, '2', '.', ''), 2, PHP_ROUND_HALF_DOWN);
	}

	protected function get_created_at()
	{
		return strtotime('now');
	}


}
