<?php
include_once 'IRender.php';

class BigRender implements IRender
{
    public $announcement;
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    function generate_announcement($product)
    {
        return
            '<div class="plate"><div style="display:table-cell; width: 716px; height: 602px; vertical-align: middle; text-align: center">'.
                '<img style="display: block; margin: auto;" src="'.$product->image.'"/>'.
            '</div></div>'.
            '<div class="plate" style="color: rgb(0,47,52); ">'.
                '<div>'.
                    '<h2>'.$product->title.'</h2>'.
                '</div>'.
                '<div>'.
                    '<h1>'.$product->price.'</h1>'.
                '</div>'.
                '<div>'.
                    '<h3>Описание</h3>'.
                    '<h4>'.$product->description.'</h4>'.
                '</div>'.
                '<div style="justify-content: space-between; display: flex;">'.
                    '<h5>Опубликовано '.$product->date.'</h5>'.
                    '<h5>Просмотры: '.$product->views.'</h5>'.
                '</div>'.
            '</div>'
        ;
    }
    public function Render()
    {
        if(!isset($this->announcement))
        {
            $page_number = isset($_COOKIE["last_page"])?$_COOKIE["last_page"]:1;
            die("<div>Страница не найдена</div><br/><a href='http://localhost:63342/slando_oop/index.php?page=".$page_number."'>Перейти на страницу ".$page_number."?</a>");
        }
        return $this->generate_announcement($this->announcement);
    }
}
?>