jQuery(function($){

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
    
    $('#ajouterUser').click(function(e){
        e.preventDefault();
        ajouterUser();
    });

    function ajouterUser(){
        if($_GET("id")==null){
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=ajout_user',
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                } 
            }); 
        }else {
            $("#add_err").css('display', 'none', 'important');
            $.ajax({
                url: 'traitement/Creation.php?acte=modif_user',//&username='+$("#username").val()+'&description='+$("#description").val()+'&id='+$_GET("id")+'&password='+$("#password").val()+'&email='+$("#email").val()+'&groupeid='+$("#groupeid").val()+'&profiluser='+$("#profiluser").val()+'&changepass='+$("#changepass").val()+'&depot='+$("#depot").val()+'&caisse='+$("#caisse").val(),
                method: 'GET',
                dataType: 'json',
                data : $("#formUser").serialize(),
                success: function(data) {
                    window.location.replace("indexMVC.php?module=8&action=1&Prot_No="+data.Prot_No);
                } 
            });
        }
    }


    $("#depot").change(function(){
        $("#depotprincipal").empty();
        $("#depot > option:selected").each(function(){
            $("#depotprincipal").append(new Option($(this).text(),$(this).val()));
        });
        setSelectedPrincipaux();
    });


    tablePrincipal = "";
    function setSelectedPrincipaux(){
        $(tablePrincipal).each(function() {
            $('#depotprincipal option[value="'+$(this)[0].DE_No+'"]').attr("selected", "selected");
        //    $('#depotprincipal option[value="'+$(this)[0].DE_No+'"]');
        });
    }

    function getPrincipal(){
        $.ajax({
            url: "indexServeur.php?page=getPrincipalDepot",
            method: 'GET',
            dataType: 'json',
            data: "id="+$("#id").val(),
            success: function(data) {
                tablePrincipal = data;
            }
        });
    }

    getPrincipal();

    function getDepotSoucheCaisse(caisse,depot,souche){
        $.ajax({
           url: "indexServeur.php?page=getCaisseDepotSouche",
           method: 'GET',
           dataType: 'json',
           data: "CA_No="+caisse+"&DE_No="+depot+"&CA_Souche="+souche,
           success: function(data) {
                $(data).each(function() {
                    $("#depot").val(this.DE_No);
                    $("#caisse").val(this.CA_No);
                    $("#souche").val(this.CA_Souche);
                });
            }
        });
    }   

    $("#depot").change(function(){
       getDepotSoucheCaisse(0,$("#depot").val(),0); 
    });

    $("#caisse").change(function(){
       getDepotSoucheCaisse($("#caisse").val(),0,0); 
    });

/*
   $.widget( "custom.comboCompteg", {
        _create: function() {

            this.wrapper = $( "<span>" )
                .addClass( "custom-combobox" )
                .insertAfter( this.element );

            this.element.hide();
            this._createAutocomplete();
            this._createShowAllButton();
        },

        _createAutocomplete: function() {
            var selected = this.element.children( ":selected" ),
                value = selected.val() ? selected.text() : "";
            $("#cat_tarif").val("5");

            this.input = $( "<input>" )
                .appendTo( this.wrapper )
                .val( value )
                .attr( "title", "" )
                .addClass( "form-control combocompteg" )
                .css("width", "200px")
                .css("height", "30px")
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy( this, "_source" )
                })
                .tooltip({
                    tooltipClass: "ui-state-highlight"
                });

            this._on( this.input, {
                autocompleteselect: function( event, ui ) {
                    ui.item.option.selected = true;
                    this._trigger( "select", event, {
                        item: ui.item.option
                    });
                },

                autocompletechange: "_removeIfInvalid"
            });
        },

        _createShowAllButton: function() {
            var input = this.input,
                wasOpen = false;

            $( "<a>" )
                .attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .tooltip()
                .appendTo( this.wrapper )
                .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                .removeClass( "ui-corner-all" )
                .addClass( "custom-combobox-toggle ui-corner-right" )
                .mousedown(function() {
                    wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                })
                .click(function() {
                    input.focus();

                    // Close if already visible
                    if ( wasOpen ) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete( "search", "" );
                });
        },

        _source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( this.element.children( "option" ).map(function() {
                var text = $( this ).text();
                if ( this.value && ( !request.term || matcher.test(text) ) )
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
            }) );
        },

        _removeIfInvalid: function( event, ui ) {

            // Selected an item, nothing to do
            if ( ui.item ) {
                return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;
            this.element.children( "option" ).each(function() {
                if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                    this.selected = valid = true;
                    return false;
                }
            });

            // Found a match, nothing to do
            if ( valid ) {
                return;
            }

            // Remove invalid value
            this.input
                .val( "" )
                .attr( "title", value + " didn't match any item" )
                .tooltip( "open" );
            this.element.val( "" );
            this._delay(function() {
                this.input.tooltip( "close" ).attr( "title", "" );
            }, 2500 );
            this.input.autocomplete( "instance" ).term = "";
        },

        _destroy: function() {
            this.wrapper.remove();
            this.element.show();
        }
    });
*/

