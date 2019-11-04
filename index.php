<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php 
if(isset($_GET["action"])){
    
session_start(); //to ensure you are using same session
session_destroy(); 
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
        <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
        <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4-.css">
        <link rel="stylesheet" href="assets/css/Data-Table-1.css">
        <link rel="stylesheet" href="assets/css/Data-Table.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/input.css">
        <link rel="stylesheet" href="assets/css/select.css">

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/chart.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
        <script src="assets/js/bs-charts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
        <script src="assets/js/theme.js"></script>

        <script type="text/javascript" language="javascript">
        $(function(){
            var dateJour = new Date;
            $("#jour").val(dateJour.getDay());
            $("#heure").val(("00"+dateJour.getHours()).substr(-2)+":"+("00"+dateJour.getMinutes()).substr(-2));

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
            var textfield = $("input[name=user]");
            if($_GET("code")==1){
                $("#output").removeClass(' alert alert-success');
                $("#output").addClass("alert alert-danger animated fadeInUp").html("Login ou mot de passe incorrect");
            }
            if($_GET("code")==2){
                $("#output").removeClass(' alert alert-success');
                $("#output").addClass("alert alert-danger animated fadeInUp").html("Horaire de connexion non autorisé");
            }
});
        </script>
 <title>Connexion</title>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row mh-100vh">
                <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                    <div class="m-auto w-lg-75 w-xl-50">
                        <div id="output"></div>
                        <h2 class="text-center text-info font-weight-light mb-5"><img src="assets/img/avatars/it_solution.png">&nbsp;</h2>
                        <form class="text-center" action="module/connexion.php" method="POST">
                            <div class="form-group">
                                <label class="text-secondary">Login</label>
                                <input class="form-control" type="text" required="" name="user">
                            </div>
                            <div class="form-group">
                                <label class="text-secondary">Mot de passe</label>
                                <input class="form-control" type="password" name="password">
                            </div>
                            <button class="btn btn-info mt-2" type="submit" style="background-color: rgb(57,54,204);">Valider</button></form>
                        <input name="jour" id="jour" type="hidden" value="">
                        <input name="heure" id="heure" type="hidden" value="">
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image: url(&quot;assets/img/facturation-mentions-obligatoires-entreprise-.jpg&quot;);background-size: cover;background-position: center center;filter: blur(4px);">
                    <p class="ml-auto small text-dark mb-2"><em>Photo by&nbsp;</em><a class="text-dark" href="https://unsplash.com/photos/v0zVmWULYTg?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank"><em>Aldain Austria</em></a><br></p>
                </div>
            </div>
        </div>
    </body>
</html>
