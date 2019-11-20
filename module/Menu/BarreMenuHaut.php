<?php 
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
?>
<nav class="navbar navbar-light sticky-top bg-white shadow mb-4 topbar static-top" style="font-size: 16px;height: 97px;">
    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
        <nav class="navbar navbar-light navbar-expand-sm bg-white">
            <div class="container-fluid"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link active" data-toggle="dropdown" aria-expanded="false" href="#">Règlement</a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">Clients</a><a class="dropdown-item" role="presentation" href="#">Fournisseurs</a><a class="dropdown-item" role="presentation" href="#">Bon de caisse</a></div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link active" data-toggle="dropdown" aria-expanded="false" href="#">Compta</a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">Plan comptable</a><a class="dropdown-item" role="presentation" href="#">Plan analytique</a><a class="dropdown-item" role="presentation" href="#">Taxe</a>
                                <a
                                        class="dropdown-item" role="presentation" href="#">Journaux</a><a class="dropdown-item" role="presentation" href="#">Banque</a><a class="dropdown-item" role="presentation" href="#">Mode de règlement</a><a class="dropdown-item" role="presentation" href="#">Saisie comptable</a>
                                <a
                                        class="dropdown-item" role="presentation" href="#">Contrôle de caisse</a><a class="dropdown-item" role="presentation" href="#">MAJ comptable</a><a class="dropdown-item" role="presentation" href="#">MAJ analytique</a></div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link active" data-toggle="dropdown" aria-expanded="false" href="#">Structure</a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="listeArticle">Article</a><a class="dropdown-item" role="presentation" href="#">Client</a><a class="dropdown-item" role="presentation" href="#">Fournisseur</a><a class="dropdown-item"
                                                                                                                                                                                                                                                                            role="presentation" href="#">Catalogue</a><a class="dropdown-item" role="presentation" href="#">Famille</a><a class="dropdown-item" role="presentation" href="#">Depot</a><a class="dropdown-item" role="presentation"
                                                                                                                                                                                                                                                                                                                                                                                                                                                         href="#">Collaborateur</a><a class="dropdown-item" role="presentation" href="#">Caisse</a><a class="dropdown-item" role="presentation" href="#">Salarié</a><a class="dropdown-item" role="presentation" href="#">Rabais remise ristournes clients</a></div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link active" data-toggle="dropdown" aria-expanded="false" href="#">Administration</a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">Utilisateur</a><a class="dropdown-item" role="presentation" href="#">Profil</a><a class="dropdown-item" role="presentation" href="#">Droit</a><a class="dropdown-item"
                                                                                                                                                                                                                                                                          role="presentation" href="#">Envoi mail</a><a class="dropdown-item" role="presentation" href="#">Envoi SMS</a><a class="dropdown-item" role="presentation" href="#">Compte SMS</a><a class="dropdown-item"
                                                                                                                                                                                                                                                                                                                                                                                                                                                               role="presentation" href="#">Config accès</a><a class="dropdown-item" role="presentation" href="#">Config profil</a><a class="dropdown-item" role="presentation" href="#">Déconnexion totale</a><a class="dropdown-item"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  role="presentation" href="#">Fusion article</a><a class="dropdown-item" role="presentation" href="#">Fusion client</a><a class="dropdown-item" role="presentation" href="#">Agenda connexion</a></div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link active" data-toggle="dropdown" aria-expanded="false" href="#">Etats</a>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item disabled active" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Caisse</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</nav>