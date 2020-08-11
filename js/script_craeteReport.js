jQuery(function($){

    $( "#sortable" ).sortable({
        revert: true
    })

    $("li[id^='draggable']").each(function(){
        $( this ).draggable({
            connectToSortable: "#sortable",
            helper: "clone",
            revert: "invalid"
        })
    })

    $( "ul, li" ).disableSelection()


    function deleteItem() {
        $("#sortable").each(function () {
            $(this).find("#supprItem").each(function () {
                $(this).click(function(){
                    $(this).parent().remove();
                });
            })
        })
    }
            $("#valider").click(function(){
                deleteItem()
        datas =[]
        $("#sortable").each(function(){
            $(this).find(".item").each(function(){
                datas.push($(this).find("#info").html())
            })
        })
        $.ajax({
            url: "Traitement/Facturation.php?acte=createReport",
            method: 'GET',
            dataType: 'html',
            data : "param="+datas,
            success: function (data) {
                $("#result").html(data);
            }
        });
    })

    $("#addFilter").click(function(){
        $("#listFilter").append("<div id=\"filter\" class=\"row\">\n" +
            "                        <select class=\"col-5 form-control\">\n" +
            "                            <option value=\"\"></option>\n" +
            "                            <option value=\"date\">Date</option>\n" +
            "                            <option value=\"client\">Client</option>\n" +
            "                            <option value=\"fournisseur\">Fournisseur</option>\n" +
            "                            <option value=\"article\">Article</option>\n" +
            "                        </select>\n" +
            "                        <input type=\"text\" class=\"ml-2 col-3 form-control\"/>\n" +
            "                        <input type=\"text\" class=\"ml-2 col-3 form-control\"/>\n" +
            "                        <span class=\"ml-2\"><i id=\"removeFilter\" class=\"fas fa-close\" style=\"color:red;font-size: 25px\"></i></span>\n" +
            "                    </div>")
            removeFilter()
    })

    function removeFilter() {
        $("#removeFilter").each(function () {
            $(this).unbind()
            $(this).click(function () {
                $(this).parent().parent().remove()
            })
        })
    }
    removeFilter()
});