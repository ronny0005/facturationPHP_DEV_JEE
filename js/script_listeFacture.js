jQuery(function($){

    var protect = 0;
    if($("#PROT_CbCreateur").val()!=2)
        $('[data-toggle="tooltip"]').tooltip();
$("#menu_transform").hide();
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

    var type = $_GET("type");

    function lien (){
        return $("#lienMenuNouveau").val();
    }

    function referencement(){
    }

$("table.table > tbody > tr #transform").on('click', function() {
    var cbMarq = $(this).parent().parent().find("#cbMarq").html();
    var entete = $(this).parent().parent().find("#entete a").html();
        $("#menu_transform").dialog({
                title : "Transformation du document "+entete,
                resizable: false,
                height: "auto",
                width: 600,
                modal: true,
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                            transformeEntete(cbMarq);
                        }
                    }
                }

            });
        });


    function transformeEntete(cbMarq){
        var check=0;
        if($('#conserv_copie').is(':checked')) check=1;

        $.ajax({
            url: "Traitement/BonLivraison.php?acte=transBLFacture&type_trans="+$("#type_trans").val()+"&type="+type+"&cbMarq="+cbMarq+"&date="+$("#date_transform").val()+"&conserv_copie="+check+"&reference="+$("#reference").val(),
            method: 'GET',
            dataType: 'html',
            success: function(data) {
                if(data.trim()!="") alert("La quantité en stock des "+data+" est inssufisante !");
                if(!$('#conserv_copie').is(':checked')) {
                    $.ajax({
                        url: "Traitement/Facturation.php?page=bonLivraison&acte=suppr_facture&cbMarq="+cbMarq,
                        method: 'GET',
                        dataType: 'html',
                        success: function(data) {
                            alert("La transormation a été effectuée !");
                            if(type=="Devis")
                                window.location.replace("indexMVC.php?module=2&action=2&type="+type+"&depot="+$("#depot").val());
                            else
                                window.location.replace("indexMVC.php?module=2&action=5&type="+type+"&depot="+$("#depot").val());
                        }
                    });
                } else{
                    alert("La transormation du document a été effectuée !");
                    window.location.replace("indexMVC.php?module=2&action=5&type="+type+"&depot="+$("#depot").val());
                }
            }
        });
    }
    referencement();
    $("#nouveau").on('click', function() {
        document.location.href = lien ();
    });

    $(".dynatable-page-link").on('click', function(){
        referencement();
    });

    $("#dynatable-query-search-table").keyup(function(e){
        referencement();
    });


    $("#client").autocomplete({
        source: "indexServeur.php?page=getTiersByNumIntitule&TypeFac=" + $("#typeDoc").val(),
        autoFocus: true,
        select: function (event, ui) {
            event.preventDefault();
            $("#client").val(ui.item.label)
            $("#CT_Num").val(ui.item.value)
        }
    })


    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});

    if($("#post").val()==0) {
        $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    }

    $("#tableListeFacture").DataTable(
        {
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            },
            fixedHeader: {
                header: true,
                footer: true
            }
        }
    );

    if($("#date_transform").val()=="")
        $("#date_transform").datepicker({dateFormat:"ddmmy"}).datepicker("setDate",new Date());

    if($("#ClotureVente").val()!="undefined"){
        $("#ClotureVente").click(function(){
            $("#FormClotureVente").dialog({
                resizable: false,
                height: "auto",
                width: 500,
                modal: true,
                async: false,
                title : "Cloture vente",
                buttons: {
                    "Valider": {
                        class: 'btn btn-primary',
                        text: 'Valider',
                        click: function () {
                            $.ajax({
                                url: "traitement/Facturation.php?acte=clotureVente",
                                method: 'GET',
                                dataType: 'html',
                                data: "CA_Num=" + $("#affaire").val(),
                                async: false,
                                success: function (data) {
                                    if (data == "")
                                        alert("La cloture s'est bien déroulée !");
                                    else
                                        alert(data);
                                }
                            });
                            $(this).dialog("close");
                        }
                    }
                }
            });
        });
    }



        $("#valider").click(function () {
        $("#valideLigne").submit()
    })
});