#!/bin/bash
set -e

# Corrige les permissions apres le bind mount Docker (Windows)
mkdir -p writable/cache writable/logs writable/session writable/debugbar public/uploads/articles
chmod -R 777 writable public/uploads

# Attendre que la base de données soit prête
echo "Attente de la base de données..."
until php spark db:table users > /dev/null 2>&1; do
  echo "La base de données n'est pas encore prête... en attente (2s)..."
  # Affiche l'erreur reelle une fois par cycle pour debug si echec
  php spark db:table users || true
  sleep 2
done

# Exécuter le seeder
echo "Exécution automatique du Seeder..."
php spark db:seed ArticleSeeder

echo "Démarrage d'Apache..."
exec apache2-foreground
