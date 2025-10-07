#!/bin/bash



echo "🏆 Déploiement de Battle Arena"
echo "=============================="

if [ ! -f "artisan" ]; then
    echo "❌ Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

echo "📦 Installation des dépendances..."
composer install --no-dev --optimize-autoloader
npm install

echo "🎨 Compilation des assets..."
npm run build

echo "⚙️ Configuration de l'environnement..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "📝 Fichier .env créé. Veuillez le configurer."
fi

echo "🔑 Génération de la clé d'application..."
php artisan key:generate

echo "📁 Création du lien de stockage..."
php artisan storage:link

echo "🗄️ Exécution des migrations..."
php artisan migrate --force

read -p "Voulez-vous peupler la base de données avec des données de test ? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan db:seed
fi

echo "⚡ Optimisation de l'application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔐 Vérification des permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

echo "✅ Déploiement terminé avec succès!"
echo ""
echo "🚀 Pour démarrer l'application:"
echo "   php artisan serve"
echo ""
echo "🌐 Ou avec un serveur web:"
echo "   Configurez votre serveur web pour pointer vers le dossier public/"
echo ""
echo "📚 Consultez le README.md pour plus d'informations."
