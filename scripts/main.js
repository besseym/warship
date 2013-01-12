
//setup package
var pro = {};
pro.warship = {

	'SHIP_ORIENTATION_HORIZONTAL' : 0,
	'SHIP_ORIENTATION_VERTICAL' : 1,
	
	'STATE_BOARD_DEFAULT' : 0,
	'STATE_BOARD_POSITION_SHIP' : 1,
	'STATE_BOARD_LOCKED' : 2,
	'STATE_BOARD_VUNERABLE' : 3,
	
	'STATE_BATTLE_SETUP' : 0,
	'STATE_BATTLE_CONFLICT' : 1,
	'STATE_BATTLE_RESOLUTION' : 2,
	
	'TILE_BLANK' : 0,
	'TILE_HIT' : 1,
	'TILE_MISS' : 2
};

pro.warship.TileImageLoader = function(){

	var imagePath = "images/tiles/";
	var battleshipImagePath = imagePath + "battleship/";
	var crusierImagePath = imagePath + "crusier/";
	var destroyerImagePath = imagePath + "destroyer/";
	var minesweeperImagePath = imagePath + "minesweeper/";
	
	var imageArray = new Array();
	
	// water images
	imageArray.push(imagePath + "water-hit.jpg");
	imageArray.push(imagePath + "water-miss.jpg");
	
	//battleship images
	imageArray.push(battleshipImagePath + "1-h-0.jpg");
	imageArray.push(battleshipImagePath + "1-h-1.jpg");
	imageArray.push(battleshipImagePath + "1-v-0.jpg");
	imageArray.push(battleshipImagePath + "1-v-1.jpg");
	
	imageArray.push(battleshipImagePath + "2-h-0.jpg");
	imageArray.push(battleshipImagePath + "2-h-1.jpg");
	imageArray.push(battleshipImagePath + "2-v-0.jpg");
	imageArray.push(battleshipImagePath + "2-v-1.jpg");
	
	imageArray.push(battleshipImagePath + "3-h-0.jpg");
	imageArray.push(battleshipImagePath + "3-h-1.jpg");
	imageArray.push(battleshipImagePath + "3-v-0.jpg");
	imageArray.push(battleshipImagePath + "3-v-1.jpg");
	
	imageArray.push(battleshipImagePath + "4-h-0.jpg");
	imageArray.push(battleshipImagePath + "4-h-1.jpg");
	imageArray.push(battleshipImagePath + "4-v-0.jpg");
	imageArray.push(battleshipImagePath + "4-v-1.jpg");
	
	imageArray.push(battleshipImagePath + "5-h-0.jpg");
	imageArray.push(battleshipImagePath + "5-h-1.jpg");
	imageArray.push(battleshipImagePath + "5-v-0.jpg");
	imageArray.push(battleshipImagePath + "5-v-1.jpg");
	
	//crusier images
	imageArray.push(crusierImagePath + "1-h-0.jpg");
	imageArray.push(crusierImagePath + "1-h-1.jpg");
	imageArray.push(crusierImagePath + "1-v-0.jpg");
	imageArray.push(crusierImagePath + "1-v-1.jpg");
	
	imageArray.push(crusierImagePath + "2-h-0.jpg");
	imageArray.push(crusierImagePath + "2-h-1.jpg");
	imageArray.push(crusierImagePath + "2-v-0.jpg");
	imageArray.push(crusierImagePath + "2-v-1.jpg");
	
	imageArray.push(crusierImagePath + "3-h-0.jpg");
	imageArray.push(crusierImagePath + "3-h-1.jpg");
	imageArray.push(crusierImagePath + "3-v-0.jpg");
	imageArray.push(crusierImagePath + "3-v-1.jpg");
	
	imageArray.push(crusierImagePath + "4-h-0.jpg");
	imageArray.push(crusierImagePath + "4-h-1.jpg");
	imageArray.push(crusierImagePath + "4-v-0.jpg");
	imageArray.push(crusierImagePath + "4-v-1.jpg");
	
	//destroyer images
	imageArray.push(destroyerImagePath + "1-h-0.jpg");
	imageArray.push(destroyerImagePath + "1-h-1.jpg");
	imageArray.push(destroyerImagePath + "1-v-0.jpg");
	imageArray.push(destroyerImagePath + "1-v-1.jpg");
	
	imageArray.push(destroyerImagePath + "2-h-0.jpg");
	imageArray.push(destroyerImagePath + "2-h-1.jpg");
	imageArray.push(destroyerImagePath + "2-v-0.jpg");
	imageArray.push(destroyerImagePath + "2-v-1.jpg");
	
	imageArray.push(destroyerImagePath + "3-h-0.jpg");
	imageArray.push(destroyerImagePath + "3-h-1.jpg");
	imageArray.push(destroyerImagePath + "3-v-0.jpg");
	imageArray.push(destroyerImagePath + "3-v-1.jpg");
	
	//minesweeper images
	imageArray.push(minesweeperImagePath + "1-h-0.jpg");
	imageArray.push(minesweeperImagePath + "1-h-1.jpg");
	imageArray.push(minesweeperImagePath + "1-v-0.jpg");
	imageArray.push(minesweeperImagePath + "1-v-1.jpg");
	
	imageArray.push(minesweeperImagePath + "2-h-0.jpg");
	imageArray.push(minesweeperImagePath + "2-h-1.jpg");
	imageArray.push(minesweeperImagePath + "2-v-0.jpg");
	imageArray.push(minesweeperImagePath + "2-v-1.jpg");
	
	return {
	
		loadImages: function(){
		
			// create image object
			var imageObj = new Image();
			
			// start loading
			var i = 0;
			var length = imageArray.length;
			for(i = 0; i < length; i++){
				imageObj.src = imageArray[i];
			}
		}
	};
};

