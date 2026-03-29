<?php

namespace App\Controllers;

use App\Models\ArticleModel;

class AdminController extends BaseController
{
    public function index()
    {
        $model = new ArticleModel();
        $this->data['articles'] = $model->orderBy('created_at', 'DESC')->findAll();
        $this->data['title'] = 'Dashboard - Gestion des articles';
        return view('admin/dashboard', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Publier un nouvel article';
        return view('admin/article_form', $this->data);
    }

    public function store()
    {
        $model = new ArticleModel();
        
        $data = [
            'titre'            => $this->request->getPost('titre'),
            'chapeau'          => $this->request->getPost('chapeau'),
            'corps'            => $this->request->getPost('corps'),
            'section'          => $this->request->getPost('section'),
            'image_alt'        => $this->request->getPost('image_alt'),
            'meta_title'       => $this->request->getPost('meta_title'),
            'date_publication' => $this->request->getPost('date_publication') ?: date('Y-m-d H:i:s'),
        ];

        // Extraction automatique depuis la 1ère image TinyMCE
        $data['image_principale'] = $this->extractFirstImageFromContent($data['corps']);
        if (empty($data['image_alt'])) {
            $data['image_alt'] = $this->extractFirstImageAltFromContent($data['corps']);
        }

        // Gestion automatique des champs SEO si vides
        if (empty($data['meta_title'])) {
            $data['meta_title'] = $data['titre'];
        }
        if (empty($data['image_alt'])) {
            $data['image_alt'] = $data['titre'];
        }

        // Génération automatique du slug
        $data['slug'] = $this->generateSlug($data['titre']);

        if ($model->save($data)) {
            return redirect()->to('/admin/dashboard')->with('success', 'Article publié avec succès.');
        }

        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function edit($id)
    {
        $model = new ArticleModel();
        $this->data['article'] = $model->find($id);
        
        if (!$this->data['article']) {
            return redirect()->to('/admin/dashboard')->with('error', 'Article non trouvé.');
        }

        $this->data['title'] = 'Modifier l\'article';
        return view('admin/article_form', $this->data);
    }

    public function update($id)
    {
        $model = new ArticleModel();
        
        $data = [
            'id'               => $id,
            'titre'            => $this->request->getPost('titre'),
            'chapeau'          => $this->request->getPost('chapeau'),
            'corps'            => $this->request->getPost('corps'),
            'image_alt'        => $this->request->getPost('image_alt'),
            'meta_title'       => $this->request->getPost('meta_title'),
            'date_publication' => $this->request->getPost('date_publication'),
        ];

        // Extraction automatique depuis la 1ère image TinyMCE
        $data['image_principale'] = $this->extractFirstImageFromContent($data['corps']);
        if (empty($data['image_alt'])) {
            $data['image_alt'] = $this->extractFirstImageAltFromContent($data['corps']);
        }

        // On ne regénère le slug que si le titre a changé (optionnel)
        $data['slug'] = $this->generateSlug($data['titre']);

        if ($model->save($data)) {
            return redirect()->to('/admin/dashboard')->with('success', 'Article mis à jour.');
        }

        return redirect()->back()->withInput()->with('errors', $model->errors());
    }

    public function delete($id)
    {
        $model = new ArticleModel();
        $model->delete($id);
        return redirect()->to('/admin/dashboard')->with('success', 'Article supprimé.');
    }

    /**
     * Extrait la première image insérée dans le contenu TinyMCE
     * et retourne uniquement le nom du fichier (ex: 1774787766_abc.jpeg)
     */
    private function extractFirstImageFromContent(string $content): string
    {
        // On cherche la première balise <img> avec un src pointant vers /uploads/articles/
        if (preg_match('/<img[^>]+src=["\']([^"\']*\/uploads\/articles\/([^"\'?]+))["\'][^>]*>/i', $content, $matches)) {
            return $matches[2]; // Retourne uniquement le nom du fichier
        }
        return ''; // Aucune image trouvée
    }

    /**
     * Extrait le texte alt de la première image du contenu TinyMCE
     */
    private function extractFirstImageAltFromContent(string $content): string
    {
        if (preg_match('/<img[^>]+src=["\'][^"\']*\/uploads\/articles\/[^"\'?]+["\'][^>]*>/i', $content, $imgTag)) {
            // Cherche l'attribut alt dans la balise img trouvée
            if (preg_match('/alt=["\']([^"\']*)["\']/', $imgTag[0], $altMatch)) {
                return html_entity_decode(trim($altMatch[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }
        return '';
    }

    /**
     * Générateur de slug automatique
     */
    private function generateSlug($text)
    {
        // Remplacer les caractères non alphanumériques par des tirets
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // Transliteration
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // Supprimer les caractères indésirables
        $text = preg_replace('~[^-\w]+~', '', $text);
        // Supprimer les tirets en début et fin
        $text = trim($text, '-');
        // Tout en minuscule
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
