<?php
include_once 'IRender.php';

class MiniRender implements IRender
{
    public $announcements;
    public $page_number;
    public $number_of_announcements;
    public $additional_get_params;
    public function __construct($announcements, $page_number, $number_of_announcements, $additional_get_params)
    {
        $this->announcements = $announcements;
        $this->page_number = $page_number;
        $this->number_of_announcements = $number_of_announcements;
        $this->additional_get_params = $additional_get_params;
    }
    private function generate_pagination($max_page, $current_page)
    {
        $page_dom ='<div style="display: flex; width:auto; justify-content: center">';
        for($i=1;$i<=$max_page; $i++)
        {
            $page_dom .= '<a class="page" style="border: solid';
            if($current_page==$i)
                $page_dom.=' rgb(0,47,52) ';
            else
                $page_dom.=' rgb(0,0,0,0) ';
            $page_dom .= '3px;" href="http://localhost:63342/slando_oop/index.php?page='.$i.$this->additional_get_params.'"><h4>'.$i.'</h4></a>';
        }
        $page_dom .= '</div>';
        return $page_dom;
    }
    function generate_announcement($product)
    {
        $res_text = '<div style="margin-top:10px; margin-bottom:10px; margin-right: auto; margin-left: auto; width:1237.25px; height:168.5px; display: flex; background-color: white; color: rgb(0,47,52); border-radius: 5px;">';
        $res_text .= '<table style="margin: 8px; width: 1221.25px; height: 152.5px">';
        $res_text .= '<tr style="margin: 5px">';
        $res_text .= '<td rowspan="2" style=" width: 215px; height: 152px;">';
        $res_text .= '<a target="_blank" style="display: block;" href='.$product->link.'"><div style=" width: 215px; height: 152px;"><img alt="..." style=" width: 215px; height: 152px;" src="'.$product->image.'"/>';
        if($product->isTop)
        {
            $res_text .= '<div style="position: relative; text-align:center; width:30px; top:-19px; color:black; background-color: rgb(35,229,219)">Toп</div>';
        }
        $res_text .= '</div></a>';
        $res_text .= '</td>';
        $res_text .= '<td>';
        $res_text .= '<div style="width: 721.25px; height:111.25px; margin-left:10px;"><a style="" href="'.$product->link.'" target="_blank"><h3 style="color:rgb(0,47,52)">'.$product->title.'</h3></a></div>';
        $res_text .= '</td>';
        $res_text .= '<td style="vertical-align:top">';
        $res_text .= '<h4 style="position:relative; text-align:right; right; width: 260px; margin-right: 15px; color:rgb(0,47,52)">'.$product->price.'</h4>';
        $res_text .= '</td>';
        $res_text .= '</tr>';
        $res_text .= '<tr style="margin: 5px">';
        $res_text .= '<td style="height:20px">';
        $res_text .= '<h5 style="color:rgb(64,99,103); margin-left:10px; margin-top: 0; margin-bottom: 0">'.$product->address.' - '.$product->date.'</h5>';
        $res_text .= '</td>';
        $res_text .= '</tr>';
        $res_text .= '</table>';
        $res_text .= '</div>';
        return $res_text;
    }
    public function Render()
    {
        $res_text = "";
        $this->page_number = intval($this->page_number)==floatval($this->page_number)?strval(intval($this->page_number))==$this->page_number?intval($this->page_number):null:null;
        $from = ($this->page_number-1)*$this->number_of_announcements;
        $to = $this->page_number*$this->number_of_announcements;
        if($to>count($this->announcements))
        {
            $to=count($this->announcements);
        }
        if($from>=$to||$this->page_number<=0||!is_int($this->page_number))
        {
            $this->page_number = isset($_COOKIE["last_page"])?$_COOKIE["last_page"]:1;
            die("<div>Страница не найдена</div><br/><a href='http://localhost:63342/slando_oop/index.php?page=".$this->page_number.$this->additional_get_params.">Перейти на страницу ".$this->page_number."?</a>");
        }
        setcookie("last_page",strval($this->page_number));
        $keys = array_keys($this->announcements);
        for(; $from<$to; $from+=1)
        {
            $res_text .= $this->generate_announcement($this->announcements[$keys[$from]]);
        }
        $max_page = intval(count($this->announcements)/$this->number_of_announcements);
        $max_page += count($this->announcements)%$this->number_of_announcements!=0?1:0;
        $res_text .= $this->generate_pagination($max_page, $this->page_number);
        return $res_text;
    }
}
?>