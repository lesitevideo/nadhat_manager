<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR"	>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Nadhat sms manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="<?php echo plugins_url('/assets/js/jquery-3.3.1.min.js',__FILE__ ); ?>"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo plugins_url('/assets/css/materialize.min.css',__FILE__ ); ?>" media="screen,projection"/>
	<link type="text/css" rel="stylesheet" href="<?php echo plugins_url('/assets/css/nadhat_manager.css',__FILE__ ); ?>" media="screen,projection"/>
	<script>
	const nadhat_ip = "<?php echo get_option( 'nadhat_manager_ip' ); ?>",
		nadhat_port = "<?php echo get_option( 'nadhat_manager_port' ); ?>",
		nadhat_adress = nadhat_ip + ':' + nadhat_port,
		nadhat_send_url = nadhat_adress + '/send',
		nadhat_inbox_url = nadhat_adress + '/get_sms',
		nadhat_outbox_url = nadhat_adress + '/get_sent';
	</script>
</head>

<body>
	      
	<div class="container">
       
		  <div class="row">
      
			  <div class="col s12 topcol">
				  
				  <h4 class="header">Gestion des SMS</h4>
				  
				  <div class="row">
					  <div class="col s12">
						  <ul class="tabs">
							  <li class="tab col s3"><a class="active" href="#send">Envoyer un SMS</a></li>
							  <li class="tab col s3"><a onClick="get_received_sms()" href="#received">SMS reçus <span id="received_count"></span></a></li>
							  <li class="tab col s3"><a onClick="get_sent_sms()" href="#sent">SMS envoyés <span id="sent_count"></span></a></li>
						  </ul>
					  </div>
					  <div id="send" class="col s12">
						  <div class="card">
							  <div class="card-content">
								  
								  <div class="row">
									
									  <div class="input-field col s6">
										  <input placeholder="numéro de mobile" id="destinataire_num" type="text" class="validate">
										  <label for="destinataire_num">Destinataire</label>
									  </div>
								  </div>
								  <div class="row">
									  <div class="input-field col s12">
										  <textarea placeholder="Saisissez votre message" data-length="160" class="materialize-textarea validate browser-default" id="sms_message"></textarea>
										  <label for="sms_message">Message (160 caractères max.)</label>
									  </div>
									  
								  </div>
								  <a onclick="send_sms()" class="waves-effect waves-light btn red"><i class="material-icons right">send</i>Envoyer</a>
							  
							  </div>
						  </div>
					  </div>
					  
					  <div id="received" class="col s12">
						  <div class="card">
							  <div class="card-content">
								  
								  <table id="received_sms_collection" class="striped">
									   <thead>
										<tr>
											<th>Date <a style="vertical-align: sub;" onClick="resort('received_sms_collection');" href="#"><i class="sort_icon material-icons tiny">arrow_drop_down</i></a></th>
											<th>Expéditeur</th>
											<th>Contenu</th>
											<th>Actions</th>
										</tr>
									</thead>
									  <tbody>
										  
									  </tbody>
								  </table>
								  
								  <div style="text-align: center;" class="load_sms_queue">
									  <img src="<?php echo plugins_url('/assets/images',__FILE__ ); ?>/round_shape_loader.gif"/>
								  </div>
							  
							  </div>
							  
						  </div>
						 <!--
						  <div class="col s12 center-align">
							  <ul class="pagination">
								  <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
								  <li class="active"><a href="#!">1</a></li>
								  <li class="waves-effect"><a href="#!">2</a></li>
								  <li class="waves-effect"><a href="#!">3</a></li>
								  <li class="waves-effect"><a href="#!">4</a></li>
								  <li class="waves-effect"><a href="#!">5</a></li>
								  <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
							  </ul>
						  </div>
						  -->
					  </div>
					  
					  <div id="sent" class="col s12">
						  <div class="card">
							  <div class="card-content">
							  
								  <table id="sent_sms_collection" class="striped">
									   <thead>
										<tr>
											<th>Date <a style="vertical-align: sub;" onClick="resort('sent_sms_collection');" href="#"><i class="sort_icon material-icons tiny">arrow_drop_up</i></a></th>
											<th>Destinataire</th>
											<th>Contenu</th>
											<th>Actions</th>
										</tr>
									  </thead>
									  <tbody>
									  </tbody>
								  </table>
								  
								  <div style="text-align: center;" class="load_sms_queue">
									  <img src="<?php echo plugins_url('/assets/images',__FILE__ ); ?>/round_shape_loader.gif"/>
								  </div>
							  
							  </div>
						  </div>
						 <!--
						  <div class="col s12 center-align">
							  <ul class="pagination">
								  <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
								  <li class="active"><a href="#!">1</a></li>
								  <li class="waves-effect"><a href="#!">2</a></li>
								  <li class="waves-effect"><a href="#!">3</a></li>
								  <li class="waves-effect"><a href="#!">4</a></li>
								  <li class="waves-effect"><a href="#!">5</a></li>
								  <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
							  </ul>
						  </div>
						 -->
					  </div>
				  </div>
			  </div>
		</div>
		
	</div>
	
	
	<script type="text/javascript" src="<?php echo plugins_url('/assets/js/materialize.min.js',__FILE__ ); ?>"></script>
	<script type="text/javascript" src="<?php echo plugins_url('/assets/js/nadhat_manager.js',__FILE__ ); ?>"></script>
	
</body>

</html>