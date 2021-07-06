<?php

class Authentication {
	private $secret;

	function __construct($secret) {
		$this->secret = $secret;
	}

	function encode($session_data) {
		$session = Array();

		$session['session'] = json_encode($session_data);
		$session['signature'] = hash_hmac('sha256', $session['session'], $this->secret);

		return $session;
	}

	function verify($session) {
		$session_data = $session['session'];
		$prev_signature = $session['signature'];

		$curr_signature = hash_hmac('sha256', $session_data, $this->secret);
		if ($prev_signature == $curr_signature) {
			if (isset($session['session']['expiry'])) {
				if ($session['session']['expiry'] > time()) return false;
			}
			return true;
		} 
		return false;
	}
}

?>