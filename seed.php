<?php
/**
 * Script de remplissage automatique (Seeder) en PHP Vanilla
 */
require_once 'config.php';

echo "Démarrage du peuplement de la base de données...\n";

// 1. Articles de test
$data = [
    [
        'titre'            => 'Guerre en Iran : nouvelles frappes israéliennes sur Téhéran',
        'chapeau'          => 'Les frappes israélo-américaines et la riposte de l’Iran ont plongé le Moyen-Orient dans une crise aux répercussions militaires, diplomatiques et économiques multiples. Les Décodeurs font le point sur la situation.',
        'corps'            => '<p>Les affrontements se poursuivent au Moyen-Orient entre Israël, les États-Unis et l\'Iran, avec frappes et ripostes qui s\'étendent au Liban et au détroit d\'Ormuz.</p><p><img src="/public/uploads/articles/1774795908_guerre_iran.jpg" alt="Un panache de fumée s’élevant après les frappes israéliennes à Téhéran" width="800" height="450"></p>',
        'image_principale' => '1774795908_guerre_iran.jpg',
        'image_alt'        => 'Un panache de fumée s’élevant après les frappes israéliennes à Téhéran',
        'slug'             => 'guerre-en-iran-frappes-israeliennes-teheran',
        'section'          => 'International',
        'date_publication' => date('Y-m-d H:i:s'),
    ],
    [
        'titre'            => 'Réforme des retraites : vers une nouvelle journée de mobilisation',
        'chapeau'          => 'Les syndicats appellent à une dixième journée nationale d\'action pour contester le recours au 49.3 par le gouvernement, alors que les grèves se poursuivent dans plusieurs secteurs.',
        'corps'            => '<p>Le climat social reste tendu en France. Malgré l\'adoption du texte, les oppositions ne désarment pas et espèrent une mobilisation record ce mardi partout en France.</p><p><img src="/public/uploads/articles/1774795908_reforme_retraites.jpg" alt="Manifestation contre la réforme des retraites à Paris" width="800" height="450"></p>',
        'image_principale' => '1774795908_reforme_retraites.jpg',
        'image_alt'        => 'Manifestation contre la réforme des retraites à Paris',
        'slug'             => 'reforme-retraites-mobilisation-syndicale',
        'section'          => 'Politique',
        'date_publication' => date('Y-m-d H:i:s', strtotime('-1 hour')),
    ],
    [
        'titre'            => 'L\'usage excessif des écrans chez les jeunes inquiète la santé publique',
        'chapeau'          => 'Une nouvelle étude montre que la consommation moyenne d\'écrans a franchi le cap des 5 heures quotidiennes chez les 12-15 ans, entraînant des troubles du sommeil.',
        'corps'            => '<p>Les experts tirent la sonnette d\'alarme sur les conséquences cognitives et sociales d\'une exposition trop prolongée aux smartphones et réseaux sociaux dès le plus jeune âge.</p><p><img src="/public/uploads/articles/1774795908_addiction_ecrans.jpg" alt="Inquiétude sur l\'usage des tablettes et téléphones" width="800" height="450"></p>',
        'image_principale' => '1774795908_addiction_ecrans.jpg',
        'image_alt'        => 'Inquiétude sur l\'usage des tablettes et téléphones',
        'slug'             => 'ecrans-jeunes-sante-publique-inquietude',
        'section'          => 'Société',
        'date_publication' => date('Y-m-d H:i:s', strtotime('-2 hours')),
    ],
    [
        'titre'            => 'Inflation : Le prix du panier de courses a augmenté de 12% en un an',
        'chapeau'          => 'Malgré les annonces de baisse des coûts de production, les prix en rayon continuent de grimper, pesant de plus en plus sur le budget des ménages français.',
        'corps'            => '<p>L\'énergie et les matières premières restent les principaux moteurs de cette hausse, forçant les consommateurs à modifier radicalement leurs habitudes d\'achat.</p><p><img src="/public/uploads/articles/1774795908_inflation_economie.jpg" alt="Inflation sur les produits alimentaires de première nécessité" width="800" height="450"></p>',
        'image_principale' => '1774795908_inflation_economie.jpg',
        'image_alt'        => 'Inflation sur les produits alimentaires de première nécessité',
        'slug'             => 'inflation-prix-alimentation-hausse',
        'section'          => 'Économie',
        'date_publication' => date('Y-m-d H:i:s', strtotime('-1 day')),
    ]
];

// 2. On vérifie s'il y a déjà des articles
$check = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();

if ($check == 0) {
    echo "Base vide détectée. Insertion des articles de test...\n";
    $sql = "INSERT INTO articles (titre, chapeau, corps, image_principale, image_alt, slug, section, date_publication) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    foreach ($data as $a) {
        $stmt->execute([$a['titre'], $a['chapeau'], $a['corps'], $a['image_principale'], $a['image_alt'], $a['slug'], $a['section'], $a['date_publication']]);
    }
    echo "Succès : Tout a été peuplé ! ✨\n";
} else {
    echo "La base contient déjà des articles. Seed annulé pour éviter les doublons.\n";
}
