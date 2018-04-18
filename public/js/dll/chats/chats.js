$(document).ready(function(){
			$(".direct-chat-msg").addClass('right');
		});
		var param = {
					"username" : '{{ Auth::user()->name }}',
		        	"classEdit" : '{{ Auth::user()->id }}',
		        	"UID" : '{{ Auth::user()->id }}',
		}
		var socket = io.connect('http://serveragscom-as.cloud.revoluz.io:49707',{query:"name={{ Auth::user()->name }}"});
		// var socket = io.connect('http://serveragscom-as.cloud.revoluz.io',{query:"name={{ Auth::user()->name }}"});
		// var socket = io.connect('http://192.168.66.51:3000',{query:"name={{ Auth::user()->name }}"});
		socket.emit('chat.init', param);
		new Vue({
		    el:'#chat',
		    data: {
		        messages: [],
		        message: '',
		        isRight:false,
		        init:true,
		        activeClass:'customRight{{ Auth::user()->id }}',
		        usernames: [],
		        username: '{{ Auth::user()->name }}',
		        classEdit: '{{ Auth::user()->id }}',
		    },
		    mounted: function() {
		        socket.on('chat.message', function(data) {
		        	// var data = JSON.parse(data);
		        	console.log('{{ Auth::user()->id }}');
		        	var uID = '{{ Auth::user()->id }}';
		            if (data.UID == uID) {
		            	// this.isRight = true;
		            	this.activeClass = 'customRight{{ Auth::user()->id }}';
		            }
		            if (data.message != "") {
		            	// this.messages.push(data);
		            	var right = "left";
		            	if (data.UID == uID) {
		            		right = 'right';
			            }
			            tempId = ""+data.idRand;
			            data.idRand = tempId.replace(".", "");
			            var text = ""
			            text += '<div class="direct-chat-msg '+right+'" id="'+data.idRand+'">';
						text += '<div class="direct-chat-info clearfix">';
						text += '<span class="direct-chat-name pull-'+right+'" >'+data.username+'</span></div>'
			        	text += '<img class="direct-chat-img" src="{{ url('') }}/images/user2-160x160.jpg" alt="message user image">'
						text += '<div class="direct-chat-text">'+data.message+'</div></div>';
						$("#message").append(text);
						// $("#"+data.idRand).click();
						// $("#"+data.idRand).focus();
						// focus($("#"+data.idRand));
						// $('html, body').animate({ scrollTop: $('#'+data.idRand).offset().top }, 'slow');
						// $("html, body").animate({ scrollTop: $("#"+data.idRand).scrollTop() }, 1000);
						// $("#"+data.idRand).animate({ scrollTop: $("#"+data.idRand).scrollTop() }, 1000);
						// $(".box-body").stop().animate({ scrollTop: $(".box-body")[0].scrollHeight}, 1000);
						$("#message").stop().animate({ scrollTop: $("#message")[0].scrollHeight}, 1000);
						
		            }

		            // this.usernames.push(data.username);
		        	// $(".direct-chat-msg").addClass('right');
		        }.bind(this));
		        socket.on('users.init', function(datas) {
				    if (this.initUser != true || this.initUser == undefined) {
						var text = "";
			        	$.each(datas, function(k,vParse){
			        		
								v = JSON.parse(vParse);
		        			if($("#item" + v.name).length == 0) {
								spanChat = "";
				            	if (v.name != "{{ Auth::user()->name }}") {
				            		spanChat = '<span class="label label-info pull-right">Chat</span>';
					            }
						    	text += '<li class="item" id="item'+v.name+'">';
			                  	text += '<div class="product-img">';
			                    text += '<img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image"></div>';
			                  	text += '<div class="product-info">';
			                    text += '<a href="#" class="product-title">'+v.name+ spanChat+'</a>';
			                    text += '<span class="product-description">Online</span></div></li>';
			                }
						});
						$("#userStatus").append(text);
						this.initUser = true;
				    }
				});
		        socket.on('users.status', function(data) {
					    if (data.action == "connect") {
		        			if($("#item" + data.name).length == 0) {
						    	var text = "";
						    	refchat = "chat({name: 'data.name', type: 'pc'})";
						    	spanChat = "";
				            	if (data.name != "{{ Auth::user()->name }}") {
				            		spanChat = '<span class="label label-info pull-right">Chat</span>';
					            }
						    	text += '<li class="item" id="item'+data.name+'">';
			                  	text += '<div class="product-img">'
			                    text += '<img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image"></div>'
			                  	text += '<div class="product-info">';
			                    text += '<a class="product-title" ui-sref="'+refchat+'">'+data.name+ spanChat+' </a>';
			                    text += '<span class="product-description">Online</span></div></li>';
								$("#userStatus").append(text);
							}
					    } else if (data.action == "disconnect") {
					    	$("#item"+data.name).remove();
					    }
						// this.userInit = true;
				    // }
				});


		        socket.on('chat.init', function(data) {
		        	console.log("chat init :"+this.init);

					if (this.init == false || this.init == undefined) {
		        	
		        	console.log("chat init if:"+this.init);
				    console.log(data);
						var text = "";
						/*$.each(data.allClients, function(k,v){
						    	text += '<li class="item" id="'+v.name+'">';
			                  	text += '<div class="product-img">';
			                    text += '<img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image"></div>';
			                  	text += '<div class="product-info">';
			                    text += '<a href="#" class="product-title">'+v.name+'</a>';
			                    text += '<span class="product-description">Online</span></div></li>';
						});
						$("#userStatus").append(text);*/

						var uID = '{{ Auth::user()->id }}';
			            var text = ""
						$.each(data.chatcache, function(k,v){
						    var text = ""
							var right = "left";
							vParse = JSON.parse(v);
			            	if (vParse.UID == uID) {
			            		right = 'right';
				            }
				            tempId = ""+vParse.idRand;
				            vParse.idRand = tempId.replace(".", "");
				            text += '<div class="direct-chat-msg '+right+'" id="'+vParse.idRand+'">';
							text += '<div class="direct-chat-info clearfix">';
							text += '<span class="direct-chat-name pull-'+right+'" >'+vParse.username+'</span></div>'
				        	text += '<img class="direct-chat-img" src="{{ url('') }}/images/user2-160x160.jpg" alt="message user image">'
							text += '<div class="direct-chat-text">'+vParse.message+'</div></div>';
							$("#message").append(text);
						});
						$("#message").stop().animate({ scrollTop: $("#message")[0].scrollHeight}, 100);
						this.init = true;
						
					}

				});


		       /* socket.on('disconnect',function(){
		        	console.log('disconnect : {{ Auth::user()->id }}');
					io.emit('chat.message','user has disconnect');
				});*/
				socket.on('myCustomEvent', (data) => {
				    console.log(data);
				});
		        
		    },
		    methods: {
		        send: function(e) {
		        	dataJson = {
					        	"username" : '{{ Auth::user()->name }}',
					        	"classEdit" : '{{ Auth::user()->id }}',
					        	"UID" : '{{ Auth::user()->id }}',
					        	"idRand" : Math.random(),	
					        	"message" : this.message	
					        	}
		            socket.emit('chat.message', dataJson);
		            this.message = '';
		            this.isRight = false;
		            this.activeClass = 'customRight{{ Auth::user()->id }}';
		            e.preventDefault();
		        }
		    }
		});