<?php

class Ship {

	public $type;
	public $size;
	public $orientation;
	public $position;
	public $hit_array;
	
	public function __construct($type, $size){
	
		$this->type = $type;
		$this->size = $size;
		$this->orientation = SHIP_ORIENTATION_HORIZONTAL;
		
		$this->hit_array = array();
		for($i = 0; $i < $size; $i++){
			$this->hit_array[$i] = 0;
		}
	}
	
	public function check_hit($p, $do_set_hit = false){
	
		$is_hit = false;
		
		if($this->position != null){
		
			$x = $this->position->x;
			$y = $this->position->y;
	
			if($this->orientation == SHIP_ORIENTATION_HORIZONTAL){
			
				$x_size = $x + $this->size;
				for($i = $x; $i < $x_size; $i++) {
					if($i == $p->x && $y == $p->y){
						$is_hit = true;
						if($do_set_hit){
							$this->hit_array[$i - $x] = 1;
						}
						break;
					}
				}
			}
			else {
			
				$y_size = $y + $this->size;
				for($i = $y; $i < $y_size; $i++) {
					if($i == $p->y && $x == $p->x){
						$is_hit = true;
						if($do_set_hit){
							$this->hit_array[$i - $y] = 1;
						}
						break;
					}
				}
			}
		}
		
		return $is_hit;
	}
	
	public function is_floating(){
	
		$is_floating = false;
		
		for($i = 0; $i < sizeof($this->hit_array); $i++){
			$is_floating = (($this->hit_array[$i] == 0) || $is_floating);
		}
		
		return $is_floating;
	}
	
	public function set_position($position, $orientation){
	
		$this->position = $position;
		$this->orientation = $orientation;
	}
	
	public function remove_position(){
	
		$this->position = null;
		$this->orientation = null;
	}
	
	public function __toString(){
		return $this->size . ' ' . $this->position . ' ' . ' [' . $this->orientation . ']';
	}
}

?>