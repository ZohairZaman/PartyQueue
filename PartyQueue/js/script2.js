function changeHeart(icon)
{
	var unclicked_heart = "<i class=\"fa fa-heart-o\" aria-hidden=\"true\"></i>";
	var clicked_heart = "<i class=\"fa fa-heart\" aria-hidden=\"true\"></i>"

	if (icon.innerHTML == unclicked_heart){
		icon.innerHTML = clicked_heart
	}
	else {
		icon.innerHTML = unclicked_heart;
	}

}


function changePlayback(icon)
{
	var playing = "<i class=\"fa fa-play-circle\" aria-hidden=\"true\"></i>";
	var paused = "<i class=\"fa fa-pause-circle\" aria-hidden=\"true\"></i>"

	if (icon.innerHTML == playing){
		icon.innerHTML = paused;
	}
	else{
		icon.innerHTML = playing;
	}
}
