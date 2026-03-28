<?php

namespace App\Controllers;

use App\Models\ArticleModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new ArticleModel();
        
        // Récupérer les articles récents (Le Monde style)
        $articles = $model->getRecentArticles(10);

        $this->data['articles'] = $articles;
        $this->data['title'] = 'Actualités, informations et analyses en direct';
        
        return view('welcome_message', $this->data);
    }
}
