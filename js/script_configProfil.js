jQuery(function($){
    function valide() {
        $("p").each(function () {
            if($(this).find("#modif").val()==1) {
                var TE_No = $(this).find("#TE_No").html();
                var selected = $(this).find("#selectProtect").val();
                var pageData = 'configAccess';
                $.ajax({
                    url: 'indexServeur.php',
                    method: 'GET',
                    dataType: 'html',
                    data: 'page=' + pageData + '&TE_No=' + TE_No + "&PROT_No_Profil=" + $("#PROT_No").val() + "&Selected=" + selected,
                    async: false,
                    success: function (data) {
                    }
                });
            }
        });
        alert("La modification a bien été prise en compte !");
    }

    function fonctionCodeCompte() {
        $("select[id^='selectProtect']").each(function () {
            $(this).change(function () {
                $(this).parent().find("#modif").val(1);
            });
        });
    }
    fonctionCodeCompte();

    $("#PROT_No").change(function(){
        codeClient.submit();
    })
    $("#valide").click(function(event){
        valide();
    })
});