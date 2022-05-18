<?php


namespace App\libraries\Gateway\Builders;


use App\libraries\Gateway\Abstracts\BuilderAbstracts;
use stdClass;

class CustomerBuilder extends BuilderAbstracts
{

	protected function reset($params = [])
	{
		$this->data = new stdClass();
		if (!array_key_exists('id', $params)) {
			$this->data->id = "cu_" . $this->get_hash();
		} else {
//			var_dump($params['id']);
//			die();
			$this->data->id = $params['id'];
		}

		$this->data->object = "customer";
	}

	protected function setCustomerId($params)
	{
		$this->data->id = $params['id'];
	}

	protected function setFirstName($f_name): CustomerBuilder
	{
		$this->data->f_name = $f_name;
		return $this;
	}

	protected function setLastName($l_name): CustomerBuilder
	{
		$this->data->l_name = $l_name;
		return $this;
	}

	protected function setEmail($email): CustomerBuilder
	{
		$this->data->email = $email;
		return $this;
	}

	protected function setPhone($phone): CustomerBuilder
	{
		$this->data->phone = $phone;
		return $this;
	}

	protected function setAdd1($add1): CustomerBuilder
	{
		$this->data->add1 = $add1;
		return $this;
	}

	protected function setAdd2($add2): CustomerBuilder
	{
		$this->data->add2 = $add2;
		return $this;
	}

	protected function setCity($city): CustomerBuilder
	{
		$this->data->city = $city;
		return $this;
	}

	protected function setState($state): CustomerBuilder
	{
		$this->data->state = $state;
		return $this;
	}

	protected function setCountry($country): CustomerBuilder
	{
		$this->data->country = $country;
		return $this;
	}

	protected function setZip($zip): CustomerBuilder
	{
		$this->data->zip = $zip;
		return $this;
	}

	protected function setSource($params = []): CustomerBuilder
	{
		if (array_key_exists('source', $params)) {
			$this->data->source = $params['source'];
		} else {
			$this->data->source = "cash_" . $this->get_hash();
		}

		if (array_key_exists('id', $params)) {
			$this->data->id = $params['id'];
		}

		return $this;
	}

	protected function setDelivery(DeliveryBuilder $delivery, $params)
	{
		if (array_key_exists('delivery', $params) && count($params['delivery'])) {
			$params['delivery'] += ['customer_id' => $this->data->id];
			$delivery->set($params['delivery']);
			$this->data->shipping = (object)[
				'address' => $delivery->get()
			];
		} else {
			$this->data->shipping = [
				'address' => []
			];
		}
	}

	public function get(): stdClass
	{
		return $this->data;
	}

	public function set(array $params)
	{
		$this->reset();
		$this->setSource($params)
			->setFirstName($params['f_name'])
			->setLastName($params['l_name'])
			->setEmail($params['email'])
			->setPhone($params['phone'])
			->setAdd1($params['add1'])
			->setAdd2($params['add2'])
			->setCity($params['city'])
			->setState($params['state'])
			->setCountry($params['country'])
			->setZip($params['zip'])
			->setDelivery(new DeliveryBuilder(), $params);
	}
}
