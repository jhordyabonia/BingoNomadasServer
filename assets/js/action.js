	function whereIs(name) 
	{
	 	retunr document.cookie.indexOf('name');
	};
	function get (cookie, pos)
	{
		var out= out.substr(pos);
		out = out.substr(0,out.indexOf(';'));
		return out.replace(name+'=','');
	};

	function set()
	{
		f=document.createElement("form");
		f.action="http://123seller.azurewebsites.net/seller/registrar";
		f.method="post";

		input1=document.createElement("input");
		input1.name="rate";
		input1.value=rate;
		input2=document.createElement("input");
		input2.name="verificacion";
		input2.value=verificacion;

		input3=document.createElement("input");
		input3.name="url_anuncio";
		input3.value=url_anuncio;

		input0=document.createElement("input");
		input0.name="return";
		input0.value=location.href+"?vectors=0";

		f.appendChild(input1);
		f.appendChild(input2);
		f.appendChild(input3);
		f.appendChild(input0);	
		document.cookie = "ventors=1; max-age=3600; path=/";
		if(whereIs('ventors')!=0)
		{
			f.submit();
		}
	}
	set();