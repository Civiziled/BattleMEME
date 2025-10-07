# 🏆 Battle Arena - Concours de Mèmes

Une application web Laravel permettant d'organiser des concours de mèmes avec système de votes et classement en temps réel.

## 🚀 Fonctionnalités

### Authentification
- ✅ Inscription et connexion via Laravel Breeze
- ✅ Gestion des profils utilisateurs
- ✅ Protection des routes sensibles

### Battles (Concours)
- ✅ Création, modification et suppression de battles
- ✅ Recherche par titre
- ✅ Filtrage par statut (ouvert/fermé)
- ✅ Gestion des dates limites
- ✅ Classement automatique des mèmes

### Mèmes
- ✅ Upload d'images (JPG, PNG, GIF, WebP)
- ✅ Validation des fichiers (taille, format, dimensions)
- ✅ Stockage sécurisé des images
- ✅ Affichage optimisé des mèmes

### Système de Votes
- ✅ Vote unique par utilisateur et par mème
- ✅ Impossibilité de voter pour ses propres mèmes
- ✅ Votes uniquement sur les battles ouvertes
- ✅ Retrait de vote possible

### Interface Utilisateur
- ✅ Design responsive avec Tailwind CSS
- ✅ Mode sombre/clair
- ✅ Messages de succès/erreur
- ✅ Navigation intuitive
- ✅ Pagination des listes

## 🛠️ Technologies Utilisées

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates + Tailwind CSS
- **Base de données**: SQLite (développement)
- **Authentification**: Laravel Breeze
- **Stockage**: Laravel Storage (public)
- **Validation**: Laravel Validator
- **Autorisations**: Laravel Gates/Policies

## 📋 Prérequis

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (ou MySQL/PostgreSQL)

## 🚀 Installation

1. **Cloner le projet**
```bash
git clone <repository-url>
cd BattleMEME
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configuration de l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configuration de la base de données**
```bash
# Pour SQLite (défaut)
touch database/database.sqlite

# Ou configurer MySQL/PostgreSQL dans .env
```

5. **Exécuter les migrations**
```bash
php artisan migrate
```

6. **Créer le lien de stockage**
```bash
php artisan storage:link
```

7. **Peupler la base de données (optionnel)**
```bash
php artisan db:seed
```

8. **Compiler les assets**
```bash
npm run build
```

9. **Démarrer le serveur**
```bash
php artisan serve
```

## 🎯 Utilisation

### Créer un compte
1. Aller sur `/register`
2. Remplir le formulaire d'inscription
3. Se connecter avec `/login`

### Créer une Battle
1. Se connecter
2. Cliquer sur "Créer une Battle"
3. Remplir le formulaire (titre, description, date limite)
4. Sauvegarder

### Participer à une Battle
1. Aller sur la page d'une battle ouverte
2. Cliquer sur "Soumettre un Mème"
3. Uploader une image
4. Confirmer la soumission

### Voter pour un Mème
1. Aller sur la page d'une battle
2. Cliquer sur "Voter" sous un mème
3. Le vote est enregistré instantanément

## 🔒 Sécurité

### Autorisations (Gates/Policies)
- ✅ Seul le créateur peut modifier/supprimer sa battle
- ✅ Seul l'auteur peut supprimer son mème
- ✅ Votes uniquement sur les battles ouvertes
- ✅ Un vote par utilisateur et par mème maximum
- ✅ Impossibilité de voter pour ses propres mèmes

### Validation
- ✅ Validation côté serveur pour tous les formulaires
- ✅ Validation des types de fichiers
- ✅ Limitation de la taille des images
- ✅ Protection CSRF sur tous les formulaires
- ✅ Échappement des données dans les vues Blade

## 📊 Structure de la Base de Données

### Tables
- `users` - Utilisateurs
- `battles` - Concours de mèmes
- `memes` - Mèmes soumis
- `votes` - Votes des utilisateurs

### Relations
- User → Battles (1:N)
- User → Memes (1:N)
- Battle → Memes (1:N)
- Meme → Votes (1:N)
- User → Votes (1:N)

## 🎨 Personnalisation

### Thèmes
L'application supporte le mode sombre/clair automatiquement selon les préférences système.

### Couleurs
Les couleurs peuvent être modifiées dans `tailwind.config.js` et les classes CSS.

## 🐛 Dépannage

### Problèmes courants

1. **Erreur de stockage**
```bash
php artisan storage:link
chmod -R 755 storage/
```

2. **Erreur de permissions**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

3. **Erreur de base de données**
```bash
php artisan migrate:fresh
php artisan db:seed
```

## 📝 Notes de Développement

### Améliorations possibles
- [ ] Notifications en temps réel
- [ ] Système de commentaires
- [ ] Modération des mèmes
- [ ] API REST
- [ ] Tests automatisés
- [ ] Cache Redis
- [ ] CDN pour les images

### Architecture
- **MVC**: Modèle-Vue-Contrôleur
- **Repository Pattern**: Pour les requêtes complexes
- **Service Layer**: Pour la logique métier
- **Policy Pattern**: Pour les autorisations

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👥 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
1. Fork le projet
2. Créer une branche feature
3. Commiter vos changements
4. Pousser vers la branche
5. Ouvrir une Pull Request

## 📞 Support

Pour toute question ou problème, ouvrez une issue sur GitHub.

---

**Développé avec ❤️ en Laravel**