/*    $.widget( "custom.comboDeno", {
        _create: function() {

            this.wrapper = $( "<span>" )
                .addClass( "custom-combobox" )
                .insertAfter( this.element );

            this.element.hide();
            this._createAutocomplete();
            this._createShowAllButton();
        },

        _createAutocomplete: function() {
            var selected = this.element.children( ":selected" ),
                value = selected.val() ? selected.text() : "";

            this.input = $( "<input>" )
                .appendTo( this.wrapper )
                .val( value )
                .attr( "title", "" )
                .css("width", "200px")
                .css("height", "30px")
                .addClass( "form-control combodeno" )
                .autocomplete({
                    delay: 0,
                    minLength: 0,
                    source: $.proxy( this, "_source" )
                })
                .tooltip({
                    tooltipClass: "ui-state-highlight"
                });

            this._on( this.input, {
                autocompleteselect: function( event, ui ) {
                    ui.item.option.selected = true;
                    this._trigger( "select", event, {
                        item: ui.item.option
                    });
                },

                autocompletechange: "_removeIfInvalid"
            });
        },

        _createShowAllButton: function() {
            var input = this.input,
                wasOpen = false;

            $( "<a>" )
                .attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .tooltip()
                .appendTo( this.wrapper )
                .button({
                    icons: {
                        primary: "ui-icon-triangle-1-s"
                    },
                    text: false
                })
                .removeClass( "ui-corner-all" )
                .addClass( "custom-combobox-toggle ui-corner-right" )
                .mousedown(function() {
                    wasOpen = input.autocomplete( "widget" ).is( ":visible" );
                })
                .click(function() {
                    input.focus();

                    // Close if already visible
                    if ( wasOpen ) {
                        return;
                    }

                    // Pass empty string as value to search for, displaying all results
                    input.autocomplete( "search", "" );
                });
        },

        _source: function( request, response ) {
            var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
            response( this.element.children( "option" ).map(function() {
                var text = $( this ).text();
                if ( this.value && ( !request.term || matcher.test(text) ) )
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
            }) );
        },

        _removeIfInvalid: function( event, ui ) {

            // Selected an item, nothing to do
            if ( ui.item ) {
                return;
            }

            // Search for a match (case-insensitive)
            var value = this.input.val(),
                valueLowerCase = value.toLowerCase(),
                valid = false;
            this.element.children( "option" ).each(function() {
                if ( $( this ).text().toLowerCase() === valueLowerCase ) {
                    this.selected = valid = true;
                    return false;
                }
            });

            // Found a match, nothing to do
            if ( valid ) {
                return;
            }

            // Remove invalid value
            this.input
                .val( "" )
                .attr( "title", value + " didn't match any item" )
                .tooltip( "open" );
            this.element.val( "" );
            this._delay(function() {
                this.input.tooltip( "close" ).attr( "title", "" );
            }, 2500 );
            this.input.autocomplete( "instance" ).term = "";
        },

        _destroy: function() {
            this.wrapper.remove();
            this.element.show();
        }
    });
*/
//    $( "#compteg" ).comboCompteg();
//    $( "#compteg" ).css({ float: "left" });
//    $( "#deno" ).comboDeno();
        
});