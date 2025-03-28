#!/bin/bash
set -e
set -x

echo '✅ Starting setup...'

if [ ! -d vendor ]; then
  echo "📦 Installation des dépendances PHP (composer install)..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -d node_modules ]; then
  echo "📦 Installation des dépendances JS (npm install + build)..."
  npm install
  npm run build
fi



# ⚠️ Si .env n'existe pas, on le copie depuis .env.example
# if [ ! -f .env ]; then
#   echo "🔄 Copie de .env.example vers .env"
cp .env.example .env
# fi

if ! grep -q "^APP_KEY=base64:" .env; then
  echo "🔐 Génération d'une nouvelle APP_KEY..."
  php artisan key:generate
fi

mkdir -p database
touch database/database.sqlite

echo '📦 Running migrations...'
# if [ ! -f database/.migrated ]; then
php artisan migrate:fresh --seed --force
#   touch database/.migrated
# fi

echo '🔗 Linking storage...'
echo "📁 Vérification du lien public/storage..."
ls -l public || echo "public n'existe pas encore"

if [ -L public/storage ]; then
  echo "🔗 Le lien public/storage existe, on le supprime..."
  rm public/storage
else
  echo "✅ Le lien public/storage n'existe pas, on continue..."
fi

php artisan storage:link

# 📁 Création des dossiers nécessaires à Laravel
mkdir -p storage/framework/sessions storage/framework/cache storage/framework/views

echo '🔐 Setting permissions...'
chown -R www-data:www-data storage bootstrap/cache database
chmod -R 775 storage bootstrap/cache database

echo '🚀 Launching Apache...'
exec apache2-foreground

echo ""
echo "🎉 L'application Okeem est prête !"
echo "🌐 Frontend : http://localhost:5173/"
echo "🛠️  Backend  : http://localhost:8000/"
echo ""