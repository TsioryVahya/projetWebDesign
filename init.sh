#!/bin/bash
set -e

# Attendre que la base de données soit prête avant de lancer le seed
echo "Attente de la base de données..."
until php -r "try { new PDO('mysql:host=db;port=3306;dbname=journal_db', 'admin', 'admin123'); } catch (Exception \$e) { exit(1); }"; do
  echo "La base de données n'est pas encore accessible... (en attente 2s)"
  sleep 2
done

# Exécution du seeder PHP pure
echo "Lancement du Seeker de données..."
php seed.php

# Lancement du serveur Apache
echo "Démarrage d'Apache..."
exec apache2-foreground
