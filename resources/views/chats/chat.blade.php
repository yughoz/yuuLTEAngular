<section class="content-header" ui-view="header">
<h1>@{{ title }}</h1>

</section>

<!-- Main content -->
<section class="content">
		 <!-- Direct Chat -->
    <div class="row">
        <div class="col-md-8">
			<div class="box box-info direct-chat direct-chat-info"  id="chat">
			  <div class="box-header with-border">
			    <h3 class="box-title">Direct Chat</h3>
			    <div class="box-tools pull-right">
			      <!-- <span data-toggle="tooltip" title="3 New Messages" class="badge bg-red">3</span> -->
			      <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> -->
			      <!-- In box-tools add this button if you intend to use the contacts pane -->
			      <!-- <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button> -->
			      <!-- <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
			    </div>
			  </div>
			  <!-- /.box-header -->
			  <div class="box-body">
			    <!-- Conversations are loaded here -->
				<div class="direct-chat-messages" id="message">
				      <!-- Message. Default to the left -->
					<div class="direct-chat-msg " v-bind:class="[activeClass]"  v-for="message in messages" :key="message.id">
						<!-- <i class="@{{message.username}}">@{{message.username}}</i> -->
						<div class="direct-chat-info clearfix">
							<span class="direct-chat-name pull-left" >@{{message.username}}</span>
						</div>
				        <img class="direct-chat-img" src="{{ url('') }}/images/user2-160x160.jpg" alt="message user image">
						<div class="direct-chat-text">@{{message.message}}</div>
					</div>
			      <!-- /.direct-chat-msg -->
			      <!-- Message to the right -->
			      	<!-- <div class="direct-chat-msg right"> -->
				        <!-- <div class="direct-chat-info clearfix"> -->
				          <!-- <span class="direct-chat-name pull-right">Sarah Bullock</span> -->
				          <!-- <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span> -->
				        <!-- </div> -->
				        <!-- /.direct-chat-info -->
				        <!-- <img class="direct-chat-img" src="{{ url('') }}/images/user2-160x160.jpg" alt="message user image"> -->
				        <!-- /.direct-chat-img -->
				        <!-- <div class="direct-chat-text"> -->
				          <!-- You better believe it! -->
				        <!-- </div> -->
				        <!-- /.direct-chat-text -->
			     	<!-- </div> -->
			      <!-- /.direct-chat-msg -->
			    </div>
			    <!--/.direct-chat-messages-->
			  </div>
			  <!-- /.box-body -->
			  <div class="box-footer">
			    <form @submit="send" class="form-horizontal">
			    <div class="input-group">
				      <input type="text" name="message" placeholder="Type Message ..." class="form-control"  v-model="message">
				      <span class="input-group-btn">
			                <button type="submit" class="btn btn-info btn-flat">Send</button>
				    	</form>
			    </span>
			    </div>
			  </div>
			  <!-- /.box-footer-->
			</div>
		</div>
        <div class="col-md-4">
			<div class="box box-info direct-chat direct-chat-success">
			  <div class="box-header with-border">
			    <h3 class="box-title">Chat Status</h3>
			    <div class="box-tools pull-right">
			    </div>
			  </div>
			  <div class="box-body">
				<div class="direct-chat-messages">
			  	 <ul class="products-list product-list-in-box" id="userStatus">
	                <!-- <li class="item">
	                  <div class="product-img">
	                    <img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image">
	                  </div>
	                  <div class="product-info">
	                    <a href="#" class="product-title">Xbox One</a>
	                    <span class="product-description">
	                          Online
	                        </span>
	                  </div>
	                </li> -->
	                <!-- /.item -->
	                <!-- <li class="item">
	                  <div class="product-img">
	                    <img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image">
	                  </div>
	                  <div class="product-info">
	                    <a href="#" class="product-title">PlayStation 4=</a>
	                    <span class="product-description">
	                          PlayStation 4 500GB Console (PS4)
	                        </span>
	                  </div>
	                </li> -->
	                <!-- /.item -->
	              </ul>
			  	</div>	
			  </div	>	
			</div>
		</div>
	</div>
	<!--/.direct-chat -->

