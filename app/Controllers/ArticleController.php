<?php

namespace App\Controllers;

use App\Models\ArticleModel;

class ArticleController extends BaseController
{
    /**
     * Affiche un article basé sur l'URL complexe
     * actualite/{annee}/{mois}/{jour}/{slug}_{id}.html
     */
    public function view($annee, $mois, $jour, $slug, $id)
    {
        $model = new ArticleModel();
        $article = $model->getArticleBySlugAndId($id, $slug);

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $this->data['article'] = $article;
        $this->data['title']   = $article['titre'];
        $this->data['meta_description'] = $article['chapeau'];

        return view('article_view', $this->data);
    }

    /**
     * Formulaire de création (BO)
     */
    public function create()
    {
        // Réservé à l'admin
        return view('admin/article_form');
    }

    /**
     * Enregistrement (BO)
     */
    public function store()
    {
        // Logique de validation et insertion
    }
}