pro.warship.Position = function(x, y) {

	var toString = function(){
		return x + ' ' + y;
	};

	return {
		getX: function () {
			return x;
		},
		getY: function () {
			return y;
		},
		equals : function(p){
			return (x == p.getX() && y == p.getY());
		},
		toString: function () {
			return toString();
		},
		alertPosition: function() {
			alert(toString());
		}
	};
};

//ships
pro.warship.Ship = function(type, index, size) {

	var id = type + '_' + index;
	var orientation = null;
	var position = null;
	var hitArray = new Array(size);
	
	var resetHits = function(){
		for(var i = 0; i < hitArray.length; i++){
			hitArray[i] = 0;
		}
	};
	
	//reset all the hits
	resetHits();
	
	var checkHit = function(p, doSetHit){ 
		var isHit = false;
		
		if(position != null){
		
			var x = position.getX();
			var y = position.getY();
			
			if(orientation == pro.warship.SHIP_ORIENTATION_HORIZONTAL){
				var xSize = x + size;
				for(var i = x; i < xSize; i++) {
					if(i == p.getX() && y == p.getY()){
						isHit = true;
						if(doSetHit){
							hitArray[i - x] = 1;
						}
						break;
					}
				}
			}
			else {
				var ySize = y + size;
				for(var i = y; i < ySize; i++) {
					if(i == p.getY() && x == p.getX()){
						isHit = true;
						if(doSetHit){
							hitArray[i - y] = 1;
						}
						break;
					}
				}
			}
		}
		
		return isHit;
	};
	
	return {
	
		getId: function(){
			return id;
		},
		getType: function(){
			return type;
		},
		getIndex: function(){
			return index;
		},
		getSize: function () {
			return size;
		},
		setOrientation: function(o){
			orientation = o;
		},
		getOrientation: function(o){
			return orientation;
		},
		getPosition: function(){
			return position;
		},
		setPosition: function(p){
			position = p;
		},
		isHit : function(p){
			return checkHit(p, false);
		},
		setHit : function(p){
			return checkHit(p, true);
		},
		setDirectHit : function(index, value){
			hitArray[index] = value;
		},
		resetHits : function(){
			resetHits();
		},
		isFloating : function() {
			
			var isFloating = false;
			for(var i = 0; i < hitArray.length; i++){
				isFloating = ((hitArray[i] == 0) || isFloating);
			}
			
			return isFloating;
		},
		draw: function(tileArray){
			
			var x = position.getX();
			var y = position.getY();
			
			var index = 0;
			
			if(orientation == pro.warship.SHIP_ORIENTATION_HORIZONTAL){
				var xSize = x + size;
				for(var i = x; i < xSize; i++) {
					if(hitArray[i - x] == 0){
						tileArray[i][y].makeShipPiece(type, orientation, index);
					}
					else {
						tileArray[i][y].makeDamagedShipPiece(type, orientation, index);
					}
					
					index++;
				}
			}
			else {
				var ySize = y + size;
				for(var i = y; i < ySize; i++) {
					if(hitArray[i - y] == 0){
						tileArray[x][i].makeShipPiece(type, orientation, index);
					}
					else {
						tileArray[x][i].makeDamagedShipPiece(type, orientation, index);
					}
					
					index++;
				}
			}
		}
	};
};

