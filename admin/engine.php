<?php
include("config.php");

if(isset($_POST['bets']) && isset($_POST['amount']) && isset($_POST['possibleWin'])) {
	$bets = json_decode($_POST['bets']);
	$amount = $_POST['amount'];
	$possibleWin = $_POST['possibleWin'];
	print_r($possibleWin);

	$user_id = Session::get("user_session");

	$content = array();
	$obj = new Ticket();
	
	foreach ($bets as $bet) {
		$match = OddData::getById($bet->odd_id);
		$myticket = new Ticket();
		$json = new Ticket();
		$ticket = array();
		
		if ($bet->odabrano == $match->home_team_odd) {
			$myticket->home_odd = $bet->odabrano;
		} else if ($bet->odabrano == $match->away_team_odd) {
			$myticket->away_odd = $bet->odabrano;
			}
			else {
				$myticket->x_odd = $bet->odabrano;
			}
		
		$myticket->home_team = $bet->home;
		$myticket->away_team = $bet->away;
		$myticket->start_time = $bet->start_time;
		$myticket->start_date = $bet->start_date;
		$myticket->type = $bet->type;
		

		$content[] = $myticket;
		
	}

	$json = json_encode($content);

	$ticket['user_id'] = $user_id;
	$ticket['bet'] = $json;

	$user = Session::get('user_session');
	$balance = User::getById($user);

	if ($balance->balance >= $amount) {
		$obj->user_id = $user_id;
		$obj->bet = $json;
		$obj->amount = $amount;
		$obj->possible_win = $possibleWin;

		$obj->insert();

		$balance->balance -= $amount;
		$balance->save();



	} 
	
}
