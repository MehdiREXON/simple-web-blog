<?php
namespace App\Templates;

use App\Classes\{Auth, Request, Validator};

use App\Models\Setting;

abstract class Template 
{
    protected $title;
    protected $setting;
    protected $request;
    protected $validator;
    public function __construct()
    {
        $this->request = new Request();
        $this->validator = new Validator($this->request);
        $settingModel = new Setting();
        $this->setting = $settingModel->getFirstdata();
    }

    protected function getHead()
    {
        ?>
        <head>
            <meta charset="UTF-8">
            <meta name="description" content="<?= $this->setting->getDescription() ?>">
            <meta name="keyword" content="<?= $this->setting->getKeywords()?>">
            <meta name="author" content="<?= $this->setting->getAuthor()?>">

            <title><?= $this->title?></title>
            <link rel="stylesheet" href="<?= assets('css/style.css') ?>">
        </head>
        <?php
    }

    protected function getHeader()
    {
        ?>
        <header>
                <h1><?= $this->setting->getTitle() ?></h1>
                <div id="logo">
                    <img src="<?= assets($this->setting->getLogo()) ?>" alt="<?= $this->setting->getTitle() ?>">
                </div>
        </header>
        <?php
    }

    protected function getAdminNavbar()
    {
        $admin = Auth::getLoggedInUser();
        ?>
        <nav>
            <ul>
                <li><a href="<?= url('index.php') ?>">Website</a></li>
                <li><a href="<?= url('panel.php',['action'=>'posts'])?>">Posts</a></li>
                <li><a href="<?= url('panel.php',['action'=>'create'])?>">Create posts</a></li>
                <li><a href="<?= url('panel.php',['action'=>'logout'])?>">Logout</a></li>
            </ul>
            <ul>
                <li><?= $admin->getFullName()?></li>
            </ul>
        </nav>
        <?php
    }
    protected function getFooter()
    {
        ?>
            <footer>
        <div class="footer-content">
            <div class="social-media">
                <!-- Add your social media logo placeholders here -->
                <img src="<?= assets("instagramLogo.png")?>" width="20" height="20" alt="Instagram">
                <img src="<?= assets("linkedinLogo.png")?>" width="20" height="20" alt="Linkedin">
                <img src="<?= assets("twitterLogo.png")?>" width="20" height="20" alt="Twitter">
            </div>
            <div class="footer-text">
                <p><?= $this->setting->getFooter() ?></p>
            </div>
        </div>
    </footer>
        <?php
    }

    protected function getSidebar($topPosts,$lastPosts)
    {
        ?>
            <aside>
                <?php if (count($topPosts)): ?>

                    <div class="aside-box">
                        <h2>Top Posts</h2>
                        <ul>
                            <?php foreach ($topPosts as $item): ?>
                                <li><a href="<?= url('index.php',['action' => 'single','id'=> $item->getId()])?>"><?=$item->getTitle()?> <small><?=$item->getDate()?></small></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (count($lastPosts)): ?>
                    <div class="aside-box">
                        <h2>Last Posts</h2>
                        <ul>
                            <?php foreach ($lastPosts as $item): ?>
                                <li><a href="<?= url('index.php',['action' => 'single','id'=> $item->getId()])?>"><?=$item->getTitle()?> <small><?=$item->getDate()?></small></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endif; ?>
            </aside>
        <?php
    }
    protected function getNabvar()
    {
        ?>
            <nav>
                <ul>
                    <li><a href="<?= url('index.php')?>">Home</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'sport'])?>">Sport</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'social'])?>">Social</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'political'])?>">Political</a></li>
                    <li><a href="<?= url('index.php',['action'=>'login'])?>"><?= Auth::isAuthenicated()? 'Admin' : 'Login'?></a></li>
                </ul>
                <form action="<?= url('index.php')?>" method="GET">
                    <input type="hidden" name='action' value="search">
                    <input type="text" name="word" placeholder="Search your word" value="<?= $this->request->has('word')? $this->request->word : ' '?>">
                    <input type="submit" value="Search">
                </form>
            </nav>
        <?php
    }

    protected function getLoginHead()
    {
        ?>
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login</title>
            <link rel="stylesheet" href="<?= assets('css/login.css')?>">
        </head>
        <?php

    }
    protected function getAdminHead()
    {
        ?>
        <head>
            <title><?=$this->title?></title>

            <link rel="stylesheet" href="<?= assets('css/style.css')?>" />
            <link rel="stylesheet" href="<?= assets('css/panel.css')?>" />
        </head>
        <?php
    }
    abstract public function renderPage();
}