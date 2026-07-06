# Utilisateurs

Gérez les comptes utilisateurs, affectez des rôles et contrôlez l'accès à la plateforme. Accessibles depuis le menu déroulant **Gérer** de la gestion sous **Contrôle d'accès → Utilisateurs** (Super Admin uniquement).

## Gestion des utilisateurs

La page Utilisateurs a deux onglets :

### Onglet Utilisateurs

Affiche un tableau de tous les utilisateurs enregistrés avec :
- Nom, email et photo de profil
- Rôle affecté
- Statut de suspension
- Actions Modifier, Suspendre/Restaurer et Supprimer par ligne

### Onglet Invitations

L'onglet Invitations propose deux moyens d'inviter de nouveaux utilisateurs.

#### Inviter un nouvel utilisateur (unique)

1. Cliquez sur **Inviter un nouvel utilisateur**
2. Dans la fenêtre modale, saisissez l'**adresse email** de l'utilisateur
3. Sélectionnez facultativement un **Rôle à affecter** (ou laissez sur « À affecter plus tard »)
4. Cliquez sur **Inviter**

Le système génère un lien d'inscription unique qui expire dans 72 heures. L'invitation en attente apparaît dans le tableau ci-dessous.

#### Invitation en masse

1. Cliquez sur **Invitation en masse**
2. Préparez un tableur (`.xlsx` ou `.csv`) avec au moins une colonne **email**. Incluez facultativement une colonne **role** avec le nom exact du rôle à affecter
3. Téléchargez le fichier et cliquez sur **Inviter**

Un modèle peut être téléchargé en cliquant sur **Télécharger le modèle d'importation**. Le système traite chaque ligne et crée une invitation pour chaque adresse email.

#### Invitations en attente

Les invitations en attente sont listées avec les options suivantes :
- **Afficher le lien** — copier le lien d'inscription pour l'envoyer manuellement
- **Renvoyer l'email** — renvoyer l'email d'invitation
- **Renouveler** — rafraîchir une invitation expirée
- **Supprimer** — supprimer l'invitation

## Modification d'un utilisateur

1. Cliquez sur **Modifier** à côté d'un utilisateur
2. Changez le **Rôle** de l'utilisateur en sélectionnant parmi les rôles disponibles
3. La photo de profil, le nom, l'email et la date d'inscription de l'utilisateur sont affichés à titre de référence

## Suspension d'un utilisateur

1. Cliquez sur **Suspendre** (ou **Restaurer**) à côté d'un utilisateur, ou naviguez vers `manage/user/{user}/suspension`
2. Le bouton bascule le statut de suspension activé/désactivé
3. Les utilisateurs suspendus ne peuvent pas se connecter jusqu'à ce que la suspension soit levée

## Suppression d'un utilisateur

1. Cliquez sur **Supprimer** à côté d'un utilisateur
2. Confirmez la suppression dans la boîte de dialogue
3. Les comptes Super Admin ne peuvent pas être supprimés
