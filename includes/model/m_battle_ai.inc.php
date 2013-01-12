<?php

require_once REAL_BASE . "includes/model/m_battle.inc.php";
require_once REAL_BASE . "includes/model/m_player.inc.php";

class BattleAi extends Battle {

	public $player_id;

	public $left;
	public $right;
	public $up;
	public $down;
	
	public $isHitted;
	public $isDestroyed;
	
	public $col;
	public $row;
	
	public $lastPosX;
	public $lastPosY;
	
	public $isFirstShot;
	
	public function __construct($player_id, $dimension, $difficulty){
	
		$this->player_id = $player_id;
	
		//init AI opponent
		$opponent = new Player;
		$opponent->id = 0;
		$opponent->name = 'Computer';
	
		parent::__construct($player_id, $opponent, $dimension, $difficulty);
		
		// set computer opponent
		$this->board_array[$opponent->id]->do_draw_ships = false;
		$this->board_array[$opponent->id]->has_removeable_ships = false;
		$this->board_array[$opponent->id]->random_init();
		
		$this->left = array();
		$this->right = array();
		$this->up = array();
		$this->down = array();
		
		$this->isHitted = false;
		$this->isDestroyed = true;
		
		$this->col = 0;
		$this->row = 0;
		
		$this->lastPosX = 0;
		$this->lastPosY = 0;
		
		$this->isFirstShot = true;
		
		//Only for testing:
		//$this->board_array[$player_id]->random_init();
	}
	
	protected function make_move_norm()
	{
		$position = null;
		
		$range_x = $this->dimension->width - 1;
		$range_y = $this->dimension->height - 1;
		
		$player_tile_array = $this->board_array[$this->player_id]->tile_array;
		
		while(true) {
		
			$rand_x = rand(0, $range_x);
			$rand_y = rand(0, $range_y);
			
			if($player_tile_array[$rand_x][$rand_y] == 0){
				$position = new Position($rand_x, $rand_y);
				break;
			}
		}
		
		return $position;
	}
	
	protected function make_vectors()
	{
		$player_tile_array = $this->board_array[$this->player_id]->tile_array;
		
		// left
		for($i=1; $i<5; $i++)
		{
			if(($this->col-$i) >= 0 && $player_tile_array[$this->col-$i][$this->row] == 0)
			{
				//push_array($this->left, ($this->col-$i));
				$this->left[$i-1] = ($this->col-$i);
			}
			else
			{
				break;
			}
		}
		
		// right
		for($i=1; $i<5; $i++)
		{
			if(($this->col+$i) < $this->dimension->width && $player_tile_array[$this->col+$i][$this->row] == 0)
			{
				//push_array($this->right, ($this->col+$i));
				$this->right[$i-1] = ($this->col+$i);
			}
			else
			{
				break;
			}
		}
		
		// up
		for($i=1; $i<5; $i++)
		{
			if(($this->row-$i) >= 0 && $player_tile_array[$this->col][$this->row-$i] == 0)
			{
				//push_array($this->up, ($this->row-$i));
				$this->up[$i-1] = ($this->row-$i);
			}
			else
			{
				break;
			}
		}
		
		// down
		for($i=1; $i<5; $i++)
		{
			if(($this->row+$i) < $this->dimension->height && $player_tile_array[$this->col][$this->row+$i] == 0)
			{
				//push_array($this->down, ($this->row+$i));
				$this->down[$i-1] = ($this->row+$i);
			}
			else
			{
				break;
			}
		}	
	}
	
	protected function make_random_move()
	{
		$player_tile_array = $this->board_array[$this->player_id]->tile_array;
		
		while(true)
		{
			$rand_x = rand(0, $this->dimension->width - 1);
			$rand_y = rand(0, $this->dimension->height - 1);
			
			if($player_tile_array[$rand_x][$rand_y] == 0)
			{
				$this->col = $rand_x;
				$this->row = $rand_y;
				
				$this->lastPosX = $rand_x;
				$this->lastPosY = $rand_y;
								
				break;	
			}		
		}
	}
	
	protected function make_calculated_move()
	{
		$position = null;
		
		// check if a calculated move hitted
 		if($this->isHitted && !$this->isDestroyed)
		{
			$player_tile_array = $this->board_array[$this->player_id]->tile_array;
			
			if(count($this->left) > 0)
			{
				if($player_tile_array[$this->lastPosX][$this->lastPosY] == TILE_HIT)
					array_shift($this->left);
				else
					$this->left = array();
			}
			elseif(count($this->right) > 0)
			{
				if($player_tile_array[$this->lastPosX][$this->lastPosY] == TILE_HIT)
					array_shift($this->right);
				else
					$this->right = array();
			}
			elseif(count($this->up) > 0)
			{
				if($player_tile_array[$this->lastPosX][$this->lastPosY] == TILE_HIT)
					array_shift($this->up);
				else
					$this->up = array();
			}
			elseif(count($this->down) > 0)
			{
				if($player_tile_array[$this->lastPosX][$this->lastPosY] == TILE_HIT)
					array_shift($this->down);
				else
					$this->down = array();
			}
		} 
		
		// check if a random move hitted
		if(!$this->isFirstShot)
		{
			if(!$this->isHitted && $this->isDestroyed)
			{
				$player_tile_array = $this->board_array[$this->player_id]->tile_array;
				
				if($player_tile_array[$this->lastPosX][$this->lastPosY] == TILE_HIT)
				{
					$this->isHitted	= true;
					$this->isDestroyed = false;
					$this->make_vectors();
				}
			} 
		}
	
		// calculate new shot position
		// if no hit and ship is destroyed
		if(!$this->isHitted && $this->isDestroyed)
		{
			$this->isFirstShot = false;
			$this->make_random_move();
			$position = new Position($this->col, $this->row);
		}
		else // else advanced movement
		{
			if(count($this->left) > 0)
			{
				$this->lastPosX = $this->left[0];
				$this->lastPosY = $this->row;
				$position = new Position($this->left[0], $this->row);			
			}
			elseif(count($this->right) > 0)
			{
				$this->lastPosX = $this->right[0];
				$this->lastPosY = $this->row;
				$position = new Position($this->right[0], $this->row);
			}
			elseif(count($this->up) > 0)
			{
				$this->lastPosX = $this->col;
				$this->lastPosY = $this->up[0];
				$position = new Position($this->col, $this->up[0]);
			}
			elseif(count($this->down) > 0)
			{
				$this->lastPosX = $this->col;
				$this->lastPosY = $this->down[0];
				$position = new Position($this->col, $this->down[0]);
			}
			else
			{
				$this->isHitted = false;
				$this->isDestroyed = true;
				$this->make_random_move();
				$position = new Position($this->col, $this->row);
			}
		}
		
		return $position;
	}
	
	public function make_basic_move(){
		
		$position = null;
		$move = true;
		
		$range_x = $this->dimension->width - 1;
		$range_y = $this->dimension->height - 1;
		
		$player_tile_array = $this->board_array[$this->player_id]->tile_array;
		
		while($move) {
		
			$rand_x = rand(0, $range_x);
			$rand_y = rand(0, $range_y);
			
			if($player_tile_array[$rand_x][$rand_y] == 0){
				$position = new Position($rand_x, $rand_y);
				$move = false;
			}
		}
		
		return $position;
	}
}

?>