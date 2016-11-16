<?php

/*
Returns a link to the database that must be kept and passed into the other functions.
*/
function connectToDatabase(){
	$databaseLink = mysqli_connect('localhost', 'root', '', 'partyqueue') or die (mysql_error());
	return $databaseLink;
}

/*
Creates a new room kept in the rooms database.
$roomID must be unique as it is a primary key.
*/
function createNewRoom($roomID, $RoomName, $RoomPassword, $databaseLink){
	$sql = "INSERT INTO `rooms` (`RoomID`, `RoomName`, `RoomPassword`) 
				VALUES (".$roomID.", '".$RoomName."', '".$RoomPassword."')";
	$databaseLink->query($sql);
	echo mysqli_error($databaseLink);
}

/*
Adds a song to the songs database.
The combination of #songID and $roomID must be unique.
For instance you can have multiple of the same songID in the DB, but they must
belong to different rooms.
*/
function addSong($roomID, $songID, $songName, $posterID, $databaseLink){
	$sql = "INSERT INTO `partyroom` (`songID`, `roomID`, `songName`, `posterID`, `upvotes`)
				 VALUES (".$songID.", ".$roomID.", '".$songName."', ".$posterID.", 0)";
	$databaseLink->query($sql);
	echo mysqli_error($databaseLink);
}

/*
Used to verify the password of a user entering a room.
Returns true if password was correct.
*/
function enterRoom($roomID, $attemptedPass, $databaseLink){
	$sql = "SELECT `RoomPassword` FROM `rooms` WHERE `RoomID` = ".$roomID;
	$RoomPass = $databaseLink->query($sql);
	if($RoomPass->num_rows > 1){
		echo "This RoomID has been duplicated in error!";
		return False;
	}
	else{
		$RoomPass = $RoomPass->fetch_assoc();
		if($RoomPass['RoomPassword'] != $attemptedPass){
			echo "Incorrect Password";
			return False;
		}
		else{
			return True;
		}
	}
}

/*
Returns an array of the songs in a particluar room.
Each entry contains roomID, songID, songName, userID, and upvotes.
*/
function fetchSongsInRoom($roomID, $databaseLink){
	$sql = "SELECT * FROM `partyroom` WHERE `roomID` = ".$roomID;
	$songs = $databaseLink->query($sql);
	$array = array();
	if ($songs->num_rows > 0) {
	    while($row = $songs->fetch_assoc()) {
	    	array_push($array, $row);
	    }
	}
	return $array;

}

/*
Adds one to the vote count of a song, which is again specified by the songID and roomID.
*/
function upvoteSong($songID, $roomID, $databaseLink){
	$sql = "SELECT `upvotes` FROM `partyroom` WHERE `songID` = ".$songID." AND `roomID` = ".$roomID;
	$songvotes = $databaseLink->query($sql);
	if($songvotes->num_rows > 1){
		echo "This SongID has been duplicated in error for this room!";
		return False;
	}
	else{
		$songvotes = $songvotes->fetch_assoc();
		$votes = $songvotes['upvotes'];
		$votes = $votes + 1;
		$sql = "UPDATE `partyroom` SET `upvotes` = ".$votes." 
				WHERE `songID` = ".$songID." AND `roomID` = ".$roomID;
		$databaseLink->query($sql);
		echo mysqli_error($databaseLink);
		return True;
	}
}

/*
Removes a song from the DB, this should be used is a song is deleted,
or if a song is played.
*/
function removeSong($songID, $roomID, $databaseLink){
	$sql = "DELETE FROM `partyroom` WHERE `songID` = ".$songID." AND `roomID` = ".$roomID;
	$databaseLink->query($sql);
	echo mysqli_error($databaseLink);
}

/*
Removes a room from the rooms DB.
*/
function removeRoom($roomID, $databaseLink){
	$sql = "DELETE FROM `rooms` WHERE `roomID` = ".$roomID;
	$databaseLink->query($sql);
	echo mysqli_error($databaseLink);
}

?>