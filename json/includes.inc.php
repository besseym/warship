<?php

//ship models
require REAL_BASE . "includes/model/ships/m_battleship.inc.php";
require REAL_BASE . "includes/model/ships/m_crusier.inc.php";
require REAL_BASE . "includes/model/ships/m_frigate.inc.php";
require REAL_BASE . "includes/model/ships/m_minesweeper.inc.php";

//include models
require REAL_BASE . "includes/model/m_position.inc.php";
require REAL_BASE . "includes/model/m_dimension.inc.php";
require REAL_BASE . "includes/model/m_player.inc.php";
require REAL_BASE . "includes/model/m_board.inc.php";
require REAL_BASE . "includes/model/m_battle.inc.php";

require REAL_BASE . "includes/model/m_battle_ai_basic.inc.php";
require REAL_BASE . "includes/model/m_battle_ai_advanced.inc.php";

//include utils
require REAL_BASE . "includes/util/util_security.inc.php";
require REAL_BASE . "includes/util/util_battle.inc.php";
require REAL_BASE . "includes/util/util_json.inc.php";

require REAL_BASE . "json/msg_result.inc.php";
require REAL_BASE . "json/msg_attack_result.inc.php";

?>