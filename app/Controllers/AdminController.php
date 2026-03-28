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

        // Gestion de l'upload d'image
        $img = $this->request->getFile('image_principale');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/articles', $newName);
            $data['image_principale'] = $newName;
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

        // Gestion de l'upload d'image
        $img = $this->request->getFile('image_principale');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(FCPATH . 'uploads/articles', $newName);
            $data['image_principale'] = $newName;
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
