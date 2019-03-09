var sort = "down";

$(document).ready(function () {
	if (nadhat_ip === "" || nadhat_port === "") {
		alert("Vous n'avez pas configuré l'IP et le PORT du NadHat sur votre réseau");
		return false;
	} else {
		get_received_sms();
		get_sent_sms();
	}
	$('textarea#sms_message').characterCounter();
	
	$(document).on("click", '.btreply', function(event) { 
    	console.log( "reply to: ",this.dataset.replyto );
	});
	
	$(document).on("click", '.btdelete', function(event) { 
    	console.log( "delete: ", this.dataset.delete );
	});
	
});

/* fonctions SMS */
function get_received_sms() {
	console.log("get received sms");
	//$("#sent_sms_collection").hide();
	$("#received_sms_collection tbody").html("");
	$(".load_sms_queue").show();

	var data = {
		"action": "get_all_sms"
	};
	$.post(nadhat_inbox_url, data,
		function (response) {

			if (!response) {
				alert("Il semble y avoir un problème avec le boitier NadHat, vérifiez la page de config.");
				return false;
			}
		
			$('#received_count').html('('+response.length+')');
			
			$.each(response, function (key, value) {
				//console.log( key + ": " + value.file + " = " + value.content );
				var obj = {};
				var smsdate = value.file.substring(2, 20).replace("_00", "");
				var year = smsdate.substring(0, 4);
				var month = smsdate.substring(4, 6);
				var day = smsdate.substring(6, 8);
				var hour = smsdate.substring(9, 11);
				var mins = smsdate.substring(11, 13);
				var secs = smsdate.substring(13, 15);
				var date_fr = day + '/' + month + '/' + year;
				var time_fr = hour + ':' + mins + ':' + secs;
				var smssender = value.file.substring(21).replace("_00.txt", "");

				obj.date = date_fr;
				obj.time = time_fr;
				obj.phone = smssender;
				obj.content = value.content;

				$('#received_sms_collection tbody').append('<tr><td>' + obj.date + ' ' + obj.time + '</td><td>' + obj.phone + '</td><td>' + obj.content + '</td><td><a title="Supprimer" data-delete="'+value.file+'" class="btaction btdelete secondary-content red-text"><i class="material-icons">delete</i></a><a data-replyto="' + obj.phone + '" title="Répondre" class="btaction btreply secondary-content grey-text"><i class="material-icons">reply</i></a></td></tr>');
			});

			$(".load_sms_queue").hide();
			$("#received_sms_collection").show();
		}
	).fail(function (xhr, status, error) {
		alert("Il semble y avoir un problème avec le boitier NadHat, vérifiez la page de config.");
		$(".load_sms_queue").hide();
	});

}

function get_sent_sms() {
	console.log("get sent sms");
	//$("#sent_sms_collection").hide();
	$("#sent_sms_collection tbody").html("");
	$(".load_sms_queue").show();

	var data = {
		"action": "get_all_sms"
	};

	$.post(nadhat_outbox_url, data,
		function (response) {

			if (!response) {
				alert("Il semble y avoir un problème avec le boitier NadHat, vérifiez la page de config.");
				return false;
			}
			$('#sent_count').html('('+response.length+')');
			$.each(response, function (key, value) {
				var obj = {};
				// {file: "OUTC20190207_103326_00_+33661252555_sms0.smsbackup", content: "hop hop"}
				//OUTC20190207_154615_00_
				var smsdate = value.file.substring(4, 22).replace("OUT", "");
				var year = smsdate.substring(0, 4);
				var month = smsdate.substring(4, 6);
				var day = smsdate.substring(6, 8);
				var hour = smsdate.substring(9, 11);
				var mins = smsdate.substring(11, 13);
				var secs = smsdate.substring(13, 15);
				var date_fr = day + '/' + month + '/' + year;
				var time_fr = hour + ':' + mins + ':' + secs;
				var exp = value.file.replace("_sms0.smsbackup", "");
				var phone = exp.substring(23);

				$('#sent_sms_collection tbody').append('<tr><td>' + date_fr + ' ' + time_fr + '</td><td>' + phone + '</td><td>' + value.content + '</td><td><a title="Supprimer" data-delete="'+value.file+'" class="btaction btdelete secondary-content red-text"><i class="material-icons">delete</i></a><a data-replyto="' + phone + '" title="Répondre" class="btaction btreply secondary-content grey-text"><i class="material-icons">reply</i></a></td></tr>');

			});
			$(".load_sms_queue").hide();
			$("#sent_sms_collection").show();
		}
	).fail(function (xhr, status, error) {
		alert("Il semble y avoir un problème avec le boitier NadHat, vérifiez la page de config.");
		$(".load_sms_queue").hide();
	});

}

function send_sms() {
	console.log("send sms");
	
	var data = {
		"msg": $("#sms_message").val(),
		"num": $("#destinataire_num").val()
	};
	$.post( nadhat_send_url, data,
		function(response){
			if(response === "yes"){
				console.log(response);
				$("#sms_message").val("");
				$("#destinataire_num").val("");
				Materialize.toast('SMS envoyé !', 4000);
			}
		}
	);
}

function convertDate(d) {
	d = d.replace("/", "");
	d = d.replace(" ", "");
	d = d.replace(":", "");
	d = d.replace("/", "");
	d = d.replace(" ", "");
	d = d.replace(":", "");
	return d;
}

function sortByDateUP(id) {
	$(".sort_icon").html("arrow_drop_down");

	var tbody = document.querySelector("#" + id + " tbody");
	var rows = [].slice.call(tbody.querySelectorAll("tr"));
	rows.sort(function (a, b) {
		return convertDate(a.cells[0].innerHTML) - convertDate(b.cells[0].innerHTML);
	});
	rows.forEach(function (v) {
		tbody.appendChild(v);
	});
}

function sortByDateDOWN(id) {
	$(".sort_icon").html("arrow_drop_up");
	var tbody = document.querySelector("#" + id + " tbody");
	var rows = [].slice.call(tbody.querySelectorAll("tr"));
	rows.sort(function (a, b) {
		return convertDate(b.cells[0].innerHTML) - convertDate(a.cells[0].innerHTML);
	});
	rows.forEach(function (v) {
		tbody.appendChild(v);
	});
}

function resort(id) {
	if (sort === "up") {
		sort = "down";
		sortByDateUP(id);
	} else {
		sort = "up";
		sortByDateDOWN(id);
	}
}
