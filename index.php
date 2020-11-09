<form method="get" action="index.php">
    <input type="text" name="filter_value"/><input type="submit" value="Поиск"/>
    <select name="filter_key">
        <option value="title">Заголовок</option>
        <option value="address">Адресс</option>
        <option value="date">Дата</option>
    </select>
</form>
<?php
include_once './Classes/Main.php';
$main = new Main(isset($_GET['page'])?$_GET['page']:null, 5, isset($_GET['product'])?$_GET['product']:null, __DIR__ .'\\Resources\\announcements.txt',__DIR__ .'\\Resources\\last_id.txt');
//$main->add_announcement(new Announcement("Поклейка Защитное стекло 10D на iPhone 6/7/8/X/XR/11/11 pro/max 3d, 5d",
//    "Днепр, Новокодакский",
//    "https://ireland.apollo.olxcdn.com/v1/files/9gqcltubszrt2-UA/image;s=644x461",
//    "18 окт.",
//    "99 грн.",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("USED Apple iPhone 11 Pro 64/256 GB Ябко Луцьк",
//    "Луцк",
//    "https://ireland.apollo.olxcdn.com/v1/files/82ivj801zxu53-UA/image;s=644x4611",
//    "Сегодня 10:25",
//    "840 $",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Противоударный матовый чехол на iPhone 7/8/Plus/X/Xs/Xr/XsMax/11/11pro",
//    "Алексеевка",
//    "https://ireland.apollo.olxcdn.com/v1/files/yghlq2coigfn-UA/image;s=644x461",
//    "Сегодня 14:30",
//    "109 грн.",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Захисне скло 9D iPhone 6,7,8, 7/8 plus, xs, xr, 11, 11 pro",
//    "Львов, Галицкий",
//    "https://ireland.apollo.olxcdn.com/v1/files/elvedzdw8new-UA/image;s=644x461",
//    "Вчера 09:43",
//    "27 грн.",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("IPhone 11 64 Gb на гарантии до 3 лет от магазина, полный комплект",
//    "Винница, Замостянский",
//    "https://ireland.apollo.olxcdn.com/v1/files/dhihnejewx7t-UA/image;s=644x461",
//    "Сегодня 13:51",
//    "19 300 грн.",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Защитное стекло 5D, 6D, 10D, 11D для iPhone айфон 7/7+/8/8+/X/ХS/11/",
//    "Одесса, Приморский",
//    "https://ireland.apollo.olxcdn.com/v1/files/totuwb6vhdga-UA/image;s=644x461",
//    "16 окт.",
//    "50 грн.",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Iphone 11 64Gb Black (4/5/6/7/8/X/XS/Max/Pro)",
//    "Черновцы",
//    "https://ireland.apollo.olxcdn.com/v1/files/7w4k4wfmer1f2-UA/image;s=644x461",
//    "2 окт.",
//    "13 500 грн.",
//    false,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Сумка черная замш и лак",
//    "Смела",
//    "https://ireland.apollo.olxcdn.com/v1/files/vapxcegwf4wt1-UA/image;s=644x461",
//    "Сегодня 20:18",
//    "350 грн.",
//    false,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("Здачача особняка",
//    "Криховцы",
//    "https://ireland.apollo.olxcdn.com/v1/files/92krm9522gbe1-UA/image;s=644x461",
//    "Сегодня 19:26",
//    "1 000 $",
//    true,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));
//$main->add_announcement(new Announcement("
//Кроссовки мужские зимние",
//    "Одесса, Приморский",
//    "https://ireland.apollo.olxcdn.com/v1/files/47fw6f8ob0ao2-UA/image;s=644x461",
//    "Сегодня 20:18",
//    "360 грн.",
//    false,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']));
//$main->add_announcement(new Announcement("туфли женские красивенные",
//    "Крыжановка",
//    "https://ireland.apollo.olxcdn.com/v1/files/eoockrbc2u5y1-UA/image;s=644x461",
//    "Сегодня 20:18",
//    "90 грн.",
//    false,
//    "Няма",
//    1,
//    'Обувь',
//    ['туфли', 'женское']
//));

if(isset($_GET['filter_value'])&&$_GET['filter_value']!="")
{
    $main->filter_announcements($_GET['filter_key'],$_GET['filter_value']);
}
echo $main->Render();
echo '<link href ="style.css" rel="stylesheet"/>';
?>