pro.warship.Battleship = function (index){

	var that = pro.warship.Ship('battleship', index, 5);
	return that;
};

pro.warship.Crusier = function (index){

	var that = pro.warship.Ship('crusier', index, 4);
	return that;
};

pro.warship.Frigate = function (index){

	var that = pro.warship.Ship('frigate', index, 3);
	return that;
};

pro.warship.Minesweeper = function (index){

	var that = pro.warship.Ship('minesweeper', index, 2);
	return that;
};

//board title
pro.warship.Tile = function(boardId, x, y) {

	var id = '#' + boardId + '_' + x + '_' + y;
	var tileElmt = $(id);
	var position = new pro.warship.Position(x, y);
	
	var state = pro.warship.TILE_BLANK;
	
	var toString = function(){
		return id + " (" + position.toString() + ")";
	};
	
	return {
		getState : function(){
			return state;
		},
		clear : function(){
			state = pro.warship.TILE_BLANK;
			tileElmt.attr('class', 'tile-water');
		},
		highlight : function(){
			tileElmt.attr('class', 'highlight');
		},
		highlightError : function(){
			tileElmt.attr('class', 'highlight-error');
		},
		makeMiss : function(){
			state = pro.warship.TILE_MISS;
			tileElmt.attr('class', 'tile-miss');
		},
		makeHit : function(shipType, orientation, index){
			state = pro.warship.TILE_HIT;
			tileElmt.attr('class', 'tile-hit');
		},
		makeShipPiece : function(shipType, orientation, index){
			tileElmt.attr('class', 'tile-' + orientation + '-' + shipType + '-' + index);
		},
		makeDamagedShipPiece : function(shipType, orientation, index){
			state = pro.warship.TILE_HIT;
			tileElmt.attr('class', 'tile-' + orientation + '-' + shipType + '-' + index + '-hit');
		},
		monitorHover : function (parameter){
			
			tileElmt.hover(
				//enter
				function(){
					parameter.enterFunction(position);
				},
				//exit
				function(){
					parameter.exitFunction(position);
				}
			);
		},
		monitorClick : function (parameter){
			tileElmt.mousedown(function(){
				parameter.handler(position);
			});
		},
		monitorDblClick : function (parameter){
			tileElmt.dblclick(function(){
				parameter.handler(position);
			});
		},
		reset : function(){
			tileElmt.unbind('mousedown');
			tileElmt.unbind('hover');
		}
	};
};

