<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use DateTime;
use stdClass;

class InvoiceBuilder extends BuilderAbstracts implements \JsonSerializable
{

	protected function reset()
	{
		$this->data = new stdClass();
		$this->data->id = "in_" . $this->get_hash();
		$this->data->object = "invoice";
	}

	protected function setCountry(): InvoiceBuilder
	{
		$this->data->account_country = "US";
		return $this;
	}

	protected function setAccountName(): InvoiceBuilder
	{
		$CI = &get_instance();
		$setting = $CI->Rntr->get_settings();
		$this->data->account_name = $setting[0]['_Headingtitle'];
		return $this;
	}

	protected function setReason(string $reason): InvoiceBuilder
	{
		$this->data->reason = $reason;
		return $this;
	}

	protected function setCharge(): InvoiceBuilder
	{
		$this->data->charge = "ch_" . $this->get_hash();
		return $this;
	}

	protected function setCustomerAddress(array $params): InvoiceBuilder
	{
		$this->data->customer_address = [
			"city" => $params['city'],
			"country" => $params['country'],
			"line1" => $params['add1'],
			"line2" => $params['add2'],
			"postal_code" => $params['zip'],
			"state" => $params['state']
		];
		return $this;
	}

	protected function setCustomerName(string $name): InvoiceBuilder
	{
		$this->data->customer_name = $name;
		return $this;
	}

	protected function setCustomerEmail(string $email): InvoiceBuilder
	{
		$this->data->customer_email = $email;
		return $this;
	}

	protected function setCustomerPhone(string $phone): InvoiceBuilder
	{
		$this->data->customer_phone = $phone;
		return $this;
	}

	protected function setLines(LinesBuilder $builder, $lines): InvoiceBuilder
	{
		$lines_arr = $this->cash_lines_iterator_generator($lines, $builder, $this->data->id);
		$this->data->lines = (object)[
			'object' => 'lines',
			'data' => $lines_arr
		];
		return $this;
	}

	protected function setCustomer(string $customer_id): InvoiceBuilder
	{
		$this->data->customer = $customer_id;
		return $this;
	}

	protected function setStatus(?string $status_inp = null): InvoiceBuilder
	{
		if ($this->data->total > 0) {
			$status = "paid";
		} else {
			$status = "unpaid";
		}
		$this->data->status = $status;
		if (!empty($status_inp)) {
			$this->data->status = $status_inp;
		}
		return $this;
	}

	protected function setSubtotal(): InvoiceBuilder
	{
		$amount_arr = array_column($this->data->lines->data, 'unit_amount');
		$this->data->sub_total = $this->format_unit_amount($amount_arr);
		return $this;
	}

	protected function setTax(): InvoiceBuilder
	{
		$ci = &get_instance();
		$percentage = $ci->Rntr->get_tax()[0]['taxpercentage'];
		$sub_total = $this->data->sub_total;
		$this->data->tax = $this->format_unit_amount(($sub_total * $percentage) / 100);
		return $this;
	}

	protected function setTaxPercentage(): InvoiceBuilder
	{
		$ci = &get_instance();
		$this->data->tax_percentage = $ci->Rntr->get_tax()[0]['taxpercentage'];;
		return $this;
	}

	protected function setTotal(): InvoiceBuilder
	{
		$sub_total = $this->data->sub_total;
		$tax = $this->data->tax;
		$this->data->total = ($sub_total + $tax);
		return $this;
	}

	protected function setCreatedAt()
	{
		$this->data->created = $this->get_created_at();
	}


	public function get()
	{
		return json_encode($this->data);
	}

	public function set(array $params): InvoiceBuilder
	{
		$this->reset();
		$this->setCountry()
			->setAccountName()
			->setLines(new LinesBuilder(), $params['lines'])
			->setCustomer($params['customer']['id'])
			->setCustomerAddress($params['customer'])
			->setCustomerName("{$params['customer']['f_name']} {$params['customer']['l_name']}")
			->setCustomerEmail($params['customer']['email'])
			->setCustomerPhone($params['customer']['phone'])
			->setReason($params['reason'] ?: "")
			->setSubtotal()
			->setTax()
			->setTaxPercentage()
			->setTotal()
			->setStatus(@$params['status'])
			->setCharge()
			->setCreatedAt();
		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		return $this->data;
	}
}
