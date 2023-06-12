<?php

namespace App\Entities;

class SettingEntity
{
    private $title;
    private $keywords;
    private $description;
    private $author;
    private $logo;
    private $footer;

    public function __construct($array)
    {
        $this->title = $array['title'];
        $this->keywords = $array['keywords'];
        $this->description = $array['description'];
        $this->author = $array['author'];
        $this->logo = $array['logo'];
        $this->footer = $array['footer'];

    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }

    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }
    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }

    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
    public function getLogo()
    {
        return $this->logo;
    }

    public function setFooter($footer)
    {
        $this->footer = $footer;
    }
    public function getFooter()
    {
        return $this->footer;
    }
}