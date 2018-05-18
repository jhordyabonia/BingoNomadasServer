function getForm()
{
	var http = new XMLHttpRequest();
	add_input("id",id_seller);
	var params = "";
	for(i in inputs_seller)
		{
			params+=inputs_seller[i]['nombre'];
			params+="="+inputs_seller[i]['valor']+"&";
		}
	http.open("POST", url_seller, true);
	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	http.onreadystatechange = function() 
	{
	    if(http.readyState == 4 && http.status == 200) 
	    {
			var popup_seller=document.getElementById('popup_seller');
			//popup_seller.style.display='none';
			popup_seller.innerHTML=http.responseText;
			document.getElementById('l_'+id_seller).click();
	    }
	}
	http.send(encodeURI(params));
}
function add_input(name,val)
{
 	var l=inputs_seller.length
	var _n={'nombre':'seller_input_'+l,'valor':name+'%::%'+val};
	inputs_seller[l]=_n;
	return l;
}