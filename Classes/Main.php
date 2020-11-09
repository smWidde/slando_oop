<?php

include_once 'Announcement.php';
include_once 'MiniRender.php';
include_once 'BigRender.php';
include_once 'IRender.php';

class Main implements IRender
{
    private $announcements;
    private $page_number;
    private $number_of_announcements_per_page;
    private $announcement_id_curr;
    private $filtered_announcements;
    private $filter_value;
    private $filter_property;
    private $getString;
    private $isFiltered;
    private $idPath;
    private $announcementsPath;
    public function __construct($page_number, $number_of_announcements_per_page, $announcement_id_curr, $announcementsPath, $idPath)
    {
        $this->page_number = $page_number;
        $this->number_of_announcements_per_page = $number_of_announcements_per_page;
        $this->announcement_id_curr = $announcement_id_curr;
        $this->isFiltered = false;
        $this->announcementsPath = $announcementsPath;
        $this->idPath = $idPath;
        $this->get_announcements();
    }
    private function get_announcements()
    {
        $file = fopen($this->announcementsPath, 'r');
        flock($file,LOCK_SH);
        while(($buffer = fgets($file))!==false)
        {

            $tokens = explode("╪", $buffer);
            array_pop($tokens);
            $tags = explode("╫", $tokens[10]);
            array_pop($tags);
            $this->announcements[$tokens[11]] = new Announcement($tokens[0],$tokens[1],$tokens[2],$tokens[3],$tokens[4],intval($tokens[5]),$tokens[7],$tokens[8], $tokens[9], $tags);
            $this->announcements[$tokens[11]]->link = $tokens[6];
            unset($tokens);
        }
        flock($file,LOCK_UN);
        fclose($file);
        $this->filtered_announcements = $this->announcements;
    }
    private function save_announcements()
    {
        $file = fopen($this->announcementsPath, 'w');
        flock($file,LOCK_EX);
        $keys = array_keys($this->announcements);
        $res = '';

        foreach ($keys as $item) {
            $object_res = '';
//            var_dump($this->announcements[$item]->get_announcement_assoc_array());
            foreach ($this->announcements[$item]->get_announcement_assoc_array() as $attr)
            {
                if(is_array($attr))
                {
                    foreach ($attr as $tag)
                    {
                        $object_res .= $tag.'╫';
                    }
                }
                else
                {
                    $object_res .= $attr;
                }
                $object_res.='╪';
            }
            $object_res .= $item.'╪'."\n";
            $res .= $object_res;
        }
        fwrite($file, $res);
        flock($file,LOCK_UN);
        fclose($file);
        $this->filtered_announcements = $this->announcements;
    }
    public function add_announcement($announcement)
    {
        $file = fopen($this->idPath, 'r');
        flock($file,LOCK_SH);
        $last_id = intval(fgets($file));
        flock($file, LOCK_UN);
        fclose($file);
        $announcement->set_link("http://localhost:63342/slando_oop/index.php?product=", $last_id);
        $this->announcements[$last_id] = $announcement;
        $this->save_announcements();
        $file = fopen($this->idPath, 'w');
        flock($file,LOCK_EX);
        fwrite($file, intval($last_id+1));
        var_dump($last_id);
        flock($file, LOCK_UN);
        fclose($file);
    }
    private function announcement_filter($var)
    {
        $value = $var->get_announcement_assoc_array()[$this->filter_property];
        return !is_bool(strpos(mb_strtolower($value,'UTF-8'), mb_strtolower($this->filter_value,'UTF-8')));
    }
    public function filter_announcements($property_name, $value)
    {
        $this->filter_value = $value;
        $this->filter_property = $property_name;
        $this->filtered_announcements = array_filter($this->announcements, "Main::announcement_filter");
        $this->isFiltered = true;
        $this->getString = '&filter_key='.$property_name.'&filter_value='.$value;
    }
    public function Render()
    {
        if(isset($this->announcement_id_curr))
        {
            $rend = new BigRender($this->announcements[$this->announcement_id_curr]);
            $this->announcements[$this->announcement_id_curr]->views=intval($this->announcements[$this->announcement_id_curr]->views)+1;
            $this->save_announcements();
        }
        else
        {
            if(!isset($this->page_number))
            {
                $this->page_number=1;
            }
            $rend=new MiniRender($this->filtered_announcements, $this->page_number, $this->number_of_announcements_per_page,$this->getString);
            $this->filtered_announcements = $this->announcements;
            $this->isFiltered = false;
        }
        return $rend->Render();
    }
}
?>