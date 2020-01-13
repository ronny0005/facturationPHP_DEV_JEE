jQuery(function($){

        var protect=0;
        var type =0;
    if($_GET("action")==9) type=1;
    if($_GET("action")==17) type=2;

    function $_GET(param) {
	var vars = {};
	window.location.href.replace( location.hash, '' ).replace(
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;
	}
	return vars;
    }

    $('#ajouterClient').click(function(e){
        e.preventDefault();
        if($("#ncompte").val()=="")
            alert("le numéro de compte doit être renseigné !");
        else{
            $.ajax({
                url: 'traitement/Creation.php?acte=clientByIntitule',
                method: 'POST',
                dataType: 'html',
                async : true,
                data: "CT_Intitule=" + $("#intitule").val(),
                success: function (data) {
                    if(data!="")
                        alert(data);
                    else
                        ajouterClient();
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }
    });

    function protection(){
        $.ajax({
           url: "indexServeur.php?page=connexionProctection",
           method: 'GET',
           dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    if($_GET("action")=="9")
                        protect=this.PROT_FOURNISSEUR;
                    if($_GET("action")=="2")
                        protect=this.PROT_CLIENT;
                    if($_GET("action")=="17")
                        protect=this.PROT_CLIENT;

                    if(protect==1){
                        $("#form-creationClient :input").prop("disabled", true);
                    }
                });
            }
        });
    }
    protection();
    function ajouterClient(){
        //if($(".comboclient").val().length!=0 && $("#designation option:selected").length!=0){
        if($_GET("CT_Num")==null){
            var num ='';
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_client',
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize(),
                success: function(data) {
                    if(type==0)
                        window.location.replace("indexMVC.php?module=3&action=4&acte=ajoutOK&CT_Num="+data.CT_Num);

                    if(type==1)
                        window.location.replace("indexMVC.php?module=3&action=8&acte=ajoutOK&CT_Num="+data.CT_Num);
                    if(type==2)
                        window.location.replace("indexMVC.php?module=3&action=16&acte=ajoutOK&CT_Num="+data.CT_Num);
                },

                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }

            });
        }else {
            var num ='';
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_client&page=insertClientMin',
                method: 'GET',
                dataType: 'json',
                data : $("#form-creationClient").serialize()+"&CT_Num="+$_GET("CT_Num"),
                success: function(data) {
                    if(type==0)
                        window.location.replace("indexMVC.php?module=3&action=4&acte=modifOK&CT_Num="+data.CT_Num);
                    if(type==1)
                        window.location.replace("indexMVC.php?module=3&action=8&acte=modifOK&CT_Num="+data.CT_Num);
                    if(type==2)
                        window.location.replace("indexMVC.php?module=3&action=16&acte=modifOK&CT_Num="+data.CT_Num);
                },

                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
            });
        }
    }
});