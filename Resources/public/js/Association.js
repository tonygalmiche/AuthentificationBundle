function select_type() {
	v =  $("#ove_authentificationbundle_associationtype_type option:selected").val();
	//alert(v);

	prefix="#ove_authentificationbundle_associationtype_";

	affiche(prefix+"ldapServerAdress",false);
	//affiche(prefix+"ldapPort",false);
	affiche(prefix+"ldapDn",false);
	//affiche(prefix+"ldapPassword",false);
	//affiche(prefix+"ldapDbRoot",false);
	//affiche(prefix+"ldapFilter",false);

	affiche(prefix+"mysqlServerAdress",false);
	//affiche(prefix+"mysqlPort",false);
	affiche(prefix+"mysqlUser",false);
	affiche(prefix+"mysqlPassword",false);
	affiche(prefix+"mysqlDatabase",false);
	affiche(prefix+"mysqlUserTable",false);
	affiche(prefix+"mysqlLoginField",false);
	affiche(prefix+"mysqlPasswordField",false);
	affiche(prefix+"mysqlMailField",false);
	affiche(prefix+"mysqlFirstNameField",false);
	affiche(prefix+"mysqlLastNameField",false);

	
	
	if(v=="ldap") {
		affiche(prefix+"ldapServerAdress",true);
		//affiche(prefix+"ldapPort",true);
		affiche(prefix+"ldapDn",true);
		//affiche(prefix+"ldapPassword",true);
		//affiche(prefix+"ldapDbRoot",true);
		//affiche(prefix+"ldapFilter",true);
	}

	if(v=="mysql") {
		affiche(prefix+"mysqlServerAdress",true);
		//affiche(prefix+"mysqlPort",true);
		affiche(prefix+"mysqlUser",true);
		affiche(prefix+"mysqlPassword",true);
		affiche(prefix+"mysqlDatabase",true);
		affiche(prefix+"mysqlUserTable",true);
		affiche(prefix+"mysqlLoginField",true);
		affiche(prefix+"mysqlPasswordField",true);
		affiche(prefix+"mysqlMailField",true);
		affiche(prefix+"mysqlFirstNameField",true);
		affiche(prefix+"mysqlLastNameField",true);
	}


}

function affiche(id,affiche) {
	var input=$(id); // Id de l'input
	var div=$(input.get(0).parentNode); // Le Input est contenu dans un td, un tr, un tbody et une table
	if(affiche==true) {
		div.fadeIn();
	} else {
		div.hide();
	}
}


	
$(document).ready(function(){     
	//alert("ok");
	$('#ove_authentificationbundle_associationtype_type').change(function () {
		select_type();
	})
	select_type();
});
