// pour stopper :
// lister les nodes qui tournent : ps -e|grep node
// killer le proccess : kill -9 XXXX

// process dans : /etc/rc.local

const express        =         require("express");
const bodyParser     =         require("body-parser");
const app            =         express();

const fs = require('fs');
const shell = require('shelljs');
const dir = require('node-dir');

const inbox = '/var/spool/gammu/inbox';
const outbox = '/var/spool/gammu/outbox';
const sent = '/var/spool/gammu/sent';

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

app.all('/*', function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "X-Requested-With");
  next();
});
/*
app.get('/',function(req,res){
  res.sendFile("/home/pi/index.html");
});
*/
app.post('/send',function(req,res){
  var msg=req.body.msg;
  var num=req.body.num;
  console.log("message :  "+msg);
  shell.exec('sudo gammu-smsd-inject TEXT '+num+'  -text "'+msg+'"');
  res.send("yes");
});



app.post('/get_sms',function(req,res){
	var msgs = [];
	var contents = [];
	dir.readFiles( inbox,
    function(err, content, next) {
        if (err) throw err;
		contents.push(content);
        next();
    },
    function(err, files){
        if (err) throw err;
        //console.log('fini lister fichiers');
		for (var i in files) {
			msgs.push({'file':files[i].split("/").pop(), 'content':contents[i]});
		}
		res.send( msgs );
   }); 
	
});

app.post('/get_sent',function(req,res){
	var msgs = [];
	var contents = [];
	dir.readFiles( sent,
    function(err, content, next) {
        if (err) throw err;
		contents.push(content);
        next();
    },
    function(err, files){
        if (err) throw err;
        //console.log('fini lister fichiers');
		for (var i in files) {
			
			var sent_arr = contents[i].split("\n");
			//console.log('sent arr => ', sent_arr);
			var backup_text_pos = sent_arr.indexOf('[SMSBackup000]')+1;
			//console.log('@backup text => ', sent_arr[backup_text_pos].substring(0, 2));
			
			msgs.push({'file':files[i].split("/").pop(), 'content':sent_arr[backup_text_pos].substring(2)});
		}
		
		res.send( msgs );
   }); 
	
});


app.listen(3000,function(){
  console.log("Started on PORT 3000");
});


