<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background-color: rgb(255,255,255);background-image: url(&quot;none&quot;);width: 222px;">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon"><img src="assets/img/it_solution.png" style="width: 66px;"></div>
            <div class="sidebar-brand-text mx-3"></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Bienvenue <?= $_SESSION["login"] ?> !</a>
                <input type="hidden" value="<?= $_SESSION["id"] ?>" name="PROT_No" id="PROT_No" />
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="#">Utilisateur</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Profil</a><a class="dropdown-item customDropdown-item" role="presentation"
                                                                                                                                                                                                                                                             href="#">Droits</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Envoi mail</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Envoi SMS</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                  role="presentation" href="#">Compte SMS</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Config. accès</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Config. profil&nbsp;</a>
                    <a
                            class="dropdown-item customDropdown-item" role="presentation" href="#">Déconnexion</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Fusion client</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Fusion article</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                            role="presentation" href="#">Calendrier connexion</a></div>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Vente</a>
                <div class="dropdown-menu" role="menu" style="border: none;">
                    <a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Vente">Facture</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Devis">Devis</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                          role="presentation" href="listeFacture-BonLivraison">Bon de livraison</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-VenteAvoir">Avoir</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                               role="presentation" href="listeFacture-VenteRetour">Retour</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Ticket">Ticket</a></div>
            </li>
            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Achat</a>
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-achat">Facture</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-PreparationCommande">Prep. commande</a>
                    <a
                            class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-AchatPreparationCommande">Achat + Prep Commande</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-AchatRetour">Retour</a></div>
            </li>
            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Règlement</a>
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="Reglement-client">Client</a><a class="dropdown-item customDropdown-item" role="presentation" href="Reglement-fournisseur">Fournisseur</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                role="presentation" href="Reglement-collaborateur">Bon de caisse</a></div>
            </li>
            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Structure</a>
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="listeArticle">Article</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeClient">Client</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                              role="presentation" href="listeFournisseur">Fournisseur</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFamille">Famille</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeDepot">Depot</a>
                    <a
                            class="dropdown-item customDropdown-item" role="presentation" href="listeCollaborateur">Collaborateur</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeCaisse">Caisse</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeSalarie">Salarié</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                                                      role="presentation" href="listeSalarie">Rabais remise et ristournes</a></div>
            </li>
            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Comptabilité</a>
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="#">Plan comptable</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Plan analytique</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                         role="presentation" href="#">Taxe</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Journal</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Banque</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          role="presentation" href="#">Modèle de rglt</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Saisie compta</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Ctrle de caisse</a>
                    <a
                            class="dropdown-item customDropdown-item" role="presentation" href="#">Maj compta</a><a class="dropdown-item customDropdown-item" role="presentation" href="#">Maj analytique</a></div>
            </li>
            <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#" style="color: rgb(2,78,5);font-weight: bold;">Mouvement</a>
                <div class="dropdown-menu" role="menu" style="border: none;"><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Transfert">Transfert</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Entree">Entrée</a><a class="dropdown-item customDropdown-item"
                                                                                                                                                                                                                                                                                                  role="presentation" href="listeFacture-Sortie">Sortie</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-TrsftDetail">Trsft détail</a><a class="dropdown-item customDropdown-item" role="presentation"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                               href="listeFacture-Emission">Emission</a><a class="dropdown-item customDropdown-item" role="presentation" href="listeFacture-Confirmation">Confirmation</a></div>
            </li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="mvtCaisse" style="color: rgb(2,78,5);font-weight: bold;"><span>Caisse</span></a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#" style="color: rgb(2,78,5);">Saisie inventaire</a></li>
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button" style="background-color: rgb(2,78,5);color: rgb(255,255,255);"></button></div>
    </div>
</nav>
