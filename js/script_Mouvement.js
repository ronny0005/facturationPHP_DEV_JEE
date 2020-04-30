jQuery(function($){
    var modification = false;
    var lien="../../ServeurFacturationPHP/index.php?";
    var protect = 0;
    var listeMouvement;
    var impressionMouvement;
    var jeton = 0;
    var societe = "";

    var isModif = $("#isModif").val()
    var isVisu = $("#isVisu").val()
    var typeFac = $("#typeFacture").val()

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

    function returnDate(str){
        return "20"+str.substring(4,6)+"-"+str.substring(2,4)+"-"+str.substring(0,2);
    }


    $("#prix, #quantite, #quantite_dest, #prix_dest").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: false
    });

    $("#quantite_stock").inputmask({   'alias': 'decimal',
        'groupSeparator': ' ',
        'autoGroup': true,
        'digits': 2,
        rightAlign: true,
        'digitsOptional': false,
        'placeholder': '0.00',
        allowPlus: true,
        allowMinus: true
    });

    function setArticle() {
        $("#reference").autocomplete({
            source: "indexServeur.php?page=getArticleByRefDesignation&type=" + typeFac + "&DE_No=" + $("#DE_No").val(),
            autoFocus: true,
            select: function (event, ui) {
                event.preventDefault();
                $("#designation").val(ui.item.AR_Design)
                $("#reference").val(ui.item.AR_Ref)
                $("#AR_Ref").val(ui.item.AR_Ref)

                if (!modification)
                    $("#prix").val(Math.round(ui.item.AR_PrixAch * 100) / 100);
                alimente_qteStock($("#reference").val(),0);
                $("#quantite").focus()

            }
        })


        $("#reference_dest").autocomplete({
            source: "indexServeur.php?page=getArticleByRefDesignationMvtTransfert&type=" + $("#typeFacture").val() + "&DE_No=" + $("#CO_No").val(),
            autoFocus: true,
            select: function (event, ui) {
                event.preventDefault();
                $("#designation_dest").val(ui.item.AR_Design)
                $("#reference_dest").val(ui.item.AR_Ref)
                $("#AR_Ref_Dest").val(ui.item.AR_Ref)

                if (!modification)
                    $("#prix_dest").val(Math.round(ui.item.AR_PrixAch * 100) / 100);
                alimente_qteStock($("#reference_dest").val(), 1);
                $("#quantite_dest").focus()

            }
        })
    }
        setArticle()


    function verifLigne(){
        if($("#quantite").val().replace(/ /g,"")!="" && $("#quantite_dest").val()!="" && $("#prix").val().replace(/ /g,"")!="" && $("#reference").val()!="" && $("#reference_dest").val()!="" )
            return true;
        else return false;
    }

    $("#quantite_dest").keyup(function(){
        calculPrixDest()
    })

    $("#quantite").keyup(function(){
        calculPrixDest()
    })

    $("#prix").keyup(function(){
        calculPrixDest()
    })

    function calculPrixDest(){
        var pfinal=0;
        if($("#quantite_dest").val()!=0)
            pfinal = Math.round(($("#prix").val().replace(/ /g,"")*$("#quantite").val().replace(/ /g,""))/$("#quantite_dest").val()*100)/100;
        if($("#quantite").val().replace(/ /g,"")!="" &&  $("#prix").val().replace(/ /g,"")!="" && $("#quantite_dest").val()!="")
            $("#prix_dest").val(pfinal);
    }

    function ajout_ligne(e) {
            if (e.keyCode == 13) {
                if ((typeFac == "Transfert_detail" && verifLigne()) || typeFac != "Transfert_detail") {
                    var compl_dest = "";
                    if (typeFac == "Transfert_detail") {
                        var complref = "";
                        if (!modification)
                            complref = "&designation_dest=" + $("#AR_Ref_Dest").val();
                        else
                            complref = "&designation_dest=" + $("#AR_Ref_Dest").val();
                        compl_dest = "&quantite_dest=" + $("#quantite_dest").val().replace(/ /g, "") + "&prix_dest=" + $("#prix_dest").val().replace(/ /g, "") + complref;
                    }
                    if ($("#quantite").val().replace(/ /g, "") > 0 && (typeFac == "Entree" || (Math.round(Math.round($("#quantite_stock").val().replace(/ /g, "")) + Math.round($("#ADL_Qte").val())) >= Math.round($("#quantite").val().replace(/ /g, ""))))) {
                        var acte = "ajout_ligne";
                        if (modification) {
                            modification = false;
                            acte = "modif";
                            $.ajax({
                                url: "traitement/" + fichierTraitement() + "?type_fac=" + typeFac + "&acte=" + acte + "&entete=" + $("#n_doc").val() + "&id_sec=" + $("#idSec").val() + "&quantite=" + $("#quantite").val().replace(/ /g, "") + "&prix=" + $("#prix").val().replace(/ /g, "") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarqEntete").val() + compl_dest + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                                method: 'GET',
                                async: false,
                                dataType: 'json',
                                data: "cbMarqEntete=" + $("#cbMarqEntete").val() +"&PROT_No="+$("#PROT_No").val()+"&typeFacture="+$("#typeFacture").val(),
                                success: function (data) {
                                        alimLigne();
                                        tr_clickArticle();
                                        $('#reference').prop('disabled', false);
                                        $('#reference_dest').prop('disabled', false);
                                        $('#reference').val("");
                                        $('#designation').val("");
                                        if (typeFac == "Transfert_detail") {
                                            $("#article_" + $("#cb_Marq").val()).find("#DL_Qte_dest").html((Math.round(data[0].DL_Qte_Dest * 100) / 100));
                                            $("#article_" + $("#cb_Marq").val()).find("#DL_MontantHT_dest").html(Math.round(data[0].DL_MontantHT_Dest));
                                        }
                                        $('#reference').focus();
                                        $("#ADL_Qte").val(0);
                                },
                                error: function (resultat, statut, erreur) {
                                    alert(resultat.responseText);
                                }
                            });
                        } else {
                            alert("ajout")
                            $.ajax({
                                url: "traitement/" + fichierTraitement() + "?acte=" + acte + "&type_fac=" + typeFac + "&id_sec=0&quantite=" + $("#quantite").val().replace(/ /g, "") + "&designation=" + $("#AR_Ref").val() + "&prix=" + $("#prix").val().replace(/ /g, "") + "&remise=" + $("#remise").val() + "&cbMarq=" + $("#cbMarqEntete").val() + "&userName=" + $("#userName").html() + "&machineName=" + $("#machineName").html(),
                                method: 'GET',
                                async: false,
                                dataType: 'json',
                                data: "cbMarqEntete=" + $("#cbMarqEntete").val() +"&PROT_No="+$("#PROT_No").val()+compl_dest,
                                success: function (data) {
                                    alimLigne();
                                    tr_clickArticle();
                                    $('#reference').focus();
                                    $("#ADL_Qte").val(0);
                                },
                                error: function (resultat, statut, erreur) {
                                    alert(resultat.responseText);
                                }
                            });
                        }
                        calculTotal();
                    } else {
                        if ($("#quantite").val().replace(/ /g, "") <= 0) alert("La quantité doit être supérieure ou égale à 0.")
                        else
                            alert("La quantité doit être inférieure ou égale à " + (Math.round($("#ADL_Qte").val()) + Math.round($("#quantite_stock").val().replace(/ /g, ""))) + " !");
                    }
                }
            }
            //}else alert("La quantité doit être supérieur à 0 !");
        }

        function alimLigne() {
            $("#tableLigne > tbody").html("");
            $.ajax({
                url: 'traitement/Facturation.php?acte=ligneFactureStock',
                method: 'GET',
                dataType: 'html',
                async: false,
                data: "PROT_No="+$("#PROT_No").val()+"&cbMarqEntete=" + $("#cbMarqEntete").val() + "&typeFac=" + typeFac + "&flagPxRevient=" + $("#flagPxRevient").val(),
                success: function (data) {
                    $("#tableLigne > tbody").html(data);
                },
                error: function (data) {

                }
            });
        }

        function suppression(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP) {
            $("<div>Voulez vous supprimer " + AR_Ref + " ?</div>").dialog({
                resizable: false,
                height: "auto",
                width: 500,
                modal: true,
                buttons: {
                    "Oui": {
                        class: 'btn btn-primary',
                        text: 'Oui',
                        click: function () {
                            if (typeFac == "Transfert" || typeFac == "Transfert_confirmation" || typeFac == "Entree") {
                                var de_no = $("#DE_No").val();
                                if(typeFac =="Transfert")
                                    de_no = $("#CO_No").val()
                                var texte = $("#depot").text();
                                verifSupprAjout(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP, de_no, texte);
                            } else
                                supprElement(cbMarq, id_sec);

                            $(this).dialog("close");
                        }
                    },
                    "Non": {
                        class: 'btn btn-primary',
                        text: 'Non',
                        click: function () {
                            $(this).dialog("close");
                        }
                    }
                }
            });
        }




    $("#tableLigne").DataTable(
        {
            scrollY:        "300px",
            paging:         false,
            searching:      false,
            scrollCollapse: true,
            fixedColumns:   true,
            info:           false,
            "language": {
                "url":      "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
            }
        }
    )
        function tr_clickArticle() {
            $("tr[id^='article']").each(function () {
                $(this).unbind();
                var cbMarq = $(this).find("#cbMarq").html();
                var id_sec = $(this).find("#id_sec").html();
                var DL_Qte = $(this).find("#DL_Qte").html();
                var AR_Ref = $(this).find("#AR_Ref").html();
                var DL_Design = $(this).find("#DL_Design").html();
                var DL_Remise = $(this).find("#DL_Remise").html();
                var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
                var DL_CMUP = $(this).find("#DL_CMUP").html();
                $(this).find("#suppr_" + cbMarq).click(function () {
                    suppression(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP);
                });
                $(this).find("#AR_Ref").click(function () {
                    fiche_article(AR_Ref);
                });
            });

            if (typeFac != "Transfert" && typeFac != "Transfert_confirmation") {
                $("tr[id^='article']").dblclick(function () {
                    $(this).unbind();
                    var cbMarq = $(this).find("#cbMarq").html();
                    var DL_Qte = $(this).find("#DL_Qte").html();
                    DL_Qte = DL_Qte.replace(",", ".");
                    DL_Qte = DL_Qte.replace(/ /g, "");
                    var AR_Ref = $(this).find("#AR_Ref").html();
                    var DL_Design = $(this).find("#DL_Design").html();
                    var DL_Remise = $(this).find("#DL_Remise").html();
                    var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
                    DL_PrixUnitaire = DL_PrixUnitaire.replace(",", ".");
                    DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g, "");
                    var id_sec = $(this).find("#id_sec").html();
                    valideReference(AR_Ref);
                    $("#reference").val(AR_Ref);
                    $('#designation').val(DL_Design);
                    $('#remise').val(DL_Remise);
                    $('#prix').val(DL_PrixUnitaire);
                    $('#quantite').val(DL_Qte);
                    $('#ADL_Qte').val(DL_Qte);
                    $('#APrix').val(DL_PrixUnitaire);
                    $('#cb_Marq').val(cbMarq);
                    $('#idSec').val(id_sec);

                    $('#reference').prop('disabled', true);
                    if (typeFac == "Transfert_detail") {
                        $('#reference_dest').prop('disabled', true);
                        $('#ADL_Qte_dest').val($(this).find("#DL_Qte_dest").html());
                        $('#APrix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                        $('#quantite_dest').val($(this).find("#DL_Qte_dest").html());
                        $('#prix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                        $('#designation_dest').val($(this).find("#DL_Design_dest").html());
                        $('#reference_dest').val($(this).find("#DL_Design_dest").html());
                        $('.comboreferenceDest').val($(this).find("#AR_Ref_Dest").html());
                    }
                    alimente_qteStock(AR_Ref);
                    modification = true;
                });

                $("tr[id^='article']").dblclick(function () {
                    $(this).unbind();
                    var cbMarq = $(this).find("#cbMarq").html();
                    var DL_Qte = $(this).find("#DL_Qte").html();
                    DL_Qte = DL_Qte.replace(",", ".");
                    DL_Qte = DL_Qte.replace(/ /g, "");
                    var AR_Ref = $(this).find("#AR_Ref").html();
                    var DL_Design = $(this).find("#DL_Design").html();
                    var DL_Remise = $(this).find("#DL_Remise").html();
                    var DL_PrixUnitaire = $(this).find("#DL_PrixUnitaire").html();
                    DL_PrixUnitaire = DL_PrixUnitaire.replace(",", ".");
                    DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g, "");
                    var id_sec = $(this).find("#id_sec").html();
                    valideReference(AR_Ref);
                    $('#designation').val(DL_Design);
                    $('#remise').val(DL_Remise);
                    $('#prix').val(DL_PrixUnitaire);
                    $('#reference').val(AR_Ref);
                    $('#quantite').val(DL_Qte);
                    $('#ADL_Qte').val(DL_Qte);
                    $('#APrix').val(DL_PrixUnitaire);
                    $('#cb_Marq').val(cbMarq);
                    $('#idSec').val(id_sec);

                    if (typeFac == "Transfert_detail") {
                        $('.comboreferenceDest').prop('disabled', true);
                        $('#ADL_Qte_dest').val($(this).find("#DL_Qte_dest").html());
                        $('#APrix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                        $('#quantite_dest').val($(this).find("#DL_Qte_dest").html());
                        $('#prix_dest').val(Math.round(($(this).find("#DL_MontantHT_dest").html() / $(this).find("#DL_Qte_dest").html()) * 100) / 100);
                        $('#designation_dest').val($(this).find("#DL_Design_dest").html());
                        $('#reference_dest').val($(this).find("#DL_Design_dest").html());
                        $('.comboreferenceDest').val($(this).find("#AR_Ref_Dest").html());
                    }
                    alimente_qteStock(AR_Ref);
                    modification = true;
                });
            }

            $("td[id^='modif_']").click(function () {
                $(this).unbind();
                $('#reference').prop('disabled', true);
                var cbMarq = $(this).parent('tr').find("#cbMarq").html();
                var DL_Qte = $(this).parent('tr').find("#DL_Qte").html();
                DL_Qte = DL_Qte.replace(",", ".");
                DL_Qte = DL_Qte.replace(/ /g, "");
                var AR_Ref = $(this).parent('tr').find("#AR_Ref").html();
                var DL_Design = $(this).parent('tr').find("#DL_Design").html();
                var DL_Remise = $(this).parent('tr').find("#DL_Remise").html();
                var DL_PrixUnitaire = $(this).parent('tr').find("#DL_PrixUnitaire").html();
                DL_PrixUnitaire = DL_PrixUnitaire.replace(",", ".");
                DL_PrixUnitaire = DL_PrixUnitaire.replace(/ /g, "");
                var id_sec = $(this).parent('tr').find("#id_sec").html();
                valideReference(AR_Ref);
                $('#designation').val(DL_Design);
                $('#remise').val(DL_Remise);
                $('#prix').val(DL_PrixUnitaire);
                $('#reference').val(AR_Ref);
                $('#quantite').val(DL_Qte);
                $('#ADL_Qte').val(DL_Qte);
                $('#APrix').val(DL_PrixUnitaire);
                $('#cb_Marq').val(cbMarq);
                $('#idSec').val(id_sec);

                if (typeFac == "Transfert_detail") {
                    $('.comboreferenceDest').prop('disabled', true);
                    $('#ADL_Qte_dest').val($(this).parent('tr').find("#DL_Qte_dest").html());
                    $('#APrix_dest').val(Math.round(($(this).parent('tr').find("#DL_MontantHT_dest").html() / $(this).parent('tr').find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#quantite_dest').val($(this).parent('tr').find("#DL_Qte_dest").html());
                    $('#prix_dest').val(Math.round(($(this).parent('tr').find("#DL_MontantHT_dest").html() / $(this).parent('tr').find("#DL_Qte_dest").html()) * 100) / 100);
                    $('#designation_dest').val($(this).parent('tr').find("#DL_Design_dest").html());
                    $('#reference_dest').val($(this).parent('tr').find("#DL_Design_dest").html());
                    $('.comboreferenceDest').val($(this).parent('tr').find("#AR_Ref_Dest").html());
                }
                alimente_qteStock(AR_Ref);
                modification = true;
            });

        }

        tr_clickArticle();

        function verifSupprAjout(cbMarq, id_sec, AR_Ref, DL_Qte, DL_CMUP, de_no, de_intitule) {
            $.ajax({
                url: 'indexServeur.php?page=isStockDENo&AR_Ref=' + AR_Ref + '&DE_No=' + de_no + '&DL_Qte=' + DL_Qte,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var test = parseInt(data[0].isSuppr);
                    var stock = parseFloat(data[0].AS_QteSto);
                    if (test == 0)
                        supprElement(cbMarq, id_sec);
                    else
                        alert("la quantité du depot " + de_intitule + " est inssufisante ! (Qte : " + stock.toLocaleString() + ")");
                },
                error: function (data) {
                    alert("la quantité du depot " + de_intitule + " est inssufisante ! (Qte : 0)");
                }
            });
        }

    function fiche_article(AR_Ref){
        window.open('ficheArticle-'+AR_Ref+'-1', "Fiche Article", "height=600,width=600");
    }


    function valideReference(reference) {
            var AR_Ref = reference;
            $.ajax({
                url: "indexServeur.php?page=getPrixClient&AR_Ref=" + reference + "&N_CatTarif=1&N_CatCompta=1",
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    alimente_qteStock(reference);
                }
            });
        }

        function supprElement(cbmarq_prem, cbmarq_sec) {
            $.ajax({
                url: "traitement/" + fichierTraitement() + "?acte=suppr&PROT_No="+$("#PROT_No").val()+"&id=" + cbmarq_prem + "&id_sec=" + cbmarq_sec,
                method: 'GET',
                dataType: 'html',
                success: function (data) {
                    modification = false;
                    $("#reference").prop('disabled', false);
                    $("#article_" + cbmarq_prem).fadeOut(300, function () {
                        $(this).remove();
                    });
                    calculTotal();
                }
            });
        }


        function entete_document() {
            if ($("#cbMarqEntete").val()==0 && isVisu == 0)
                $.ajax({
                    url: 'traitement/Facturation.php?acte=entete_document',
                    method: 'GET',
                    dataType: 'json',
                    async: false,
                    data: '&do_souche=0&type_fac=' + typeFac,
                    success: function (data) {
                        $("#n_doc").val(data.DC_Piece);
                    }
                });
        }

        entete_document()

        function calculTotal() {
            var montantht = 0;
            var totalqte = 0;
            var montanthtDest = 0;
            var totalqteDest = 0;
            var i = 0;
            $.ajax({
                url: "traitement/Facturation.php?acte=liste_article&cbMarq=" + $("#cbMarqEntete").val() + "&type_fac=" +typeFac,
                method: 'GET',
                dataType: 'html',
                success: function (data) {
                    dataTable = data;
                    montantht = 0;
                    totalqte = 0;
                    montanthtDest = 0;
                    totalqteDest = 0;
                    if (typeFac == "Transfert" || typeFac == "Transfert_confirmation") {
                        montantht = (montantht / 2);
                        totalqte = (totalqte / 2);
                    }
                    if (dataTable.length > 0) {
                        $('#imprimer').prop('disabled', false);
                        $('#annuler').prop('disabled', false);
                        $('#valider').prop('disabled', false);
                        bloque_entete();
                        actionClient(true);
                    } else {
                        $('#imprimer').prop('disabled', true);
                        $('#annuler').prop('disabled', true);
                        $('#valider').prop('disabled', true);

                        if ($("#cbMarqEntete").val() == 0)
                            actionClient(false);
                        else
                            bloque_entete();
                    }

                    if ($("#isVisu").val() == 1)
                        $('#imprimer').prop('disabled', false);

                    $("#piedPage").html(data);
                    $("#totalht").html(montantht);
                    $("#totalhtDest").html(montanthtDest);
                    $("#totalqte").html(totalqte);
                    $("#totalqteDest").html(totalqteDest);
                    $("#reference").val("");
                    $("#reference_dest").val("");
                    $("#quantite").val("");
                    $("#prix").val("");
                    $("#carat").val("");
                    $("#quantite_dest").val("");
                    $("#prix_dest").val("");
                    $("#quantite_stock").val("");
                    $("#remise").val("");
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }

        calculTotal()


    $('#imprimer').click(function(){
        choixFormat();
    });

    function doImprim() {
        $.ajax({
            url: "traitement/Facturation.php?acte=doImprim"+"&cbMarq="+$("#cbMarqEntete").val(),
            method: 'GET',
            dataType: 'json',
            async: false,
            success: function (data) {
            }
        });
    }
    function choixFormat(){
        doImprim();
        $("<div>Choix du format</div>").dialog({
            resizable: false,
            height: "auto",
            width: "100",
            modal: true,
            buttons: {
                "A4": {
                    class: 'btn btn-primary',
                    text: 'A4',
                    click: function () {
                        window.open(impressionMouvement + "-A4", '_blank');
                        window.location.replace(listeMouvement);
                    }
                },
                "A5": {
                    class: 'btn btn-primary',
                    text: 'A5',
                    click: function () {
                        window.open(impressionMouvement + "-A5", '_blank');
                        window.location.replace(listeMouvement);
                    }
                }
            }
        });
    }
    $('#valider').click(function(){
        if(typeFac == "Transfert_valid_confirmation"){
            $.ajax({
                url: 'traitement/facturation.php?page=confirmation_document&acte=confirmation_document&cbMarq=' + $("#cbMarqEntete").val(),
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    alert('Le transfert a été créé !');
                    window.location.replace(listeMouvement);
                },
                error: function (resultat, statut, erreur) {
                    alert(resultat.responseText);
                }
            });
        }else {
            window.location.replace(listeMouvement);
            $("#add_err").css('display', 'none', 'important');
            $("#add_err").css('display', 'inline', 'important');
            var typMvt = "";
            if (typeFac == "Sortie") typMvt = " de sortie ";
            if (typeFac == "Entree") typMvt = " d'entrée ";
            if (typeFac == "Transfert") typMvt = " de transfert ";
            if (typeFac == "Transfert_detail") typMvt = " de transfert ";
            alert('Mouvement ' + typMvt + ' enregistré!');
            $("#add_err").html('<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong></strong>Mouvement ' + typMvt + ' enregistré!</div>');
        }
    });

        function bloque_entete() {
            $("#depot").prop('disabled', true);
            $("#souche").prop('disabled', true);
            $("#affaire").prop('disabled', true);
            $("#collaborateur").prop('disabled', true);
            $("#dateentete").prop('disabled', true);
        }

        function actionClient(val) {
            $("#depot").prop('disabled', val);
            $("#collaborateur").prop('disabled', val);
            $("#dateentete").prop('disabled', val);
            $("#souche").prop('disabled', val);
        }

        $("#prix").keydown(function (event) {
            if (event.keyCode == 13) ajout_ligne(event);
        });
        $("#quantite").keydown(function (event) {
            if (event.keyCode == 13) ajout_ligne(event);
        });
        $("#quantite_dest").keydown(function (event) {
            if (event.keyCode == 13) ajout_ligne(event);
        });

        $("#remise").keydown(function (event) {
            if (event.keyCode == 13) ajout_ligne(event);
            else isRemise($("#remise"), event);
        });

    function alimente_qteStock(reference,dest) {
        de_no = $("#DE_No").val();
        if(dest==1) de_no = $("#CO_No").val();
        $.ajax({
            url: 'indexServeur.php?page=isStock&AR_Ref=' + reference + '&DE_No=' + de_no,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $(data).each(function () {
                    if ($_GET("type") != "Entree")
                        if (!modification)
                            if (this.AS_QteSto > 0) {
                                if (dest==1)
                                    $("#prix_dest").val(Math.round((this.AS_MontSto / this.AS_QteSto) * 100) / 100);
                                else
                                    $("#prix").val(Math.round((this.AS_MontSto / this.AS_QteSto) * 100) / 100);
                            }
                            else {
                                if (dest==1)
                                    $("#prix_dest").val("0");
                                else
                                    $("#prix").val("0");
                            }

                    if (dest==1)
                        $("#quantite_dest").val(Math.round(this.AS_QteSto * 100) / 100);
                    else
                        $("#quantite_stock").val(Math.round(this.AS_QteSto * 100) / 100);
//                        $("#quantite_stock").val(Math.round(this.AS_QteSto * 100) / 100);
                    if (!modification && Math.round(this.AS_QteSto) >= 1)
                        if (dest==1)
                            $("#quantite_dest").val("1");
                        else
                            $("#quantite").val("1");
                })
            },
            error: function (resultat, statut, erreur) {
                alert(resultat.responseText);
            }
        });
    }

        function fichierTraitement() {
            var fich = typeFac;
            listeMouvement = "listeFacture-" + fich;
            impressionMouvement = "impressionMouvement-"+fich+"-" + $("#cbMarqEntete").val() + "-" + fich;
            if (fich == "Transfert" || fich == "Transfert_confirmation" || fich == "Transfert_valid_confirmation" ) {
                return "Transfert.php";
            }
            if (fich == "Transfert_detail") {
                return "Transfert_detail.php";
            }
            if (fich == "Entree") {
                return "Entree.php";
            }
            if (fich == "Sortie") {
                return "Sortie.php";
            }
            return "";
        }

        fichierTraitement();

        if ($("#flagDelai").val() != -1)
            $("#dateentete").datepicker({

                minDate: -$("#flagDelai").val(),
                maxDate: $("#flagDelai").val(),
                dateFormat: "ddmmy",
                altFormat: "ddmmy",
                autoclose: true
            });
        else
            $("#dateentete").datepicker({
                dateFormat: "ddmmy", altFormat: "ddmmy",
                autoclose: true
            })

        $("#dateentete").datepicker({dateFormat: "ddmmy", altFormat: "ddmmy"});
        if ($_GET("cbMarq") == undefined) {
            $("#dateentete").datepicker({dateFormat: "ddmmy"}).datepicker("setDate", new Date());
        }
        ;


        function setDepot(exclude) {
            var principal = -1;
//            if(typeFac=="Transfert" || typeFac=="Transfert_confirmation")
                principal = 1;
            //$("#depot").unbind();
            $("#depot").autocomplete({
                source: "indexServeur.php?page=getDepotByDENoIntitule&exclude=" + exclude+"&principal="+principal,
                autoFocus: true,
                select: function (event, ui) {
                    $("#DE_No").val(ui.item.DE_No)
                    $("#depot").val(ui.item.DE_Intitule)
                    getDepotSoucheCaisse(0, ui.item.DE_No, -1, "");
                    event.preventDefault();
                    setCollaborateur(ui.item.DE_No)
                }
            })
        }

        setDepot(-1)

    $("#depot").focusout(function(){
        if($("#depot").val()=="")
            $("#DE_No").val(-1)
    })

    function setCollaborateur(exclude){
        //$("#collaborateur").unbind();
        principal = -1;
        $("#collaborateur").autocomplete({
            source: "indexServeur.php?page=getDepotByDENoIntitule&exclude="+$("#DE_No").val()+"&principal=-1",
            autoFocus: true,
            select: function (event, ui) {
                event.preventDefault();
                setDepot(ui.item.DE_No)
                $("#CO_No").val(ui.item.DE_No)
                $("#collaborateur").val(ui.item.DE_Intitule)
            }
        })
    }
    setCollaborateur(-1)

    $("#collaborateur").focusout(function(){
        if($("#collaborateur").val()=="")
            $("#CO_No").val(-1)
    })

    $('#ref').focusout(function() {
        if($("#ref").val()!=""){
            $.ajax({
                url: "traitement/Facturation.php?acte=ajout_reference&cbMarq="+$("#cbMarqEntete").val()+"&reference="+$("#ref").val(),
                method: 'GET',
                dataType: 'html',
                success: function(data) {
                }
            });
        }

    });

    $( "#dateentete" ).focusout(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=ajout_date&cbMarq="+$("#cbMarqEntete").val()+"&date="+returnDate($("#dateentete").val()),
            method: 'GET',
            dataType: 'html',
            success: function(data) {
            }
        });
    });

    $( "#affaire" ).change(function() {
        $.ajax({
            url: "traitement/Facturation.php?acte=maj_affaire&affaire="+$("#affaire").val()+"&cbMarq="+$("#cbMarqEntete").val(),
            method: 'GET',
            dataType: 'json',
            success: function(data) {

            }
        });
    });

    function getDepotSoucheCaisse(caisse, depot, souche, affaire) {
        if (societe != "SECODI SECODI" || admin != 1) {
            $.ajax({
                url: "indexServeur.php?page=getSoucheDepotCaisse",
                method: 'GET',
                dataType: 'json',
                async: false,
                data: "type=" + typeFac + "&prot_no=" + $("#PROT_No").val() + "&ca_no=" + caisse + "&DE_No=" + depot + "&souche=" + souche + "&CA_Num=" + affaire,
                success: function (data) {
                    $(data).each(function () {
                        if (this.CA_Num != null)
                            $("#affaire").val(this.CA_Num);
                    });
                    entete_document();
                },
                error: function (data) {
                    if (depot == 0) {
                        $("#depot").val(1);
                        $("#reference").html("");
                        $("#designation").html("");
                    }
                    if (caisse == 0)
                        $("#caisse").val(1);
                    if (souche == -1)
                        $("#souche").val(0);
                    if (affaire == "")
                        $("#affaire").val("");
                }
            });
        }
        entete_document();
    }

    if($("#cbMarqEntete").val()=="")
        getDepotSoucheCaisse(0, $("#DE_No").val(), -1, "");


    function valideEntete(){
        var affaire = "";
        if($("#cbMarqEntete").val()=="" || $("#cbMarqEntete").val()=="0")
        if((typeFac!="Transfert" && typeFac!="Transfert_confirmation" && $("#DE_No").val()!="") ||
                ((typeFac=="Transfert" || typeFac=="Transfert_confirmation") && $("#DE_No").val()!="" && $("#CO_No").val()!="" && $("#DE_No").val()!=$("#CO_No").val())){
            if($("#affaire").val()!="null")
                affaire = $("#affaire").val();
            $.ajax({
                url: "traitement/Facturation.php?type_fac="+typeFac+"&do_piece="+$("#n_doc").val()+"&acte=ajout_entete&date="+returnDate($("#dateentete").val())+"&client="+$("#CO_No").val()+"&de_no="+$("#DE_No").val()+ "&reference="+$("#ref").val()+ "&affaire="+affaire+"&userName="+$("#userName").html()+"&machineName="+$("#machineName").html(),
                method: 'GET',
                async : false,
                dataType: 'json',
                data : "protNo="+$("#PROT_No").val(),
                success: function(data) {
                    jeton=0;
                    $("#n_doc").val(data.entete);
                    $("#cbMarqEntete").val(data.cbMarq);
                    $("#client").prop('disabled', true);
                    $("#depot").prop('disabled', true);
                    $("#collaborateur").prop('disabled', true);
                    $("#reference").prop('disabled', true);
                    $("#nclient").prop('disabled', true);
                    $("#reference").prop('disabled', false);
                    $("#dateentete").prop('disabled', true);
                    $("#referenceDest").prop('disabled', false);
                    if(typeFac!="Sortie")
                        $("#prix").prop('disabled', false);
                    $("#remise").prop('disabled', false);
                    $("#quantite").prop('disabled', false);
                    $("#quantite_dest").prop('disabled', false);
                    $("#designation").html();
                    $("#reference").html();
                    setArticle()
                    $("#reference").focus();

                },
                error : function(resultat, statut, erreur){
                    alert(resultat.responseText);
                }
            });
        }
    }

    $('#dateentete').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });

    $('#ref').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });

    $('#depot').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });

    $('#collaborateur').keydown(function (e){
        if(e.keyCode == 13){
            valideEntete();
        }
    });
});
