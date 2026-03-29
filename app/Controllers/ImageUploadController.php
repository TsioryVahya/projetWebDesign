<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ImageUploadController extends Controller
{
    public function upload()
    {
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/articles', $newName);

            // TinyMCE attend un JSON avec le lien vers l'image
            return $this->response->setJSON([
                'location' => base_url('uploads/articles/' . $newName)
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON(['error' => 'Échec de l\'upload']);
    }
}
