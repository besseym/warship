<?php

require_once REAL_BASE . "includes/model/m_position.inc.php";

require_once REAL_BASE . "includes/model/ships/m_battleship.inc.php";
require_once REAL_BASE . "includes/model/ships/m_crusier.inc.php";
require_once REAL_BASE . "includes/model/ships/m_frigate.inc.php";
require_once REAL_BASE . "includes/model/ships/m_minesweeper.inc.php";

class Board {

	public $player_id;
	public $dimension;
	public $ship_array;
	
	public $tile_array;
	
	public $do_draw_ships;
	public $has_removeable_ships;
	
	public function __construct($player_id, $dimension){
	
		$this->player_id = $player_id;
		$this->dimension = $dimension;
		
		$this->ship_array = array(10);
		$this->ship_array[0] = new Battleship;
		$this->ship_array[1] = new Crusier;
		$this->ship_array[2] = new Crusier;
		$this->ship_array[3] = new Frigate;
		$this->ship_array[4] = new Frigate;
		$this->ship_array[5] = new Frigate;
		$this->ship_array[6] = new Minesweeper;
		$this->ship_array[7] = new Minesweeper;
		$this->ship_array[8] = new Minesweeper;
		$this->ship_array[9] = new Minesweeper;
		
		$width = $dimension->width;
		$height = $dimension->height;
		
		$this->tile_array = array($width);
		for ($x = 0; $x < $width; $x++) {
			
			$this->tile_array[$x] = array($height);
			for ($y = 0; $y < $height; $y++) {
				$this->tile_array[$x][$y] = TILE_BLANK;
			}
		}
		
		$this->do_draw_ships = true;
		$this->has_removeable_ships = true;
	}
	
	public function random_init(){
		
		$rand_x = 0;
		$rand_y = 0;
		$position = null;
		$orientation = null;
		
		foreach($this->ship_array as $ship){
		
			while($ship->position == null){
				
				$rand_x = rand(0, $this->dimension->width);
				$rand_y = rand(0, $this->dimension->height);
				$position = new Position($rand_x, $rand_y);
				
				$orientation = rand(0, 1);
				
				if($this->is_within_board($position, $ship->size, $orientation)){
					if(!$this->check_ship_intersect($position, $ship->size, $orientation)){
						$ship->set_position($position, $orientation);
					}
				}
			}
		}
	}
	
	public function mark_tile($position, $state){
		$this->tile_array[$position->x][$position->y] = $state;
	}
	
	public function is_within_board($start_position, $size, $orientation){
		
		$is_within_board = false;
		
		$x = $start_position->x;
		$y = $start_position->y;
		
		$width = $this->dimension->width;
		$height = $this->dimension->height;
		
		if($orientation == SHIP_ORIENTATION_HORIZONTAL){
			
			$x_size = $x + $size;
			$is_within_board = (($x_size < $width) && $y < $height);
		}
		else {
			
			$y_size = $y + $size;
			$is_within_board = (($y_size < $height) && $x < $width);
		}
		
		return $is_within_board;
	}
	
	public function check_ship_hit($position, $do_set_hit = false){
	
		$is_ship_hit = false;
	
		foreach($this->ship_array as $ship){
			if($ship->check_hit($position, $do_set_hit)){
				$is_ship_hit = true;
				break;
			}
		}
		
		return $is_ship_hit;
	}
	
	public function check_ship_intersect($start_position, $size, $orientation, $do_set_hit = false){
	
		$has_ship_intersect = false;
		
		$x = $start_position->x;
		$y = $start_position->y;
		
		foreach($this->ship_array as $ship){
		
			if($orientation == SHIP_ORIENTATION_HORIZONTAL){
				
				$x_size = $x + $size;
				for($i = $x; $i < $x_size; $i++) {
				
					$has_ship_intersect = ($ship->check_hit(new Position($i, $y), $do_set_hit)) || $has_ship_intersect;
				}
			}
			else {
				
				$y_size = $y + $size;
				for($i = $y; $i < $y_size; $i++) {
				
					$has_ship_intersect = ($ship->check_hit(new Position($x, $i), $do_set_hit)) || $has_ship_intersect;
				}
			}
		}
		
		return $has_ship_intersect;
	}
	
	public function has_floating_ship(){
	
		$has_floating_ship = false;
		
		foreach($this->ship_array as $ship){
			$has_floating_ship = (($ship->is_floating()) || $has_floating_ship);
		}
		
		return $has_floating_ship;
	}
	
	public function get_floating_ship_count($ship_type){
	
		$ship_count = 0;
		
		foreach($this->ship_array as $ship){
			if($ship->type == $ship_type && $ship->is_floating()){
				$ship_count++;
			}
		}
		
		return $ship_count;
	}
	
	public function get_score(){
	
		$hit_total = 0;
		$miss_total = 0;
	
		$width = $this->dimension->width;
		$height = $this->dimension->height;
		
		$tile = 0;
		for ($x = 0; $x < $width; $x++) {
			for ($y = 0; $y < $height; $y++) {
			
				$tile_value = $this->tile_array[$x][$y];
				switch($tile_value){
					case TILE_HIT:
						$hit_total++;
						break;
					case TILE_MISS:
						$miss_total++;
						break;
				}
			}
		}
		
		return ($hit_total / $miss_total);
	}
	
	public function position_ship($ship_id, $position, $orientation){
		$this->ship_array[$ship_id]->set_position($position, $orientation);
	}
	
	public function get_width(){
		return $this->dimension->width;
	}
	
	public function get_height(){
		return $this->dimension->height;
	}
	
	public function __toString(){
		return '[' . $this->dimension->width . ' ' . $this->dimension->height . ']';
	}
}

?>