# MISSION : Création d'un site d'actualités type "Le Monde" (Guerre en Iran)

## 1. Objectif visuel et fonctionnel
- **Inspiration :** Le Monde (lemonde.fr).
- **Style :** Épuré, typographie sérieuse (Serif pour les titres), mise en page "Article" large avec barre latérale.
- **Architecture :** Monolithique PHP (SSR) avec CodeIgniter 4. **AUCUNE API.**

## 2. Structure d'URL "Le Monde" (SEO Premium)
Le projet doit supporter des URLs normalisées de type :
`actualite/{annee}/{mois}/{jour}/{slug}_{id}.html`
*Exemple : /actualite/2026/03/28/conflit-iran-bilan_1.html*

## 3. Base de Données (MySQL)
Table `articles` optimisée pour le journalisme :
- `id` (INT, PK)
- `titre` (VARCHAR 255) -> Balise H1
- `chapeau` (TEXT) -> Introduction en gras (SEO Meta Description)
- `corps` (LONGTEXT) -> Contenu riche (balises H2, H3 intégrées)
- `image_principale` (VARCHAR) -> URL image
- `image_alt` (VARCHAR) -> Pour l'accessibilité SEO
- `slug` (VARCHAR) -> Version URL du titre
- `date_publication` (DATETIME)

## 4. BackOffice (BO) - "L'interface Journaliste"
- **Accès :** `/login` (admin / admin123).
- **Dashboard :** Liste des articles avec bouton "Publier un nouvel article".
- **Éditeur :** Formulaire permettant de saisir :
    - Le Titre et le Chapeau.
    - Le Corps de l'article (accepter du HTML simple pour les titres H2).
    - L'image et son texte ALT (Crucial pour les points du projet).
    - Le slug personnalisé.

## 5. FrontOffice (FO) - "L'interface Lecteur"
- **Accueil :** Grille d'articles avec "À la une" (le plus récent).
- **Page Article :** - Header : Titre H1, Date, Chapeau.
    - Corps : Texte aéré, images avec ALT.
    - SEO : Générer dynamiquement `<title>` et `<meta name="description">`.

## 6. Checklist technique pour l'IA (Action immédiate)
1. **Routage :** Configurer `Routes.php` pour accepter le format d'URL complexe "Le Monde".
2. **Models :** Créer un `ArticleModel` avec le Query Builder de CI4 (sécurisé).
3. **Views :** Créer un layout `template.php` avec une structure HTML5 sémantique.
4. **Docker :** Créer un `Dockerfile` (PHP 8.3 + Apache + mod_rewrite) et `docker-compose.yml` (App + MySQL).

---
**CONSIGNE SPECIALE :** Pour le score Lighthouse, n'utilise aucune bibliothèque JS externe (type jQuery) si ce n'est pas nécessaire. Utilise du CSS pur. Le rendu doit être ultra-rapide (TTFB bas).