//board
pro.warship.Board = function(config) {

	var state = pro.warship.STATE_BOARD_DEFAULT;

	var id = config.player_id;
	var width = config.dimension.width;
	var height = config.dimension.height;
	
	var sunkShipIndex = -1;

	var tileArray = new Array(width);
	for (var x = 0; x < width; x++) {
		
		tileArray[x] = new Array(height);
		for (var y = 0; y < height; y++) {
			tileArray[x][y] = new pro.warship.Tile(id, x, y);
		}
	}
	
	//associate ships with board
	var shipArray = new Array(4);
	shipArray[0] = new pro.warship.Battleship(0);
	shipArray[1] = new pro.warship.Crusier(1);
	shipArray[2] = new pro.warship.Crusier(2);
	shipArray[3] = new pro.warship.Frigate(3);
	shipArray[4] = new pro.warship.Frigate(4);
	shipArray[5] = new pro.warship.Frigate(5);
	shipArray[6] = new pro.warship.Minesweeper(6);
	shipArray[7] = new pro.warship.Minesweeper(7);
	shipArray[8] = new pro.warship.Minesweeper(8);
	shipArray[9] = new pro.warship.Minesweeper(9);
	
	//place any ships on the board that have already been positioned
	var currentShip = null;
	var currentShipArray = config.ship_array;
	for (var i = 0; i < currentShipArray.length; i++) {
	
		currentShip = currentShipArray[i];
		
		//init position
		if(currentShip.position != null){
			shipArray[i].setPosition(new pro.warship.Position(currentShip.position.x, currentShip.position.y));
		}
		
		//init orientation
		if(currentShip.orientation != null){
			shipArray[i].setOrientation(currentShip.orientation);
		}
		
		//init hit array
		for(var j = 0; j < currentShip.hit_array.length; j++){
			shipArray[i].setDirectHit(j, currentShip.hit_array[j]);
		}
	}
	
	
	var drawShips = function(){
	
		if(!config.do_draw_ships){
			return;
		}
	
		var ship = null;
		for (var i = 0; i < shipArray.length; i++) {
			ship = shipArray[i];
			if(ship.getPosition() != null){
				ship.draw(tileArray);
			}
		}
	};
	
	//selected ship to position
	var selectedShipToPosition = null;
	
	var callShipFunction = function(functionName, parameter){
	
		for (var i = 0; i < shipArray.length; i++) {
			shipArray[i][functionName](parameter);
		}
	};
	
	var callTileFunction = function(functionName, parameter){
	
		for (var x = 0; x < width; x++) {
			for (var y = 0; y < height; y++) {
				tileArray[x][y][functionName](parameter);
			}
		}
	};
	
	var resetHits = function(){
	
		var ship = null;
		for (var i = 0; i < shipArray.length; i++) {
			shipArray[i].resetHits();
		}
	};
	
	var updateShip = function(ship) {
		
		var index = ship.getIndex();
		shipArray[index] = ship;
	};
	
	var getShipToPosition = function(shipType){
	
		var s = null;
		var ship = null;
		for (var i = 0; i < shipArray.length; i++) {
			s = shipArray[i];
			if(s.getType() == shipType && s.getPosition() == null){
				ship = s;
				break;
			}
		}
		
		return ship;
	};
	
	var drawBoard = function(){
	
		//draw board tiles
		for (var x = 0; x < width; x++) {
			for (var y = 0; y < height; y++) {
			
				switch(config.tile_array[x][y]){
					case pro.warship.TILE_BLANK:
						tileArray[x][y].clear();
						break;
					case pro.warship.TILE_MISS:
						tileArray[x][y].makeMiss();
						break;
					case pro.warship.TILE_HIT:
						tileArray[x][y].makeHit();
						break;
					default:
						tileArray[x][y].clear();
						break;
				}
			}
		}
		
		//draw ships
		drawShips();
	};
	
	//draw the board
	drawBoard();
	
	var setHit = function(position){
		
		var isHit = false;
		
		var ship = null;
		var isShipHit = false;
		for (var i = 0; i < shipArray.length; i++) {
		
			ship = shipArray[i];
			isShipHit = ship.setHit(position);
			if(isShipHit && !ship.isFloating()){
				sunkShipIndex = i;
			}
			
			isHit = (isShipHit || isHit);
		}
		
		return isHit;
	};
	
	var makeVulnerable = function (parameter) {
		
		var clickParameter = {
			handler : function(position){
			
				var x = position.getX();
				var y = position.getY();
				
				if(tileArray[x][y].getState() != pro.warship.TILE_BLANK){
					alert("You have already attacked this position!");
					return;
				}
			
				var data = JSON.stringify({
					'position' : {
						'x' : x,
						'y' : y
					} 
				});
			
				$.ajax({
					type: "POST",
					url: config.json.attack_url,
					data: {'data' : data},
					success: function(data) {
					
						var dataObj = $.parseJSON(data);
						if(dataObj.success){
						
							if(dataObj.successful_attack){
								if(setHit(position)){
									tileArray[x][y].makeHit();
									drawShips();
								}
							}
							else {
								tileArray[x][y].makeMiss();
							}
							
							parameter.onAttackResult(dataObj);
						}
						else {
							alert("error");
						}
					},
					error: function(jqXHR, textStatus, errorThrown){
						alert("error: " + textStatus);
					}
				});
			}
		};
		
		callTileFunction('monitorClick', clickParameter);
	};
	
	var positionShip = function (parameter) {
		
		var canPositonShip = false;
		var selectedPosition = null;
	
		var hoverParameter = {
			'enterFunction' : function(position){
			
				canPositonShip = false;
				
				//clear tiles
				callTileFunction('clear', null);
			
				selectedPosition = position;
				var x = position.getX();
				var y = position.getY();
				
				if(parameter.getSelectedOrientation() == pro.warship.SHIP_ORIENTATION_HORIZONTAL){
				
					var xSize = x + selectedShipToPosition.getSize();
					var isOutside = (xSize > width);
					var length = isOutside ? width : xSize;
					
					//mark any ship intersections
					var shipIntersect = false;
					for(var i = x; i < length; i++) {
						for (var j = 0; j < shipArray.length; j++) {
							if(shipArray[j].setHit(pro.warship.Position(i, y))){
								shipIntersect = true;
							}
						}
					}
					
					//highlight as error if outside board
					var index = 0;
					for(var i = x; i < length; i++) {
						if(isOutside){
							tileArray[i][y].makeDamagedShipPiece(selectedShipToPosition.getType(), parameter.getSelectedOrientation(), index);
						}
						else {
							tileArray[i][y].makeShipPiece(selectedShipToPosition.getType(), parameter.getSelectedOrientation(), index);
						}
						
						index++;
					}
					
					canPositonShip = (!isOutside && !shipIntersect);
				}
				else {
				
					var ySize = y + selectedShipToPosition.getSize();
					var isOutside = (ySize > height);
					var length = isOutside ? height : ySize;
					
					//mark any ship intersections
					var shipIntersect = false;
					for(var i = y; i < length; i++) {
						for (var j = 0; j < shipArray.length; j++) {
							if(shipArray[j].setHit(pro.warship.Position(x, i))){
								shipIntersect = true;
							}
						}
					}
					
					//highlight as error if outside board
					var index = 0;
					for(var i = y; i < length; i++) {
						if(isOutside){
							tileArray[x][i].makeDamagedShipPiece(selectedShipToPosition.getType(), parameter.getSelectedOrientation(), index);
						}
						else {
							tileArray[x][i].makeShipPiece(selectedShipToPosition.getType(), parameter.getSelectedOrientation(), index);
						}
						
						index++;
					}
					
					canPositonShip = (!isOutside && !shipIntersect);
				}
				
				//console.log("can position : " + canPositonShip);
				
				drawShips();
			},
			'exitFunction' : function(position){
			
				resetHits();
			}
		};
	
		callTileFunction('monitorHover', hoverParameter);
		
		var clickParameter = {
			handler : function(position){
				
				if(canPositonShip){
				
					var index = selectedShipToPosition.getIndex();
					var orientation  = parameter.getSelectedOrientation();
					var x = selectedPosition.getX();
					var y = selectedPosition.getY();
					
					var data = JSON.stringify({
						'id' : index,
						'orientation' : orientation,
						'position' : {
							'x' : x,
							'y' : y
						}
					});
					
					$.ajax({
						type: "POST",
						url: config.json.position_ship_url,
						data: {'data' : data},
						success: function(data) {
						
							var dataObj = $.parseJSON(data);
							if(dataObj.success){
								selectedShipToPosition.setPosition(selectedPosition);
								selectedShipToPosition.setOrientation(parameter.getSelectedOrientation());
								selectedShipToPosition.draw(tileArray);
								parameter.onShipPositioned();
							}
							else {
								alert("error");
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert("error: " + textStatus);
						}
					});
				}
			}
		};
		
		callTileFunction('monitorClick', clickParameter);
	};
	
	var dblClickParameter = {
		handler : function(position){
		
			if(state == pro.warship.STATE_BOARD_LOCKED){
				return;
			}
			
			var ship = null;
			for (var i = 0; i < shipArray.length; i++) {
			
				if(shipArray[i].isHit(position)){
				
					var data = JSON.stringify({
						'id' : i
					});
				
					$.ajax({
						type: "POST",
						url: config.json.remove_ship_url,
						data: {'data' : data},
						success: function(data) {
						
							var dataObj = $.parseJSON(data);
							if(dataObj.success){
							
								shipArray[i].setPosition(null);
								shipArray[i].setOrientation(null);
								
								//redraw the board after update
								drawBoard();
								config.onRemove();
							}
							else {
								alert("error");
							}
						},
						error: function(jqXHR, textStatus, errorThrown){
							alert("error: " + textStatus);
						}
					});
					
					break;
				}
			}
		}
	};
	
	if(config.has_removeable_ships){
		callTileFunction('monitorDblClick', dblClickParameter);
	}
	
	var resetBoard = function (){
		callTileFunction('reset', null);
	};
	
	var setBoardState = function (new_state, parameter) {
	
		if(new_state == null){
			new_state = pro.warship.STATE_BOARD_DEFAULT;
		}
		
		switch(new_state){
			case pro.warship.STATE_BOARD_DEFAULT:
				resetBoard();
				break;
			case pro.warship.STATE_BOARD_POSITION_SHIP:
				positionShip(parameter);
				break;
			case pro.warship.STATE_BOARD_LOCKED:
				break;
			case pro.warship.STATE_BOARD_VUNERABLE:
				makeVulnerable(parameter);
				break;
			default:
				resetBoard();
				break;
		}
		
		state = new_state;
	};
	
	return {
		
		getShipToPosition : function(shipType) {
			return getShipToPosition(shipType);
		},
		
		getSelectCountOfShipType : function(shipType) {
			
			var selectCount = 0;
			
			var ship = null;
			for (var i = 0; i < shipArray.length; i++) {
				ship = shipArray[i];
				if(ship.getPosition() == null && shipType === ship.getType()){
					selectCount++;
				}
			}
			
			return selectCount;
		},
		
		getShipsToSelectCountArray : function(){
		
			var shipsToSelectCountArray = new Array();
			shipsToSelectCountArray['battleship'] = 0;
			shipsToSelectCountArray['crusier'] = 0;
			shipsToSelectCountArray['frigate'] = 0;
			shipsToSelectCountArray['minesweeper'] = 0;
			
			var ship = null;
			for (var i = 0; i < shipArray.length; i++) {
				ship = shipArray[i];
				if(ship.getPosition() == null){
					shipsToSelectCountArray[ship.getType()]++;
				}
			}
			
			return shipsToSelectCountArray;
		},
		
		setSelectedShipToPosition : function(ship){
			selectedShipToPosition = ship;
		},
		
		setSelectedShipTypeToPosition : function(shipType){
			selectedShipToPosition = getShipToPosition(shipType);
		},
		
		attack : function(position) {
		
			var isHit = setHit(position);
			if(isHit){
				drawShips();
			}
			else {
				var x = position.getX();
				var y = position.getY();
				tileArray[x][y].makeMiss();
			}
			
			return isHit;
		},
		
		setBoardState : function (new_state, parameter) {
			setBoardState(new_state, parameter);
		},
		
		resetBoard : function () {
			setBoardState(null, null);
		},
		
		evaluateBoard : function(shipSyncAlert){
			
			if(sunkShipIndex >= 0){
			
				var remainingShips = 0;
			
				var ship = shipArray[sunkShipIndex];
				var shipType = ship.getType();
				
				var s = null;
				for (var i = 0; i < shipArray.length; i++) {
					s = shipArray[i];
					if(s.getType() == shipType){
						if(s.isFloating()){
							remainingShips++;
						}
					}
				}
				
				sunkShipIndex = -1;
				
				if(config.doSinkAlerts){
					shipSyncAlert(shipType, remainingShips);
				}
			}
		}
	};
};

//battle
pro.warship.Battle = function (config) {
	
	var playerId = config.player.player_id;
	var opponentId = config.opponent.player_id;

	var state = pro.warship.STATE_BATTLE_SETUP;
	var orientation = pro.warship.SHIP_ORIENTATION_HORIZONTAL;
	
	var updateShipSelectCtrl = function(shipType, selectCount){
		
		if(selectCount < 0){
			selectCount = 0;
		}
		
		$('#' + shipType + '-select-count').text(selectCount);
		
		var shipSelectCtrl = $('#' + shipType + '-select');
		if(selectCount == 0){
			shipSelectCtrl.attr('disabled', true);
		}
		else {
			shipSelectCtrl.attr('disabled', false);
		}
		
		shipSelectCtrl.attr('checked', false);
	};

	/*
	* update number of ships that can be selected 
	* based on the number of ships available to place on the board
	*/
	var updateEveryShipSelectCntrl = function(){
		
		shipsToSelectCountArray = boardArray[playerId].getShipsToSelectCountArray();
		
		updateShipSelectCtrl('battleship', shipsToSelectCountArray['battleship']);
		updateShipSelectCtrl('crusier', shipsToSelectCountArray['crusier']);
		updateShipSelectCtrl('frigate', shipsToSelectCountArray['frigate']);
		updateShipSelectCtrl('minesweeper', shipsToSelectCountArray['minesweeper']);
		
		var shipSelectCount = 0;
		var shipsLeftToSelect = false;
		for (var shipType in shipsToSelectCountArray){
			shipSelectCount = shipsToSelectCountArray[shipType];
			if(shipSelectCount > 0){
				shipsLeftToSelect = true;
				break;
			}
		}
		
		var beginBattleButton = $('#begin-battle-button');
		if(shipsLeftToSelect){
			beginBattleButton.attr('disabled', 'disabled');
		}
		else{
			beginBattleButton.removeAttr("disabled");
		}
	};
	
	//setup board array
	
	config.player.onRemove = function() {
		updateEveryShipSelectCntrl();
	};
	
	config.opponent.onRemove = function() {};
	
	var boardArray = new Array(2);
	boardArray[playerId] = new pro.warship.Board(config.player);
	boardArray[opponentId] = new pro.warship.Board(config.opponent);
	
	//update ship select controls after player board has been initialized
	updateEveryShipSelectCntrl();
	
	var changeShipSelectCtrlState = function(shipType, disable){
	
		var shipSelectCtrl = $('#' + shipType + '-select');
		
		if(disable){
			shipSelectCtrl.attr('disabled', 'disabled');
			shipSelectCtrl.removeAttr('checked');
		}
		else {
			shipSelectCtrl.removeAttr('disabled');
		}
	};
	
	var sendBattleState = function(newState){
	
		if(newState == null){
			newState = pro.warship.STATE_BATTLE_SETUP;
		}
		
		var data = JSON.stringify({
			'state' : newState
		});
	
		$.ajax({
			type: "POST",
			url: config.json.change_state_url,
			data: {'data' : data},
			success: function(data) {
			
				var dataObj = $.parseJSON(data);
				if(dataObj.success){
					setBattleState(newState);
				}
				else {
					alert("error");
				}
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("error: " + textStatus);
			}
		});
		
		return 
	};
	
	var displayResolution = function(){
		
		$('#resolution-frame').attr('src', config.resolution_url);
		$('#resolution-overlay').show();
		$('#resolution-overlay-content').show();
	};
	
	var setBattleState = function(newState){
	
		switch(newState){
			case pro.warship.STATE_BATTLE_SETUP:
				$('#battle-status').text("Strategically Place Your Ships");
				break;
			case pro.warship.STATE_BATTLE_CONFLICT:
				$('#battle-status').text("Launch Attacks Against your Opponent");
				$('#setup-instructions').addClass('hidden');
				$('#state-of-conflict').removeClass('hidden');
				
				//lock the players board to prevent further changes
				boardArray[playerId].setBoardState(pro.warship.STATE_BOARD_LOCKED);
				
				//make the opponent's board vulnerable for attack
				var parameter = {
				
					'onAttackResult' : function (result) {
					
						var opponent_attack_position = result.opponent_attack_position;
						if(opponent_attack_position != null){
						
							var x = opponent_attack_position.x;
							var y = opponent_attack_position.y;
							var opponentAttackPosition = pro.warship.Position(x, y);
							
							//if opponent retaliation is successful
							if(boardArray[playerId].attack(opponentAttackPosition)){
							
								boardArray[playerId].evaluateBoard(function(shipType, remainingShips){
								
									$('#' + shipType + '-remaining').text(remainingShips);
								
									var isBattleship = ('battleship' == shipType);
									
									var message = "Your opponent sunk ";
									if(!isBattleship){
										if(remainingShips > 0){
											message += "one of ";
										}
										else {
											message += "your last ";
										}
									}
									else {
										message += "your ";
									}
									
									message += shipType;
									if(!isBattleship && remainingShips > 0){
										message += "s";
									}
									
									message += "!";
									
									alert(message);
								});
							}
						}
						
						if(result.successful_attack){
							boardArray[opponentId].evaluateBoard(function(shipType, remainingShips){
							
								var isBattleship = ('battleship' == shipType);
								
								var message = "You sunk ";
								if(!isBattleship){
									message += "one of ";
								}
								message += "your opponent's ";
								
								message += shipType;
								if(!isBattleship){
									message += "s";
								}
								
								message += "!";
								
								alert(message);
							});
						}
						
						if(result.is_game_over){
							sendBattleState(pro.warship.STATE_BATTLE_RESOLUTION);
						}
					
						return orientation;
					},
					'shipSinkAlert' : function (ship){
					
						var shipType = ship.getType();
						
						var message = "You sunk ";
						if('battleship' != shipType){
							message += "one of ";
						}
						message += "your opponent's " + shipType + "!";
						
						alert(message);
					}
				};
				boardArray[opponentId].setBoardState(pro.warship.STATE_BOARD_VUNERABLE, parameter);
				break;
			case pro.warship.STATE_BATTLE_RESOLUTION:
				$('#battle-status').text("The Battle has come to a Resolution");
				
				//display the resolution to the user
				displayResolution();
				
				break;
			default:
				$('#battle-status').text("Unknown Battle Status");
				break;
		}	
		
		state = newState;
	};
	
	//set initial battle state
	setBattleState(config.state);
	
	//wire up keys for the player to change setting with
	$(document).keydown(function(e) {
		
		switch (e.which) {
		
			//toggle orientation select with tab key
			case 9:
			
				if(orientation == pro.warship.SHIP_ORIENTATION_VERTICAL){
				
					orientation = pro.warship.SHIP_ORIENTATION_HORIZONTAL;
					$('#vertical-select').attr('checked', false);
					$('#horizontal-select').attr('checked', true);
					
				} else {
				
					orientation = pro.warship.SHIP_ORIENTATION_VERTICAL;
					$('#horizontal-select').attr('checked', false);
					$('#vertical-select').attr('checked', true);
				}
				
				//alert($('#vertical-select').checked);
				
				e.preventDefault();
				break;
				
			default:
				break;
		}
	});
	
	$('.orientation-select').each(function(index) {
	    
	    $(this).change(function(){
	    
	    	if(this.checked){
	    	
	    		var selectedOrientationType = this.id.replace("-select", "");
	    		if('vertical' == selectedOrientationType){
	    			orientation = pro.warship.SHIP_ORIENTATION_VERTICAL;
	    		}
	    		else {
	    			orientation = pro.warship.SHIP_ORIENTATION_HORIZONTAL;
	    		}
	    	}
	    });
	});
	
	/*
	* ship select event handler
	*/
	$('.ship-select').each(function(index) {
	    
	    $(this).change(function(){
	    
	    	//the battle must be in setup state for ship select to happen
	    	if(state != pro.warship.STATE_BATTLE_SETUP){
	    		return;
	    	}
	    
	    	if(this.checked){
	    	
	    		var selectedShipType = this.id.replace("-select", "");
	    		var selectCount = boardArray[playerId].getSelectCountOfShipType(selectedShipType);
	    		if(selectCount > 0){
	    		
	    			var parameter = {
	    				'getSelectedOrientation' : function () {
	    					return orientation;
	    				},
	    				'onShipPositioned' : function () {
	    					
	    					boardArray[playerId].setSelectedShipTypeToPosition(null);
	    					updateEveryShipSelectCntrl();
	    					
	    					boardArray[playerId].setBoardState(pro.warship.STATE_BOARD_DEFAULT, parameter);
	    				},
	    				'onShipRemoved' : function(){
	    					updateEveryShipSelectCntrl();
	    				}
	    			};
	    			
	    			boardArray[playerId].setSelectedShipTypeToPosition(selectedShipType);
	    			boardArray[playerId].setBoardState(pro.warship.STATE_BOARD_POSITION_SHIP, parameter);
	    		}
	    		else {
	    			alert("There are no longer " + selectedShipType + "s left to position.");
	    		}
	    	}
	    });
	});
	
	$('#begin-battle-button').click(function() {
		sendBattleState(pro.warship.STATE_BATTLE_CONFLICT);
	});
	
	return {
	
	};
};

