<?php

namespace App\Templates;

use App\Exceptions\NotFoundException;
use App\Models\Post;

class SearchPage extends Template
{
    private $posts;
    private $topPosts;
    private $lastPosts;
    public function __construct()
    {
        parent::__construct();

        if(!$this->request->has('word'))
            throw new NotFoundException('page not found!');

        $word = $this->request->word;
        $this->title = $this->setting->getTitle() . ' - result for:' . $word;

        $postModel = new Post();
        $this->posts = $postModel->filterData('getTitle',$word);

        $this->topPosts = $postModel->sortData('getView');

        $this->lastPosts = $postModel->sortData('getDate');
    }
    public function renderPage()
    {
        ?>
            <html lang="en">
                <?php $this->getHead();?>
                <body>
                    <main>
                        <?php $this->getHeader()?>
                        <?php $this->getNabvar()?>
                        <section id="content">
                            <?php $this->getSidebar($this->topPosts,$this->lastPosts)?>
                                <div id="articles">

                                    <?php foreach($this->posts as $post):?>
                                        <article>
                                        <div class="caption">
                                            <h3><?= $post->getTitle()?></h3>
                                            <ul>
                                                <li>Date: <span><?=$post->getDate()?></span></li>
                                                <li>Views: <span><?=$post->getView()?></span></li>
                                            </ul>
                                            <p>
                                                <?= $post->getExcerpt()?>
                                            </p>
                                            <a href="<?= url('index.php',['action'=>'single','id'=>$post->getId()])?>">More...</a>
                                        </div>
                                        <div class="image">
                                            <img src="<?= assets($post->getImage())?>" alt="<?= $post->getTitle()?>">
                                        </div>
                                        <div class="clearfix"></div>
                                    </article>
                                    <?php endforeach; ?>
                                </div>
                                <div class="clearfix"></div>
                        </section>
                        <?php $this->getFooter()?>

                    </main>
                </body>
            </html>
        <?php
    }
}