
        yuuAPP.socket.on('connect_error', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-red"></i> Offline'); 
        });
        yuuAPP.socket.on('reconnect_failed', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-red"></i> Offline'); 
        });
        yuuAPP.socket.on('disconnect', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-red"></i> Offline'); 
        });
        yuuAPP.socket.on('connecting', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-warning"></i> connecting'); 
        });
        yuuAPP.socket.on('connect', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-success"></i> Online'); 
        });
        yuuAPP.socket.on('reconnect', function (err) {
            console.log(err);
            $("#userOn").html('<i class="fa fa-circle text-success"></i> Online'); 
        });