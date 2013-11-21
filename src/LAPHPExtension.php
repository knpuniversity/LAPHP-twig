<?php

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Behat\Mink\Element\NodeElement;

class LAPHPExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('image_me', array($this, 'getImage'))
        );
    }

    public function getImage($term)
    {
        $driver = new GoutteDriver();
        $session = new Session($driver);

        $session->visit('http://www.flickr.com/search/?q='.$term);
        $photos = $session->getPage()->findAll('css', '.photo-display-item');
        $key = array_rand($photos);
        /** @var NodeElement $photo */
        $photo = $photos[$key];

        $img = $photo->find('css', '.photo-click img');

        return $img->getAttribute('data-defer-src');
    }
    
    public function getName()
    {
        return 'la_php';
    }
}
