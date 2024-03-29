jQuery(function($){

    var protect=0;
    var type =0;

    $('#Ajouter').click(function(){
        Ajouter();
    });

    function protection(){
        $.ajax({
            url: "indexServeur.php?page=connexionProctection",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    protect=this.PROT_DEPOT;
                    if(protect==1){
                        $('#intitule').prop('disabled', true);
                        $('#adresse').prop('disabled', true);
                        $('#complement').prop('disabled', true);
                        $('#cp').prop('disabled', true);
                        $('#region').prop('disabled', true);
                        $('#pays').prop('disabled', true);
                        $('#responsable').prop('disabled', true);
                        $('#cat_compta').prop('disabled', true);
                        $('#code_depot').prop('disabled', true);
                        $('#tel').prop('disabled', true);
                    }
                });
            }
        });
    }

    protection();

    $("#majCompta").click(function () {
        $.ajax({
            url: "traitement/Facturation.php?acte=majComptaFonction",
            method: 'GET',
            dataType: 'html',
            data: $("#form-entete").serialize(),
            async: false,
            success: function (data) {
                if (data!=""){
                    alert(data);
                }else{
                    alert("La mise à jour comptable a bien été effectuée !");
                }
            }
        });
    });

    $("#typeTransfert").change(function() {
        if($("#typeTransfert").val()==3 ||$("#typeTransfert").val()==4){
            $("#facturedebut").prop("disabled",true);
            $("#facturefin").prop("disabled",true);
            $("#souche").prop("disabled",true);
            $("#catCompta").prop("disabled",true);
            $("#soucheJournal").prop("disabled",true);
            $("#journal").prop("disabled",true);
        }else{
            $("#facturedebut").prop("disabled",false);
            $("#facturefin").prop("disabled",false);
            $("#souche").prop("disabled",false);
            $("#catCompta").prop("disabled",false);
            $("#soucheJournal").prop("disabled",false);
            $("#journal").prop("disabled",false);
        }
    });

    $("#soucheJournal").change(function(){
        $.ajax({
            url: 'indexServeur.php?page=getSoucheVenteByIndice',
            method: 'GET',
            dataType: 'json',
            data : 'indice='+$("#soucheJournal").val(),
            async: false,
            success: function (data) {
                $("#journal").val(data[0].JO_Num);
            }
        });
    });

    $("#datedebut").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    $("#datefin").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
    $("#datedebut").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
    $("#datefin").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
});