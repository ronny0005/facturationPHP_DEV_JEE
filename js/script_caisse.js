jQuery(function ($) {
    var sommeTotal=0;
    var jeton=0;
    var admin=0;
    var datedeb = $.datepicker.formatDate('yy-mm-dd', new Date());
    var datefin = $.datepicker.formatDate('yy-mm-dd', new Date());
    var nomFichier = "";
    var pendingList = [];

    function sendAll() {
        pendingList.forEach(function (data) { data.submit(); });
        pendingList = [];
    }

    var url = window.location.hostname === 'blueimp.github.io' ?
        '//jquery-file-upload.appspot.com/' : 'upload/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        maxNumberOfFiles: 1,
        autoUpload: false,
        async : false,
        add: function (e, data) {
            pendingList = [];
            pendingList.push(data);
        },

        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                nomFichier = file.name;
                //$('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
            $('#progress .progress-bar').css(
                'background-color',
                '#286090'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    function $_GET(param) {
        var vars = {};
        window.location.href.replace(location.hash, '').replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m, key, value) { // callback
                vars[key] = value !== undefined ? value : '';
            }
        );

        if (param) {
            return vars[param] ? vars[param] : null;
        }
        return vars;
    }

    var profil_raf=0;
    var profil_caisse=0;
    function protection(){
        $.ajax({
            url: "indexServeur.php?page=connexionProctection",
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $(data).each(function() {
                    admin = this.PROT_Right;
                    if(this.ProfilName=="RAF")
                        profil_raf=1;
                    if(this.ProfilName=="CAISSE")
                        profil_caisse=1;
                });
            }
        });
    }
    protection();

    $.ajax({
        url: 'indexServeur.php?page=banque',
        method: 'GET',
        dataType: 'json',
        async : false,
        success: function (data) {
            for (i = 0; i < data.length; i++) {
                var option = $('<option />');
//                if (i == 0)option.attr('selected', 'selected');
                option.attr('value', data[i].CG_Num).text(data[i].CG_Intitule);
                $('#banque').append(option);
            }
        }
    });

    $('.combocaisse').focusout(function () {
        $.ajax({
            url: 'indexServeur.php?page=getReglemementByCaisse&CA_No=' + $('#caisseComplete').val(),
            method: 'GET',
            dataType: 'json',
            async : false,
            success: function (data) {

            }
        });
    });
    $('#imprimer').click(function(){
        var impression="export/exportMouvementCaisse.php?caisseComplete="+$("#caisseComplete").val()+"&type_mvt_ent="+$("#type_mvt_ent").val()+"&dateReglementEntete_deb="+$("#dateReglementEntete_deb").val()+"&dateReglementEntete_fin="+$("#dateReglementEntete_fin").val()+"";
        window.open(impression,'_blank');
    });
    function valeurCaisse(){
        if($('#type_mvt_lig').val()==5){
            $("#divCaisseDest").fadeOut();
            $.ajax({
                url: 'indexServeur.php?page=getCompteEntree',
                method: 'GET',
                dataType: 'json',
                async : false,
                success: function (data) {
                    $("#banque").val(data[0].P_CreditCaisse);

                }
            });
            $("#libelleRec").prop("disabled",false);
            $("#banque").prop("disabled",false);
            $("#divJournalDest").fadeOut();
        }
        if($('#type_mvt_lig').val()==16){
            $("#divCaisseDest").fadeIn();
            $("#libelleRec").prop("disabled",false);
            $("#banque").prop("disabled",false);
            $("#divJournalDest").fadeOut();
        }
        if($('#type_mvt_lig').val()==4){
            $("#divCaisseDest").fadeOut();
            $("#divJournalDest").fadeOut();
            $.ajax({
                url: 'indexServeur.php?page=getCompteSortie',
                method: 'GET',
                dataType: 'json',
                async : false,
                success: function (data) {
                    $("#banque").val(data[0].P_DebitCaisse);
                }
            });
            $("#libelleRec").attr("readonly", false);
            $("#banque").prop("disabled",false);
        }
        if($('#type_mvt_lig').val()==2){
            $("#divCaisseDest").fadeOut();
            $("#divJournalDest").fadeOut();
            $("#banque").val(0);
            $("#libelleRec").attr("readonly", true);
            $("#banque").prop("disabled",true);
            $("#libelleRec").val("Décl. fond de caisse "+$("#dateReglement").val());
        }
        if($('#type_mvt_lig').val()==6){
            $("#divCaisseDest").fadeOut();
            $("#divJournalDest").fadeIn();
            $("#banque").val(0);
            $.ajax({
                url: 'indexServeur.php?page=getCompteSortie',
                method: 'GET',
                dataType: 'json',
                async : false,
                success: function (data) {
                    $("#banque").val(data[0].P_DebitCaisse);
                }
            });
            $("#libelleRec").attr("readonly", false);
            $("#banque").prop("disabled",false);
        }
    }

    $("#dateReglement").focusout(function(){
        if($('#type_mvt_lig').val()==2){
            $("#libelleRec").val("Déclaration fond de caisse "+$("#dateReglement").val());
        }
    });

    valeurCaisse();

    $("#validerRec").click(function (){
        ajoutReglementCaisse();
    });

    $("#dateReglement").keydown(function (event) {
        if(event.keyCode == 13)
            ajoutReglementCaisse();
    });

    $("#libelleRec").keydown(function (event) {
        if(event.keyCode == 13)
            ajoutReglementCaisse();
    });

    $("#montantRec").keydown(function (event) {
        if(event.keyCode == 13)
            ajoutReglementCaisse();
    });
    function ajoutReglementCaisse(){
        if($("#type_mvt_lig").val()!=6 || ($("#journalRec").val()!="" && $("#type_mvt_lig").val()==6)) {
            if ($("#caisseLigne").val() != -1 && $("#montantRec").val().replace(/ /g, "") != "" && $("#dateReglement").val() != "") {
                $("#dateReglementEntete_deb_ligne").val($("#dateReglementEntete_deb").val());
                $("#dateReglementEntete_fin_ligne").val($("#dateReglementEntete_fin").val());
                $("#type_mvt_ent_ligne").val($("#type_mvt_ent").val());
                $("#caisseComplete_ligne").val($("#caisseComplete").val());
                $("#form_ligne").submit();
            } else alert("Saississer un montant et choississez une caisse !");
        }else{
            alert("Veuillez choisir le code journal !");
        }
    }


    function ajoutReglementCaisseSubmit(){
        if($("#caisseLigne").val()!=-1 && $("#montantRec").val().replace(/ /g,"")!=""&& $("#dateReglement").val()!=""){
            var paramOr = "";
            if($("#affaire").val()!=undefined) paramOr = "&CA_Num="+$("#affaire").val();
            $.ajax({
                    url: 'indexServeur.php?page=getCaisseMvtEntree&rg_typereg='+$("#type_mvt_lig").val()+'&CA_No=' + $('#caisseLigne').val()+'&date=' + $('#dateReglement').val()+'&montant=' + $('#montantRec').val().replace(/ /g,"")+'&libelle=' + $('#libelleRec').val()+'&cg_num=' + $('#banque').val()+'&user='+$("#userName").html(),
                method: 'GET',
                async:false,
                dataType: 'html',
                async : false,
                data : "CA_No_Dest="+$("#CA_No_Dest").val()+paramOr,
                success: function (data) {
                    listeReglementCaisse();
                },
                error: function(data) {
                }
            });
            $("#dateReglement").val(new Date().toISOString().slice(0, 10));
            if($("#type_mvt_lig").val()!=2) $("#libelleRec").val("");
            $("#montantRec").val("");
        } else alert("Saississer un montant et choississez une caisse !");
    }

    function listeReglementCaisse(){
        var caisse = $('#caisseComplete').val();
        sommeTotal = 0;
        $.ajax({
            url: 'indexServeur.php?page=listeReglementCaisseFormat&datedeb='+$("#dateReglementEntete_deb").val()+'&datefin=' + $('#dateReglementEntete_fin').val()+'&ca_no=' + caisse +'&type=' + $('#type_mvt_ent').val(),
            method: 'GET',
            dataType: 'html',
            async : false,
            data : "flagAffichageValCaisse="+$("#flagAffichageValCaisse").val()+"&flagCtrlTtCaisse="+$("#flagCtrlTtCaisse").val(),
            success: function (data) {
                $(".reglement").remove();
                $("#tableRecouvrement").append(data);
                modifReglement();
            }
        });
    }

    function typeCaisse(val){
        if(val==5) return "Entrée";
        if(val==4) return "Sortie";
        if(val==2) return "Fond de caisse";
        if(val==3) return "Vrst bancaire";
    }

    function tableauRecouvrement(i,classe,RG_No,RG_Date,RG_Libelle,RG_Montant,CA_Intitule,CO_Nom,RG_Piece,RG_TypeReg,RG_Type,RG_Banque,Lien_Fichier,affaire){
        if (i % 2 == 0)
            classe = "info";
        if(RG_TypeReg==4 || RG_TypeReg==3)
            RG_Montant = RG_Montant * -1;
        sommeTotal = sommeTotal + RG_Montant;
        var finTexte = "";
        var fichier="";
        if(Lien_Fichier!=null)
            fichier="<a target='_blank' href='upload/files/"+Lien_Fichier+"' class='fa fa-download'></a>";
        if(RG_Banque==1 && RG_Type==4)
            finTexte = "<td>"+fichier+"</td><td><input id='check_vrst' type='checkbox' checked disabled/></td>";
        else
        if(RG_TypeReg==3)
            finTexte = "<td>"+fichier+"</td><td><input  id='check_vrst' type='checkbox' disabled/></td>";
        else finTexte = "<td></td>";

        var blocAffaire ="";
        if($("#affaire").val()!=undefined){
            blocAffaire = "<td style='display:none' id='Affaire'>" +affaire+ "</td>";
        }
        var itemTable = "<tr class= 'reglement " + classe + "' id='reglement_" + RG_No + "'>"
            +"<td style='color:blue;text-decoration:underline' id='RG_No'>"+RG_No+"</td><td id='RG_Piece'>"+RG_Piece+"</td><td id='RG_Date'>" + $.datepicker.formatDate('dd-mm-yy', new Date(RG_Date)) + "</td>"
            +"<td id='RG_Libelle'>" + RG_Libelle + "</td><td id='RG_Montant'>" + RG_Montant + "</td>"
            +"<td id='CA_Intitule'>" + CA_Intitule + "</td><td id='CO_Nom'><span id='RG_No' style='visibility:hidden'>"+RG_No+"</span>"+ CO_Nom + "</td><td id='RG_TypeReg'>"+typeCaisse(RG_TypeReg)+"</td>"+blocAffaire;



        if($("#flagAffichageValCaisse").val()==0)
            itemTable = itemTable + "<td id='RG_Modif'><i class='fa fa-pencil fa-fw'></i></td>";
        if($("#flagCtrlTtCaisse").val()==0)
            itemTable = itemTable + "<td id='RG_Suppr'><i class='fa fa-trash-o'></i></td>";
            itemTable = itemTable +finTexte+"</tr>";

        $("#tableRecouvrement").append(itemTable);



    }

    $("#recherche").click(function (){
        listeReglementCaisse();
    });

    $('#type_mvt_lig').change(function () {
        valeurCaisse();
    });
    $("#blocModal").hide();
    $("#valide_vrst").hide();

    function modifReglement(){
        $("tr[id^='reglement_']").each(function() {
            var elem = $(this);
            var libelle = elem.find("#RG_Libelle").html();
            var montant = elem.find("#RG_Montant").html();
            if($("#affaire").val()!=undefined)
                var affaire = elem.find("#Affaire").html();
            var typemvt = elem.find("#RG_TypeReg").html();
            var check_vrst = elem.find("#check_vrst");
            var rg_no = elem.find("#RG_No").html();
            elem.find("#RG_Suppr").click(function () {
                $("<div></div>").dialog({
                    resizable: false,
                    height: "auto",
                    width: 400,
                    title: "Voulez vous supprimez le mouvement "+rg_no,
                    modal: true,
                    buttons: {
                        "Oui": function () {
                            $.ajax({
                                url: 'indexServeur.php?page=supprRglt',
                                method: 'GET',
                                dataType: 'html',
                                async: false,
                                data: "RG_No=" + rg_no+"&MvtCaisse=1",
                                success: function (data) {
                                    elem.fadeOut(300, function () {
                                        listeReglementCaisse();
                                    });
                                }
                            });
                            $( this ).dialog( "close" );
                        },
                        "Non": function () {
                            $( this ).dialog( "close" );
                        }
                    }
                });
            });

            elem.find("#RG_Modif").click(function () {
                if (typemvt == "Fond de caisse") $("#libelleRecModif").attr("readonly", true);
                else $("#libelleRecModif").attr("readonly", false);
                if (elem.find("#RG_TypeReg").html() == "Vrst bancaire" && !check_vrst.is(':checked')) {
                    if (!$("#caisseComplete").is(':disabled')) {
                        $("#libelle_date").val($.datepicker.formatDate('yy-mm-dd', new Date()));
                        $("#valide_vrst").dialog({
                            resizable: false,
                            height: "auto",
                            width: 1000,
                            modal: true,
                            buttons: {
                                "Valider": function () {
                                    var bordereau = $("#bordereau").val();
                                    var libelle_banque = $("#libelle_banque").val();
                                    var libelle_date = $("#libelle_date").val();
                                    var rg_libelle = "VRST_" + bordereau + "_" + libelle_banque + "_" + libelle_date;
                                    if (bordereau != "" && libelle_banque != "") {
                                        sendAll();
                                        $.ajax({
                                            url: 'indexServeur.php?page=updateReglementCaisseDAF&RG_No=' + rg_no + '&RG_Libelle=' + rg_libelle,
                                            method: 'GET',
                                            dataType: 'html',
                                            async: false,
                                            data: "nomFichier=" + nomFichier,
                                            success: function (data) {
                                                listeReglementCaisse();
                                                $("#bordereau").val("");
                                                $("#libelle_banque").val("");
                                                $("#valide_vrst").dialog("close");
                                            }
                                        });
                                    } else {
                                        alert("Saisisser un bordereau et un libellé !");
                                    }
                                }
                            }
                        });
                    }
                } else {
                    if (1==1/*admin == 1 && profil_raf == 0*/) {
                        if (typemvt == "Sortie") montant = montant * -1;
                        $("#montantRecModif").val(montant);
                        $("#libelleRecModif").val(libelle);
                        if($("#affaire").val()!=undefined)
                            $("#AffaireRecModif").val(affaire);
                        $("#blocModal").show();
                        $("#blocModal").dialog({
                            resizable: false,
                            height: "auto",
                            width: 500,
                            modal: true,
                            buttons: {
                                "Valider": function () {
                                    var paramOr = "";
                                        if($("#AffaireRecModif").val()!=undefined) paramOr = "CA_Num="+$("#AffaireRecModif").val();
                                    $.ajax({
                                        url: 'indexServeur.php?page=updateReglementCaisse&RG_No=' + rg_no + '&RG_Montant=' + $("#montantRecModif").val().replace(/ /g,"") + '&RG_Libelle=' + $("#libelleRecModif").val(),
                                        method: 'GET',
                                        dataType: 'html',
                                        data : paramOr,
                                        async: false,
                                        success: function (data) {
                                            listeReglementCaisse();
                                        }
                                    });
                                    $(this).dialog("close");
                                }
                            }
                        });
                    }
                }
            });
        });
    }
    modifReglement();


    $("#montantRec").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0,00',
        allowPlus: true,
        allowMinus: true
    });

    $("#montantRecModif").inputmask({
        'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });
    $("#dateReglementEntete_deb").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});
    $("#dateReglementEntete_fin").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});
    $("#dateReglement").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});
    $("#libelle_date").datepicker({dateFormat: "yy-mm-dd", altFormat: "yy-mm-dd"});
    if($("#postData").val()==0) {
        $("#dateReglementEntete_deb").datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
        $("#dateReglementEntete_fin").datepicker({dateFormat: "yy-mm-dd"}).datepicker("setDate", new Date());
    }
    $("#dateReglement").datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date());
    if($("#dateReglement").is('[readonly]'))
        $("#dateReglement").unbind();
    $("#libelle_date").datepicker({dateFormat:"yy-mm-dd"}).datepicker("setDate",new Date());
});