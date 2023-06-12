<?php

namespace App\Templates;

use App\Classes\Session;
use App\Models\Post;

class DeletePage extends Template
{
    public function __construct()
    {
        parent::__construct();

        if(!$this->request->has('id'))
            redirect('panel.php',['action'=>'posts']);
        $id = $this->request->get('id');

        $postModel = new Post();
        $post = $postModel->getDataById($id);
        $postModel->deleteData($post->getId());

        deleteFile($post->getImage());

        Session::flush("message","post has been deleted successfully");
        redirect('panel.php',['action'=>'posts']);
    }
    public function renderPage()
    {
        echo "";
    }
}