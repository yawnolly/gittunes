
$(".audio").click(function(e){
	e.stopPropagation();
});

$(".mute").click(function(){
	var id = $(this).parent().attr('id').substring(2)
	var t = "#tb" + id;
	$(this).parent().css("background-color","#80c166");
	$(t).css("background-color", "#80c166");
	$(this).hide();
	$(this).siblings(".unmute").show();
	channelVolume[id].gain.value = 0;
});

$(".unmute").click(function(){
	var id = $(this).parent().attr('id').substring(2)
	var t = "#tb" + id;
	$(this).parent().css("background-color","");
	$(t).css("background-color", "");
	$(this).hide();
	$(this).siblings(".mute").show();
	channelVolume[id].gain.value = 1;
});

$("#solo").click(function(){
	if($(this).hasClass("active")){
		foreach()
	}
});

$("#upload").click(function(){
	$("#commit-form").show();
});

// $("#commit-form").submit(function(e){
// 	e.preventDefault();
// 	i=0;
// 	if ($("#commit-file").get(0).files.length == 0){
// 		$("#commit-file").parent().addClass("has-error");
// 		$("#no-file-commit").show();
// 		i++;
// 	}
// 	if($("#commit-msg").val() == ""){
// 		$("#commit-msg").parent().addClass("has-error");
// 		$("#no-comment-commit").show();
// 		i++;
// 	}
// 	if (i==0){
// 		$("#commit-form").hide();
// 		$("#successful-commit").show();
// 	}
// });

$("#seek").change(function(){
	var time = this.value;
	
	if (isPlaying){
		stopSeek();
		curTime = audioCtx.currentTime - time;
		stopSources().done(startSources());
		startSeek();
	} else{
		curTime = time;
	}
})

$("#commit-file").change(function(){
	var wrapper = $("#list-of-tracks");
	for (var i = 0; i<this.files.length; i++){
		wrapper.after("<div class='form-group'><label class='control-label col-lg-2' for='track'"+i+">"+this.files[i].name+"</label><div class='col-lg-4'><input class='form-control' type='text' name='track"+i+"' placeholder='Track Name' /></div></div>");
	}
})

$("#upload-file").change(function(){
	var wrapper = $("#list-of-tracks");
	for (var i = 0; i<this.files.length; i++){
		wrapper.after("<div class='form-group'><label class='control-label col-lg-2' for='track'"+i+">"+this.files[i].name+"</label><div class='col-lg-4'><input class='form-control' type='text' name='track"+i+"' placeholder='Track Name' /></div></div>");
	}
})

function resetProject(){
	if(isPlaying){
		var p = $(".pause-button");
		p.hide();
		p.siblings('.play-button').show();

		isPlaying = false;

		curTime = 0;

		stopSources();
		stopSeek();

		var sk = document.getElementById("seek");
		sk.value = 0;		
	}
}

function playProject(){
	var p = $(".play-button");
	p.hide();
	p.siblings('.pause-button').show();
	startSources();
	curTime = audioCtx.currentTime - curTime;
	isPlaying = true;

	startSeek();
}
function pauseProject(){
	var p = $(".pause-button");
	p.hide();
	p.siblings('.play-button').show();
	
	curTime = audioCtx.currentTime - curTime;

	isPlaying = false;
	stopSources();

	var sk = document.getElementById("seek");
	sk.value = curTime;

	stopSeek();
}

function startSources(){
	for(var i=0;i<sources.length;i++){
		sources[i].start(audioCtx.currentTime + .05, curTime);
	}
}

function stopSources(){
	for(var i=0;i<sources.length;i++){
		sources[i].stop();
		sources[i].disconnect(channelVolume[i]);
		sources[i] = audioCtx.createBufferSource();
		sources[i].connect(channelVolume[i]);
	}

	var loader = new BufferLoader(audioCtx,paths,finishLoading);
	loader.load();
}

function startSeek(){
	seek = setInterval(function(){
		var sk = document.getElementById("seek");
		sk.stepUp(1);
	},1000)	
}

function stopSeek(){
	clearInterval(seek);
}

