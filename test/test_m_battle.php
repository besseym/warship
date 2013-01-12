<?php

require "../includes/constants.inc.php";

require REAL_BASE . "includes/model/m_battle_ai.inc.php";

$dimension = new Dimension(8,8);
//echo $dimension;


$opponent = new Player;
$opponent->id = 2;
$opponent->name = 'Computer';

$battle = new Battle(1, $opponent, $dimension);
//echo $battle->player1_id;
echo $battle->opponent->id;

$board = $battle->get_board(2);
var_dump($board);

/*
$battle = new BattleAi(0, $dimension);

echo $battle->$player1_id;
echo $battle->opponent->name;
*/

?>