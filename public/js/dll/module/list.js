module_list = {

baseUrl : "",
idDelete : "",
app : "",
toastrOptions : {
				  "closeButton": true,
				  "debug": false,
				  "positionClass": "toast-top-right",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				},

init : function()	{
    self = this;
    console.log(self.datat);
    $(document).ajaxStop($.unblockUI);
    toastr.options = self.toastrOptions;



    self.tblModule = $('#tblModule').DataTable({
        processing: true,
        serverSide: true,
        ajax: module_list.baseUrl+"getModuleList",
        "aoColumnDefs": [
        		{ "bSortable": false, "aTargets": [ 2, 4 ] }, 
                { "bSearchable": false, "aTargets": [ 2, 4 ] }
                ],
        // ajax: '{!! route('moduledata.data') !!}',
        columns: self.datat
    });

    $("#btnDelete").click(function(){	
			self.deleteConfirm(self.idDelete);
		});

	$('#tblModule').on( 'draw.dt', function () {
	    // alert( 'Table redrawn' );
	    // $('.btnC').bootstrapToggle();
	    $('.btnC').bootstrapToggle({
	      size:"mini",
	      on: 'Active',
	      off: 'Inactive'
	    });
	} );

    $(document).ajaxStop($.unblockUI);
    
    $("#form-create_module").on('submit',(function(e) {
			e.preventDefault();
			alert("test");
			// $("#message").empty();
			// $('#createUserModal').modal('hide');
			$.blockUI({
				// 
                message: '<h4>  Please wait... <img src='+self.baseUrl+'public/images/spinner.gif></h4>',
            });
			$.ajax({
				headers: {
			        // "APIKey": self.APIKey,
			    },
				// url: self.baseUrl+"ajaxAddQuotes", // Url to which the request is send
				url: self.urlData, // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(resp)   // A function to be called if request succeeds
				{
					try {
						console.log(resp.desc);
						// parseData = $.parseJSON(resp);
						parseData = resp;
						if(parseData['statusCode'] == 201){
							// urlDetailForm = "<p>Add Answer click <a href='"+self.baseUrl+"admin/form/"+parseData["idCreate"]+"'>here</a>";
							document.getElementById("form-modul1").reset();
							toastr.success(parseData['desc']);
						} else{
							toastr.warning(parseData['desc']);
							toastr.warning(parseData['error'].join('<br>'));
							$('#createUserModal').modal('show');
						}
					} catch(e) {
						console.log(e);
            			toastr.error('Internal Server Error');
						$('#createUserModal').modal('show');
					}
				},
	            error: function (data) {
	                console.log('Error:', data);
            		toastr.error('Connection Error');
					$('#createUserModal').modal('show');
	            }
			});
		}));

    $("#form-edit_module").on('submit',(function(e) {
			e.preventDefault();
			// $("#message").empty();
			$('#editModuleModal').modal('hide');
			$.blockUI({
				// 
                message: '<h4>  Please wait... <img src='+self.baseUrl+'public/images/spinner.gif></h4>',
            });
			$.ajax({
				headers: {
		            'X-CSRF-TOKEN': $('meta[name="yuu-token"]').attr('content')
		        },
				// url: self.baseUrl+"ajaxAddQuotes", // Url to which the request is send
				url: self.baseUrl+"/API/module/"+$(".editModule[name=editModule_id]").val(), // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(resp)   // A function to be called if request succeeds
				{
					try {
						console.log(resp.desc);
						// parseData = $.parseJSON(resp);
						parseData = resp;
						if(parseData['statusCode'] == 202){
							// urlDetailForm = "<p>Add Answer click <a href='"+self.baseUrl+"admin/form/"+parseData["idCreate"]+"'>here</a>";
							// document.getElementById("form-edit_module").reset();
							self.tblModule.draw();
							toastr.success(parseData['desc']);
						} else{
							toastr.warning(parseData['desc']);
							toastr.warning(parseData['error'].join('<br>'));
							$('#editModuleModal').modal('show');
						}
					} catch(e) {
						console.log(e);
            			toastr.error('Internal Server Error');
						$('#editModuleModal').modal('show');
					}
				},
	            error: function (data) {
	                console.log('Error:', data);
            		toastr.error('Connection Error');
					$('#editModuleModal').modal('show');
	            }
			});
		}));

  },
	
	deleteConfirm : function(uid)	{
	    self = this;
		$('#deleteModal').modal('hide');
	    toastr.options = self.toastrOptions;
		$.blockUI({
					message: '<h4> <img src='+self.baseUrl+'assets/images/ajax_loading.gif> Please wait...</h4>',
			});

		$.ajax({
				headers: {
		            'X-CSRF-TOKEN': $('meta[name="yuu-token"]').attr('content')
		        },
				type: "DELETE",
				url: self.baseUrl+"API/module/"+uid,
				success: function(resp) {
					try {
						// parseData = $.parseJSON(resp);
						parseData = resp;
						if(parseData['statusCode'] == 204){
							self.tblModule.draw();
							toastr.warning(parseData['desc']);
						} else {
							// $('a#active'+uid).text("ERROR");
	        				toastr.error(parseData['desc']);
						}
					} catch(e) {
						console.log(e);
	        			toastr.error('Internal Server Error');
					}
				},
	            error: function (data) {
	                console.log('Error:', data);
	        		toastr.error('Connection Error');
	            }
		});
	},
	deleteModal : function(uid)	{
	    self = this;
		$('#deleteModal').modal('show');
		self.idDelete = uid;
	},
  editModal : function(uid)	{
    self = this;
	$('#editModuleModal').modal('show');
    toastr.options = self.toastrOptions;
    // alert($('#check'+uid).prop('checked'));
	$.blockUI({
				message: '<h4> <img src='+self.baseUrl+'assets/images/ajax_loading.gif> Please wait...</h4>',
		});

	$.ajax({

			headers: {
	            'X-CSRF-TOKEN': $('meta[name="yuu-token"]').attr('content')
	        },
			type: "GET",
			url: self.baseUrl+"API/module/"+uid,
			success: function(resp) {
				try {
					// parseData = $.parseJSON(resp);
					parseData = resp;
					if(parseData['statusCode'] == 202){
						// $('a#active'+uid).text(parseData['data']);
						// toastr.success(parseData['desc']);
						$.each(parseData['data'], function(k,v){
							$(".editModule[name=editModule_"+k+"]").val(v);
						});
					} else {
						// $('a#active'+uid).text("ERROR");
        				toastr.error('Internal Server Error');
					}
				} catch(e) {
					console.log(e);
        			toastr.error('Internal Server Error');
				}
			},
            error: function (data) {
                console.log('Error:', data);
        		toastr.error('Connection Error');
            }
	});
  	// alert(uid)
  },
}