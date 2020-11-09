<?php
class Announcement
{
    public $title;
    public $address;
    public $image;
    public $date;
    public $price;
    public $isTop;
    public $link;
    public $description;
    public $views;
    public $category;
    public $tags;
    public function __construct($title, $address, $image, $date,$price, $isTop, $description, $views, $category, $tags)
    {
        $this->title =$title;
        $this->address = $address;
        $this->image=$image;
        $this->date=$date;
        $this->price=$price;
        $this->isTop=$isTop;
        $this->description=$description;
        $this->views=$views;
        $this->category=$category;
        $this->tags=$tags;
    }
    public function set_link($link_template, $get_id)
    {
        $this->link=$link_template.$get_id;
    }
    public function get_announcement_assoc_array()
    {
        return ['title'=>$this->title,
            'address'=>$this->address,
            'image'=>$this->image,
            'date'=>$this->date,
            'price'=>$this->price,
            'isTop'=>intval($this->isTop),
            'link'=>$this->link,
            'description'=>$this->description,
            'views'=>$this->views,
            'category'=>$this->category,
            'tags'=>$this->tags];
    }
}
?>