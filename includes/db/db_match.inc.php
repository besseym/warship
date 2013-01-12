<?php

require_once REAL_BASE . "includes/db/db_helper.inc.php";
require_once REAL_BASE . "includes/model/m_match.inc.php";
require_once REAL_BASE . "includes/model/m_leaderboard_record.inc.php";

//select the match with the given id
//if the match doesn't exist return NULL
function select_match($db_link, $id){
	
	$match = NULL;
	
	$select_sql = "select * from matches where id = '$id'";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
		$result = mysql_fetch_assoc($result_set);
		
		$match = new Match;
		$match->id = $result['id'];
		$match->player1_id = $result['player1_id'];
		$match->player2_id = $result['player2_id'];
		$match->player1_score = $result['player1_score'];
		$match->player2_score = $result['player2_score'];
		$match->winning_player_id = $result['winning_player_id'];
	}
	
	return $match;
}

function start_match($db_link, $match){

	$player1_id = $match->player1_id;
	$player2_id = $match->player2_id;
	
	$insert_sql = "insert into matches (player1_id, player2_id) values ('$player1_id', '$player2_id')";
	return mysql_query($insert_sql, $db_link) or die(mysql_error());
}

function complete_match($db_link, $match){
	
	$id = $match->id;
	$player1_score = $match->player1_score;
	$player2_score = $match->player2_score;
	$difficulty = $match->difficulty;
	$winning_player_id = $match->winning_player_id;
	
	$update_sql = "update matches set player1_score='$player1_score', player2_score='$player2_score', difficulty='$difficulty', winning_player_id='$winning_player_id', completed_at=now() where id='$id'";
	return mysql_query($update_sql, $db_link) or die(mysql_error());
}

function select_player_victories($db_link, $player_id){

	$victories = 0;

	$select_sql = "select count(id) victories from matches where winning_player_id = '$player_id'";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
		$result = mysql_fetch_assoc($result_set);
		
		$victories = $result['victories'];
	}
	
	return $victories;
}

function select_player_defeats($db_link, $player_id){

	$defeats = 0;

	$select_sql = "select count(id) defeats from matches where (player1_id = '$player_id' or player2_id = '$player_id') and winning_player_id != '$player_id' and winning_player_id is not null";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
		$result = mysql_fetch_assoc($result_set);
		
		$defeats = $result['defeats'];
	}
	
	return $defeats;
}

function populate_match_record($db_link, $player){

	$player->victories = select_player_victories($db_link, $player->id);
	$player->defeats = select_player_defeats($db_link, $player->id);
}

static $q_leaderboard = "select p.id, p.name, q_player_score.total_victories, q_player_score.total_defeats, q_player_score.score
from players p
inner join
(
select *, total_victories/(total_victories + total_defeats) as score
from (
select id, sum(victories) as total_victories, sum(defeats) as total_defeats 
from 
(

select p.id, count(m.id) as victories, 0 as defeats
from players p, matches m 
where p.id = m.winning_player_id

union

select p.id, 0 as victories, count(m.id) as defeats 
from players p, matches m 
where (m.player1_id = p.id or m.player2_id = p.id) 
and m.winning_player_id != p.id 
and winning_player_id is not null
group by p.id

) as q_sum group by id
) as q_score
) q_player_score
on p.id = q_player_score.id
order by q_player_score.score desc";

static $q_beginner_victories = "select p.id, count(m.id) victories, 0 defeats
	from players p, matches m 
	where p.id = m.winning_player_id
	and m.difficulty <= 0";

static $q_beginner_defeats = "select p.id, 0 victories, count(m.id) defeats 
	from players p, matches m 
	where (m.player1_id = p.id or m.player2_id = p.id) 
	and m.winning_player_id != p.id 
	and m.winning_player_id is not null
	and m.difficulty <= 0
	group by p.id";
	
static $q_advanced_victories = "select p.id, count(m.id) victories, 0 defeats
	from players p, matches m 
	where p.id = m.winning_player_id
	and m.difficulty > 0";

static $q_advanced_defeats = "select p.id, 0 victories, count(m.id) defeats 
	from players p, matches m 
	where (m.player1_id = p.id or m.player2_id = p.id) 
	and m.winning_player_id != p.id 
	and m.winning_player_id is not null
	and m.difficulty > 0
	group by p.id";

static $q_leaderboard_start = "select p.id, p.name, q_player_score.total_victories, q_player_score.total_defeats, q_player_score.score
from players p
inner join
(
select *, total_victories/(total_victories + total_defeats) as score
from (
select id, sum(victories) as total_victories, sum(defeats) as total_defeats 
from 
(";

static $q_leaderboard_end = ") as q_sum group by id
) as q_score
) q_player_score
on p.id = q_player_score.id
order by q_player_score.score desc";

$q_beginning_leaderboard = $q_leaderboard_start . $q_beginner_victories . " union " . $q_beginner_defeats . $q_leaderboard_end;

$q_advanced_leaderboard = $q_leaderboard_start . $q_advanced_victories . " union " . $q_advanced_defeats . $q_leaderboard_end;

function select_beginner_leaderboard($db_link){

	global $q_beginning_leaderboard;
	return select_leaderboard($db_link, $q_beginning_leaderboard);
}

function select_advanced_leaderboard($db_link){

	global $q_advanced_leaderboard;
	return select_leaderboard($db_link, $q_advanced_leaderboard);
}

function select_leaderboard($db_link, $select_sql){

	$leaderboard_record_array = array();
	
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
	
		$leaderboard_record = null;
		while($db_result = mysql_fetch_assoc($result_set)){
		
			$leaderboard_record = new LeaderboardRecord;
			$leaderboard_record->populate($db_result);
			$leaderboard_record_array[] = $leaderboard_record;
		}
	}
	
	return $leaderboard_record_array;
}

?>