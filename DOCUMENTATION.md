# Entrepreneur ERP - Documentation Fonctionnelle (Version 1.0)

## 1. Présentation du Projet
Entrepreneur ERP est une solution de gestion d'entreprise complète, conçue pour centraliser et automatiser les opérations quotidiennes. Le système remplace les feuilles de calcul éparpillées par une plateforme robuste intégrant la gestion du personnel, le suivi du temps, les stocks et la facturation.

### Philosophie de Conception
- **Maintenabilité** : Architecture modulaire permettant des évolutions sans casser l'existant.
- **Localisation** : Support bilingue complet (Français/Anglais).
- **Flexibilité** : Paramétrage dynamique de l'entreprise (nom, devise, langue, coordonnées).

---

## 2. Gestion des Rôles et Accès

Le système distingue deux types de rôles :
1. **Rôles Système (Utilisateurs)** : Administrateur, Manager, Viewer. Ils définissent qui peut accéder au panneau d'administration et quelles actions ils peuvent effectuer.
2. **Rôles de Contact (Employés)** : Employé, Team Leader, Manager. Ils servent à organiser le personnel sans nécessairement leur donner accès à l'interface d'administration.

---

## 3. Modules et Fonctionnalités

### A. Dashboard (Tableau de Bord)
Le centre de contrôle affichant les KPIs essentiels :
- Cartes de statistiques : Total des contacts, produits, achats et factures du mois.
- Alertes : Heures à valider, produits en stock faible.
- Graphiques : Répartition des factures, dépenses mensuelles.
- Flux d'activité : Derniers contacts ajoutés et achats récents.

### B. Contacts (Employés)
Gestion du capital humain :
- Fiche détaillée : Informations personnelles, coordonnées, NIN (Numéro d'Identité Nationale), date d'embauche et salaire.
- Calcul Automatique : Le système calcule le taux horaire basé sur la norme de 173.33 heures/mois.
- Multi-rôles : Un contact peut être affecté à plusieurs rôles (ex: Employé et Team Leader).

### C. Timesheets (Pointage & Suivi du Temps)
Suivi quotidien des prestations :
- Saisie des heures : Date, nombre d'heures et commentaires.
- Workflow de Validation : Un administrateur doit valider ou rejeter les heures saisies. Seules les heures validées sont prises en compte pour la facturation du salaire.
- Historique : Vue sur les deux derniers mois d'activité.

### D. Gestion des Stocks (Produits & Fournisseurs)
- Produits : Suivi avec référence unique, prix unitaire et seuil d'alerte.
- Fournisseurs : Base de données des partenaires commerciaux.
- Achats : Chaque achat enregistré met à jour automatiquement le stock du produit concerné.
- Alertes de Stock : Les produits sous le seuil d'alerte sont mis en évidence.

### E. Facturation
Moteur de génération de documents PDF professionnels :
- Factures Employés : Basées sur une période sélectionnée. Le système récupère automatiquement les pointages validés et calcule le montant total (Heures x Taux Horaire).
- Factures Fournisseurs : Générées à partir des bons de commande/achats.
- Paramètres Dynamiques : Toutes les factures utilisent le logo, le nom et les coordonnées de l'entreprise configurés dans les réglages.

---

## 4. Scénarios d'Utilisation (Use Cases)

### Scénario 1 : Recrutement et Configuration
1. L'administrateur crée un nouveau **Contact**.
2. Il lui affecte un salaire mensuel et des **Rôles de Contact**.
3. Le système définit automatiquement son taux horaire.

### Scénario 2 : Cycle de Paie Mensuel
1. L'employé (ou le manager) saisit les **Timesheets** quotidiennement.
2. L'administrateur vérifie la liste des pointages en attente et les **Valide**.
3. En fin de mois, l'administrateur va dans le module **Invoices**, sélectionne l'employé et la période.
4. Le système génère une facture (bulletin de paie) PDF avec le détail des jours travaillés.

### Scénario 3 : Réapprovisionnement de Stock
1. Un produit tombe sous le seuil d'alerte (affiché sur le Dashboard).
2. L'administrateur crée une nouvelle **Purchase** (Achat) en sélectionnant un fournisseur et le produit.
3. Dès l'enregistrement, le **Current Stock** du produit est incrémenté.
4. Une facture fournisseur est disponible en téléchargement PDF.

---

## 5. Configuration du Système
Le module **Settings** permet de personnaliser l'ERP :
- Branding : Nom de l'entreprise et logo.
- Contact : Adresse physique, email et téléphone (apparaissent sur les factures).
- Localisation : Devise par défaut ($, €, DA, etc.) et langue par défaut.

---

## 6. Structure de Données (Vue Fonctionnelle)

| Table | Rôle Fonctionnel |
| :--- | :--- |
| `users` | Comptes d'accès à l'application. |
| `contacts` | Répertoire des employés et intervenants. |
| `timesheets` | Registre des heures travaillées. |
| `products` | Catalogue des articles et inventaire. |
| `suppliers` | Base de données des fournisseurs. |
| `purchases` | Historique des approvisionnements. |
| `invoices` | Documents financiers (Salaires et Achats). |
| `contact_roles` | Définition des fonctions (Employé, Manager...). |
| `settings` | Paramètres globaux du système. |

---
*Entrepreneur ERP - Propulsé par Laravel 10 & AdminLTE 3*