</section>
 
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/io/2.0.4/socket.io.js"></script> -->
	<!-- <scripscript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.min.js"></script> -->
    <script >
  		yuuAPP.config.startTime = Math.floor(Date.now() / 1000);
  		yuuAPP.config.scroll = true;

    	function chatMore(){
		    var uID = '{{ Auth::user()->id }}';
		    $("#btnViewMore").remove();
			yuuAPP.socket.emit('chat.viewMore', yuuAPP.config.startTime, function (data) {
		      console.log("length : "+data.chatcache.length); 
			var $current_top_element = $("#message").children().first();


			if (data.chatcache.length > 0) {
				$.each(data.chatcache, function(k,v){
				    $("#message").prepend(htmlChat(v));
					yuuAPP.config.startTime = v.time;
				});
				$("#message").prepend('<div id="btnViewMore" class="direct-chat-msg text-center"><a href="javascript:void(0)" onclick="chatMore()" class="uppercase">View more</a></div>');

			} else {
				$("#message").prepend('<div class="direct-chat-msg text-center">empty data</div>');

			}
			console.log($current_top_element);
			var previous_height = 0;
			$current_top_element.prevAll().each(function() {
				previous_height += $(this).outerHeight();
				console.log(previous_height);
			});
			$("#message").scrollTop(previous_height);
		    });
    	}

    	function htmlChat(data){

		    var uID = '{{ Auth::user()->id }}';
			var right = "left";
			var dateChat = "right";
        	if (data.UID == uID) {
        		right = 'right';
				dateChat = "left";
            }
    		var text = "";
    		// multiplied by 1000 so that the argument is in milliseconds, not seconds.
			var date = new Date(data.time*1000);
			// Hours part from the timestamp
			var hours = date.getHours();
			// Minutes part from the timestamp
			var minutes = "0" + date.getMinutes();
			// Seconds part from the timestamp
			var seconds = "0" + date.getSeconds();
			var formattedTime = hours + ':' + minutes.substr(-2);
            text += '<div class="direct-chat-msg '+right+'" id="'+data._id+'">';
			text += '<div class="direct-chat-info clearfix">'; 
			text += '<span class="direct-chat-name pull-'+right+'" >'+data.username+'</span><span class="direct-chat-timestamp pull-'+dateChat+'">'+formattedTime+'</span></div>'
        	text += '<img class="direct-chat-img" src="{{ url('') }}/images/user2-160x160.jpg" alt="message user image">'
			text += '<div class="direct-chat-text">'+data.message+'</div></div>';

			if (yuuAPP.config.startTime > data.time) {
				yuuAPP.config.startTime = data.time;
			}
			return text
    	}
		$(document).ready(function(){
			$("#message").scroll(function() {
				if ($("#message")[0].scrollHeight - $("#message").scrollTop() > 300) {
					yuuAPP.config.scroll = false;
				} else {
					yuuAPP.config.scroll = true;
				}
	  			console.log($("#message").scrollTop());
	  			// console.log("height message:");
	  			// console.log($("#message")[0].scrollHeight);
	  			// console.log("height :");
	  			// console.log($("#message").height());
			  // if($(window).scrollTop() + $(window).height() > $(document).height() - footer) {		  
			  // 	$("#btnMore").html("Content load , Please Wait ...");
			  // }
			});
			$(".direct-chat-msg").addClass('right');
		});
		var param = {
					"username" : '{{ Auth::user()->name }}',
		        	"classEdit" : '{{ Auth::user()->id }}',
		        	"UID" : '{{ Auth::user()->id }}',
		}
		// var socket = io.connect('http://serveragscom-as.cloud.revoluz.io:49707',{query:"name={{ Auth::user()->name }}"});
		// var socket = io.connect('http://serveragscom-as.cloud.revoluz.io',{query:"name={{ Auth::user()->name }}"});
		// var socket = io.connect('http://192.168.66.51:3000',{query:"name={{ Auth::user()->name }}"});
		$("#message").append('<div id="btnViewMore" class="direct-chat-msg text-center"><a href="javascript:void(0)" onclick="chatMore()" class="uppercase">View more</a></div>');
		yuuAPP.socket.emit('chat.init', param);
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
		        yuuAPP.socket.on('chat.message', function(data) {
		        	// var data = JSON.parse(data);
		        	console.log('{{ Auth::user()->id }}');
		        	var uID = '{{ Auth::user()->id }}';
		            if (data.message != "") {
						$("#message").append(htmlChat(data));
						if (yuuAPP.config.scroll == true) {
							$("#message").stop().animate({ scrollTop: $("#message")[0].scrollHeight}, 100);
						}						
		            }

		        }.bind(this));
		        yuuAPP.socket.once('users.init', function(datas) {
						var text = "";
						console.log(datas);
			        	$.each(datas, function(k,vParse){
			        		
								v = JSON.parse(vParse);
								str = v.name;
								itemId = str.replace(" ", "_");
								console.log("item : ");
								console.log($("#item" + itemId).length);
		        			if($("#item" + itemId).length == 0) {
								spanChat = "";
				            	if (v.name != "{{ Auth::user()->name }}") {
				            		spanChat = '<span class="label label-info pull-right">Chat</span>';
					            }
						    	text += '<li class="item" id="item'+itemId+'">';
			                  	text += '<div class="product-img">';
			                    text += '<img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image"></div>';
			                  	text += '<div class="product-info">';
			                    text += '<a href="#" class="product-title">'+v.name+ spanChat+'</a>';
			                    text += '<span class="product-description">Online</span></div></li>';
			                }
						});
						$("#userStatus").append(text);
						this.initUser = true;
				});
		        yuuAPP.socket.on('users.status', function(data) {
		        	console.log(data);
				    	str = data.name; 
						itemId = str.replace(/ /g, "_");
					    if (data.action == "connect") {
		        			if($("#item" + itemId).length == 0) {
						    	var text = "";
						    	refchat = "chat({name: 'data.name', type: 'pc'})";
						    	spanChat = "";
				            	if (data.name != "{{ Auth::user()->name }}") {
				            		spanChat = '<span class="label label-info pull-right">Chat</span>';
					            }
						    	text += '<li class="item" id="item'+itemId+'">';
			                  	text += '<div class="product-img">'
			                    text += '<img src="{{ url('') }}/images/user2-160x160.jpg" alt="Product Image"></div>'
			                  	text += '<div class="product-info">';
			                    text += '<a class="product-title" ui-sref="'+refchat+'">'+data.name+ spanChat+' </a>';
			                    text += '<span class="product-description">Online</span></div></li>';
								$("#userStatus").append(text);
							}
					    } else if (data.action == "disconnect") {
					    	
					    	console.log("remove : ");
					    	console.log(data);
					    	console.log(itemId);
					    	$("#item"+itemId).remove();
					    }
						// this.userInit = true;
				    // }
				});


		        yuuAPP.socket.once('chat.init', function(data) {
		        	console.log("chat init :"+this.init);
		        	console.log("chat init if:"+this.init);
				    console.log(data);
						var text = "";
						$("#message").append('<div id="btnViewMore" class="direct-chat-msg text-center"><a href="javascript:void(0)" onclick="chatMore()" class="uppercase">View more</a></div>');

						var uID = '{{ Auth::user()->id }}';
			            var text = ""
			            chatcache = data.chatcache.reverse();
			            console.log(chatcache);
			            // for (var i = data.chatcache.length - 1; i >= 0; i--) {
			            // 	console.log(data.chatcache[i]);
			            // };
						$.each(data.chatcache, function(k,v){
							$("#message").append(htmlChat(v));
						});
						if (yuuAPP.config.scroll == true) {
							$("#message").stop().animate({ scrollTop: $("#message")[0].scrollHeight}, 100);
						}
						this.init = true;
						

				});


		       /* yuuAPP.socket.on('disconnect',function(){
		        	console.log('disconnect : {{ Auth::user()->id }}');
					io.emit('chat.message','user has disconnect');
				});*/
				yuuAPP.socket.on('myCustomEvent', (data) => {
				    console.log(data);
				});
		        
		    },
		    methods: {
		        send: function(e) {
		        	if (this.message != '') {
			        	dataJson = {
						        	"username" : '{{ Auth::user()->name }}',
						        	"classEdit" : '{{ Auth::user()->id }}',
						        	"UID" : '{{ Auth::user()->id }}',
						        	"idRand" : Math.random(),	
						        	"message" : this.message	
						        	}
			            yuuAPP.socket.emit('chat.message', dataJson);
			            this.message = '';		        		
		        	};
		            e.preventDefault();
		        }
		    }
		});
	</script>
