<?php

class Authentication {
	private $secret;

	function __construct($secret) {
		$this->secret = $secret;
	}

	function encode($data) {
		$session = Array();

		$session['data'] = json_encode($data);
		$session['signature'] = hash_hmac('sha256', $session['data'], $this->secret);

		return $session;
	}

	function verify($session) {
		$data = $session['data'];
		$prev_signature = $session['signature'];

		$curr_signature = hash_hmac('sha256', $data, $this->secret);
		if ($prev_signature == $curr_signature) return true;
		return false;
	}
}

?>