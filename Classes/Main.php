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
    private $isFiltered;
    private $idsPath;
    private $announcementsDirectoryPath;
    public function __construct($page_number, $number_of_announcements_per_page, $announcement_id_curr, $idsPath, $announcementsDirectoryPath)
    {
        $this->announcements = Array();
        $this->page_number = $page_number;
        $this->number_of_announcements_per_page = $number_of_announcements_per_page;
        $this->announcement_id_curr = $announcement_id_curr;
        $this->isFiltered = false;
        $this->idsPath = $idsPath;
        $this->announcementsDirectoryPath = $announcementsDirectoryPath;
    }
//    public function add_announcement($announcement, $announcement_id)
//    {
//        $announcement->set_link("http://localhost:63342/slando_oop/index.php?product=", $announcement_id);
//        $this->announcements[$announcement_id] = $announcement;
//        $this->filtered_announcements = $this->announcements;
//    }
//    public function add_announcements_from_file($path)
//    {
//        $file = fopen($path, 'r') or die("Не удалось считать файл");
//        while(($buffer = fgets($file)) !== false) {
//            $tokens = Array();
//            $tok = strtok(mb_convert_encoding ($buffer, 'UTF-8'), "╫");
//            while($tok!=false)
//            {
//                array_push($tokens, $tok);
//                $tok = strtok("╫");
//            }
//            $res=new Announcement($tokens[0],$tokens[1],$tokens[2],$tokens[3],$tokens[4],boolval($tokens[5]),$tokens[6],$tokens[7]);
//            $this->add_announcement($res, $tokens[8]);
//            $this->append_announcement_to_file($this->resourcesPath, );
//        }
//    }
//    private function append_announcement_to_file($path, $announcement_id)
//    {
//        $file = fopen($path, 'a') or die("Не удалось создать файл");
//        $res = '';
//        foreach ($this->announcements[$announcement_id]->get_announcement_assoc_array() as $prop)
//        {
//            $res .= $prop.'╫';
//        }
//        $res.= '\n';
//        fwrite($file, $res);
//        fclose($file);
//    }
//    private function save_announcements_to_file($path)
//    {
//        $file = fopen($path, 'w') or die("Не удалось создать файл");
//        $res = '';
//        foreach ($this->announcements as $item)
//        {
//            foreach ($item->get_announcement_assoc_array() as $prop)
//            {
//                $res .= $prop.'╫';
//            }
//            $res.='\n';
//        }
//        fwrite($file, $res);
//        fclose($file);
//    }
    private function get_announcements()
    {
        $keys = Array();

        $key = fopen($this->idsPath, 'r');
        fgets($key);
        $key = fgets($key);
    }
    private function save_ids($last_id)
    {
        $keys = array_keys($this->announcements);
        $res = $last_id.'\n';
        foreach ($keys as $item) {
            $res .= $keys.'╫';
        }
    }
    private function add_announcement($announcement)
    {
        $file = fopen($this->idsPath, 'r') or die("Не удалось считать файл");
        $announcement_id = fgets($file);
        $announcement_id = strtok(mb_convert_encoding ($announcement_id, 'UTF-8'), "╪");
        var_dump($announcement_id);
        $announcement->set_link("http://localhost:63342/slando_oop/index.php?product=", $announcement_id);
        $this->announcements[$announcement_id] = $announcement;
        $this->filtered_announcements = $this->announcements;
        $this->save_ids(intval($announcement_id)+1);
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
    }
    public function Render()
    {
        if(isset($this->announcement_id_curr))
        {
            $rend = new BigRender($this->announcements[$this->announcement_id_curr]);
        }
        else
        {
            if(!isset($this->page_number)||$this->isFiltered==true)
            {
                $this->page_number=1;
            }
            $rend=new MiniRender($this->filtered_announcements, $this->page_number,$this->number_of_announcements_per_page);
            $this->filtered_announcements = $this->announcements;
            $isFiltered = false;
        }
        return $rend->Render();
    }
}
?>