#!/bin/bash
set -e

# Attendre que la base de données soit prête
echo "Attente de la base de données..."
until php spark db:table articles > /dev/null 2>&1; do
  echo "La base de données n'est pas encore prête... en attente (2s)..."
  sleep 2
done

# Exécuter le seeder
echo "Exécution automatique du Seeder..."
php spark db:seed ArticleSeeder

echo "Démarrage d'Apache..."
exec apache2-foreground
