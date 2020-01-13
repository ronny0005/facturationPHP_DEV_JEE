<?php 
$protection = new ProtectionClass($_SESSION["login"], $_SESSION["mdp"]);
?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Accueil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Vente
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="listeFacture-Vente">Facture de vente</a></li>
                        <li><a class="dropdown-item" href="listeFacture-Devis">Devis</a></li>
                        <li><a class="dropdown-item" href="listeFacture-BonLivraison">Bon de livraison</a></li>
                        <li><a class="dropdown-item" href="listeFacture-VenteAvoir">Avoir</a></li>
                        <li><a class="dropdown-item" href="listeFacture-VenteRetour">Retour</a></li>
                        <li><a class="dropdown-item" href="listeFacture-Ticket">Ticket</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Achat
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="listeFacture-Achat">Facture</a></li>
                        <li><a class="dropdown-item" href="listeFacture-PreparationCommande">Preparation de cmde</a></li>
                        <li><a class="dropdown-item" href="listeFacture-AchatPreparationCommande">Achat + Prep. cmde</a></li>
                        <li><a class="dropdown-item" href="listeFacture-AchatRetour">Retour</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Règlement
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Client</a></li>
                        <li><a class="dropdown-item" href="#">Fournisseur</a></li>
                        <li><a class="dropdown-item" href="#">Bon de caisse</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Structure
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Article</a></li>
                        <li><a class="dropdown-item" href="#">Client</a></li>
                        <li><a class="dropdown-item" href="#">Fournisseur</a></li>
                        <li><a class="dropdown-item" href="#">Catalogue</a></li>
                        <li><a class="dropdown-item" href="#">Famille</a></li>
                        <li><a class="dropdown-item" href="#">Depot</a></li>
                        <li><a class="dropdown-item" href="#">Collaborateur</a></li>
                        <li><a class="dropdown-item" href="#">Caisse</a></li>
                        <li><a class="dropdown-item" href="#">Salarié</a></li>
                        <li><a class="dropdown-item" href="#">Rabais remise et ristourne clients</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Comptabilité
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Plan comptable</a></li>
                        <li><a class="dropdown-item" href="#">Plan analytique</a></li>
                        <li><a class="dropdown-item" href="#">Taxe</a></li>
                        <li><a class="dropdown-item" href="#">Journaux</a></li>
                        <li><a class="dropdown-item" href="#">Banque</a></li>
                        <li><a class="dropdown-item" href="#">Mode de règlement</a></li>
                        <li><a class="dropdown-item" href="#">Saisie comptable</a></li>
                        <li><a class="dropdown-item" href="#">Contrôle de caisse</a></li>
                        <li><a class="dropdown-item" href="#">mise à jour comptable</a></li>
                        <li><a class="dropdown-item" href="#">Mise à jour analytique</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mouvement
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Transfert</a></li>
                        <li><a class="dropdown-item" href="#">Entrée</a></li>
                        <li><a class="dropdown-item" href="#">Sortie</a></li>
                        <li><a class="dropdown-item" href="#">Trsft détail</a></li>
                        <li><a class="dropdown-item" href="#">Emission</a></li>
                        <li><a class="dropdown-item" href="#">Confirmation</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Etats
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Mvt de stock</a></li>
                        <li><a class="dropdown-item" href="#">Eq de stock</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Statistique</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Article par agence</a></li>
                                <li><a class="dropdown-item" href="#">Client par agence</a></li>
                                <li><a class="dropdown-item" href="#">Collaborateur par article</a></li>
                                <li><a class="dropdown-item" href="#">Achats</a></li>
                                <li><a class="dropdown-item" href="#">Articles par fournisseur</a></li>
                                <li><a class="dropdown-item" href="#">Achats analytique</a></li>
                                <li><a class="dropdown-item" href="#">Collaborateur par client</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown-item" href="#">Echéance client</a></li>
                        <li><a class="dropdown-item" href="#">Echéance client agé</a></li>
                        <li><a class="dropdown-item" href="#">Echéance client 2</a></li>
                        <li><a class="dropdown-item" href="#">Echéance fournisseur</a></li>
                        <li><a class="dropdown-item" href="#">Règlement client</a></li>
                        <li><a class="dropdown-item" href="#">Relevé compte client</a></li>
                        <li><a class="dropdown-item" href="#">Etat caisse</a></li>
                        <li><a class="dropdown-item" href="#">Etat des dettes</a></li>
                        <li><a class="dropdown-item" href="#">Livre d'inventaire</a></li>
                        <li><a class="dropdown-item" href="#">Versement distant</a></li>
                        <li><a class="dropdown-item" href="#">Versement bancaire</a></li>
                        <li><a class="dropdown-item" href="#">Ctrl report de caisse</a></li>
                        <li><a class="dropdown-item" href="#">Balance des tiers</a></li>
                        <li><a class="dropdown-item" href="#">Echéance tiers</a></li>
                        <li><a class="dropdown-item" href="#">Etat de réaprovisionnement</a></li>
                        <li><a class="dropdown-item" href="#">Etat d'exploitation</a></li>
                        <li><a class="dropdown-item" href="#">Transfert de caissse</a></li>
                        <li><a class="dropdown-item" href="#">Stock grand dépot</a></li>
                        <li><a class="dropdown-item" href="#">Etat du compte de résultat</a></li>
                        <li><a class="dropdown-item" href="#">Fichier central rap</a></li>
                        <li><a class="dropdown-item" href="#">Ecriture comptable</a></li>
                        <li><a class="dropdown-item" href="#">Grand livre tiers commercial</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Caisse
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administration
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="#">Utilisateur</a></li>
                        <li><a class="dropdown-item" href="#">Profils</a></li>
                        <li><a class="dropdown-item" href="#">Droits</a></li>
                        <li><a class="dropdown-item" href="#">Envoi mail</a></li>
                        <li><a class="dropdown-item" href="#">Envoi SMS</a></li>
                        <li><a class="dropdown-item" href="#">Compte SMS</a></li>
                        <li><a class="dropdown-item" href="#">Config. accès</a></li>
                        <li><a class="dropdown-item" href="#">Config. profil utilisateur</a></li>
                        <li><a class="dropdown-item" href="#">Déconnexion totale</a></li>
                        <li><a class="dropdown-item" href="#">Fusion article</a></li>
                        <li><a class="dropdown-item" href="#">Fusion client</a></li>
                        <li><a class="dropdown-item" href="#">Calendrier connexion</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Saisie inventaire
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mot de passe
                    </a>
                </li>


            </ul>
        </div>
    </nav>
<?php
include("BarreMenu.php");
?>