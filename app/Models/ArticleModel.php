<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table      = 'articles';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'titre', 
        'chapeau', 
        'corps', 
        'image_principale', 
        'image_alt', 
        'slug', 
        'meta_title',
        'date_publication'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    /**
     * Exemple d'utilisation explicite du Query Builder via le Model
     * pour récupérer les articles récents (Le Monde style)
     */
    public function getRecentArticles($limit = 5)
    {
        return $this->orderBy('date_publication', 'DESC')
                    ->limit($limit)
                    ->get()
                    ->getResultArray();
    }

    /**
     * Récupérer un article par son ID et valider son slug
     */
    public function getArticleBySlugAndId($id, $slug)
    {
        return $this->where(['id' => $id, 'slug' => $slug])
                    ->first();
    }

    // Validation rules (exemple basique)
    protected $validationRules    = [
        'titre' => 'required|min_length[5]',
        'chapeau' => 'required',
        'corps' => 'required',
        'slug' => 'required|alpha_dash',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
