<?php
	class Property {
		private $property_id;
		private $no_bed;
		private $no_bath;
		private $no_car;
		private $no_study;
		private $address;
		private $price_low;
		private $price_high;
		private $agency_id;
		private $agent_id;

		public function __construct ($data = null) {
			if (is_array ($data)) {
			if (isset ($data['property_id']))
				$this->property_id = $data['property_id'];
			
			$this->no_bed = $data['no_bed'];
			$this->no_bath = $data['no_bath'];
			$this->no_car = $data['no_car'];
			$this->no_study = $data['no_study'];
			$this->address = $data['address'];
			$this->price_low = $data['price_low'];
			$this->price_high = $data['price_high'];
			$this->agency_id = $data['agency_id'];
			$this->agent_id = $data['agent_id'];
		}

		public function set_id ($id) {
			$this->property_id = $id;
		}

		public function get_id() {
			return $this->property_id;
		}

		public function set_no_bed ($no_bed) {
			$this->no_bed = $no_bed;
		}

		public function get_no_bed() {
			return $this->no_bed;
		}

		public function set_no_bath ($no_bath) {
			$this->no_bath = $no_bath;
		}

		public function get_no_bath() {
			return $this->no_bath;
		}

		public function set_no_car ($no_car) {
			$this->no_car = $no_car;
		}

		public function get_no_car() {
			return $this->no_car;
		}

		public function set_no_study ($no_study) {
			$this->no_study = $no_study;
		}

		public function get_no_study() {
			return $this->no_study;
		}

		public function set_address ($address) {
			$this->address = $address;
		}

		public function get_address() {
			return $this->address;
		}

		public function set_price_low ($price_low) {
			$this->price_low = $price_low;
		}

		public function get_price_low() {
			return $this->price_low;
		}

		public function set_price_high ($price_high) {
			$this->price_high = $price_high;
		}

		public function get_price_high() {
			return $this->price_high;
		}
		
		public function set_agency ($agency) {
			$this->agency = $agency;
		}

		public function get_agency() {
			return $this->agency;
		}

		public function set_agent ($agent) {
			$this->agent = $agent;
		}

		public function get_agent() {
			return $this->agent;
		}
	}
?>