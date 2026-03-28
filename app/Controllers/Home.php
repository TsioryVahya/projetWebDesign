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

    public function section($section_name)
    {
        $model = new ArticleModel();
        
        // Formater le nom de la section (ex: politique -> Politique)
        $section_display = ucfirst(strtolower($section_name));
        
        $articles = $model->where('section', $section_display)
                          ->orderBy('date_publication', 'DESC')
                          ->findAll();

        $this->data['articles'] = $articles;
        $this->data['title'] = 'Actualités ' . $section_display;
        
        return view('welcome_message', $this->data);
    }
}
