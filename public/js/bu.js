/*var message = "UGxlYXNlIGRvIG5vdCByZW1vdmUgJ0NvcHlyaWdodCAtIGFsdmlhbnl1c3VmMjJAZ21haWwuY29tJyBiYWNrbGluayBmcm9tIGZvb3RlciBvZiB0ZW1wbGF0ZS4gWW91IGNhbiBjYWxsIGFsdmlhbnl1c3VmMjJAZ21haWwuY29tIGFuZCByZW1vdmUgdGhlIGJhY2tsaW5r";
var foodec = "CiAgICAgICAgICA8ZGl2IGNsYXNzPSJwdWxsLXJpZ2h0IGhpZGRlbi14cyI+CiAgICAgICAgICAgIDxiPlZlcnNpb248L2I+IDEuMAogICAgICAgICAgPC9kaXY+CiAgICAgICAgICA8c3Ryb25nPkNvcHlyaWdodCCpIDIwMTcgLSBhbHZpYW55dXN1ZjIyQGdtYWlsLmNvbSAuPC9zdHJvbmc+IEFsbCByaWdodHMKICAgICAgICAgIHJlc2VydmVkLgogICAgICAgIA==";
try {
	var userConfirm = $('meta[name="'+atob("dXNlckNvbmZpcm0=")+'"]').attr('content');
	var userkeysTm = $('meta[name="'+atob("dXNlckNvbmZpcm0=")+'"]').attr('keys');
	var token = $('meta[name="httpcsrf"]').attr('content');
	if (userConfirm!=undefined) {
		var userkeys = atob(userkeysTm);
		parsingkey = userkeys.split("###");
		if (atob(parsingkey[2]) == userConfirm) {
			$("head").append('<meta name="'+atob("eXV1LXRva2Vu")+'" content="'+token+'" />');
		} else {
			alert(atob(message));
			$("#"+atob("bG9nb3V0LWZvcm0=")).submit();
			$(atob("Zm9vdGVy")).html(atob(foodec));
			$(atob("Ym9keQ==")).html(atob(foodec));
		}
	} else {
		var foo = $(atob("Zm9vdGVy")).html();
		var encodedString = btoa(foo);
		var decodedString = atob(encodedString);
		if (foodec != encodedString) {
			alert(atob(message));
			$("#"+atob("bG9nb3V0LWZvcm0=")).submit();
			$(atob("Zm9vdGVy")).html(atob(foodec));
			$(atob("Ym9keQ==")).html(atob(foodec));
		} else{
			$("head").append('<meta name="'+atob("eXV1LXRva2Vu")+'" content="'+token+'" />');
		}
	}
} catch(e) {
	alert(atob(message));
	console.log(e);
	$("#"+atob("bG9nb3V0LWZvcm0=")).submit();
	$(atob("Ym9keQ==")).html(atob(foodec));
	$(atob("Zm9vdGVy")).html(atob(foodec));
}
*/