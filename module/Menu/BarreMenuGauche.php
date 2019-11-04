<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
            <div class="sidebar-brand-icon rotate-n-15"></div>
            <div class="sidebar-brand-text mx-3"><span>IT-Solution</span>
                <hr class="sidebar-divider my-0">
                <div><span style="font-size: 10px;"><?= $_SESSION["login"] ?><br></span></div>
                <input id="machineName" type="hidden" value="<?= gethostname() ?>"/>
                <input type="hidden" id="PROT_No" value="<?= $protection->Prot_No ?>" />
            </div>
        </a>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"><a class="nav-link" href="index.html"><i class="fas fa-home"></i><span>Accueil</span></a></li>
        </ul>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item hoverliVente" role="presentation"><a class="nav-link" href="#"><i class="fas fa-cash-register"></i><span>Ventes&nbsp;</span></a><ul class="file_menuCss file_menuVente" >
                    <li <?= $protection->visuMenu('Vente') ?> ><a href="<?= $protection->lienMenu('Vente') ?>" >Facture</a></li>
                    <li <?= $protection->visuMenu('Devis') ?> ><a <?= $protection->lienMenu('Devis') ?> >Devis</a></li>
                    <li <?= $protection->visuMenu('BonLivraison') ?> ><a href="<?= $protection->lienMenu('BonLivraison') ?>" >Bon de livraison</a></li>
                    <li <?= $protection->visuMenu('VenteAvoir') ?> ><a href="<?= $protection->lienMenu('VenteAvoir') ?>" >Avoir</a></li>
                    <li <?= $protection->visuMenu('VenteRetour') ?> ><a href="<?= $protection->lienMenu('VenteRetour') ?>" >Retour</a></li>
                    <li <?= $protection->visuMenu('Ticket') ?> ><a href="<?= $protection->lienMenu('Ticket') ?>" >Ticket</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item hoverliAchat" role="presentation"><a class="nav-link" href="index.html"><i class="fas fa-shopping-cart"></i><span>Achats</span></a><ul class="file_menuCss file_menuAchat" >
                    <li <?= $protection->visuMenu('Achat') ?> ><a href="<?= $protection->lienMenu('Achat') ?>">Facture</a></li>
                    <li <?= $protection->visuMenu('PreparationCommande') ?> ><a href="<?= $protection->lienMenu('PreparationCommande') ?>">Prep. commande</a></li>
                    <li <?= $protection->visuMenu('AchatPreparationCommande') ?> ><a href="<?= $protection->lienMenu('AchatPreparationCommande') ?>">Fact. + prep cmde</a></li>
                    <li <?= $protection->visuMenu('AchatRetour') ?> ><a href="<?= $protection->lienMenu('AchatRetour') ?>">Retour</a></li>
                </ul>
            </li>
            <li class="nav-item hoverliStock" role="presentation"><a class="nav-link" href="index.html"><i class="fas fa-truck"></i><span>Stocks</span></a><ul class="file_menuCss file_menuStock" >
                    <li <?= $protection->visuMenu('Transfert') ?> ><a <?= $protection->lienMenu('Transfert') ?> >Transfert</a></li>
                    <li <?= $protection->visuMenu('Entree') ?> ><a <?= $protection->lienMenu('Entree') ?> >Entrée</a></li>
                    <li <?= $protection->visuMenu('Sortie') ?> ><a <?= $protection->lienMenu('Sortie') ?> >Sortie</a></li>
                    <li <?= $protection->visuMenu('TrsftDetail') ?> ><a <?= $protection->lienMenu('TrsftDetail') ?> >Trsft détail</a></li>
                    <li <?= $protection->visuMenu('TrsftEmission') ?> ><a <?= $protection->lienMenu('TrsftEmission') ?> >Trsft emission</a></li>
                    <li <?= $protection->visuMenu('TrsftConfirmation') ?> ><a <?= $protection->lienMenu('TrsftConfirmation') ?> >Trsft Confirmation</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"></li>
        </ul>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"></li>
        </ul>
        <ul class="nav navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item" role="presentation"></li>
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
</nav>