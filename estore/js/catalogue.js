$(document).ready(function(){
	$("input").change(function(){
		var subtotal = parseInt($(this).val())*
		parseFloat($(this).parent().parent().find("td[name='price']").text());
		$(this).parent().parent().find('#subtotal').text(subtotal);
		var total = 0;
		$("td[id='subtotal']").each(function(){
			if ($(this).text()!="")
				total += parseFloat($(this).text());
		});
		$('#total').text(total);
		$("input[name='total']").val(total);
	});
})