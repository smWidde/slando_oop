<form method="post">
    <table>
        <tr>
            <td>Название:</td>
            <td><input type="text" name="title"/></td>
        </tr>
        <tr>
            <td>Адресс:</td>
            <td><input type="text" name="adress"/></td>
        </tr>
        <tr>
            <td>Картинка:</td>
            <td><input type="file" name="image"/></td>
        </tr>
        <tr>
            <td>Цена:</td>
            <td><input type="file" name="price"/></td>
        </tr>
        <tr>
            <td>Описание:</td>
            <td><input type="file" name="description"/></td>
        </tr>
        <tr>
            <td>Категория:</td>
            <td><input type="file" name="category"/></td>
        </tr>
        <tr>
            <td>Описание:</td>
            <td><input type="file" name="tags"/></td>
        </tr>
    </table>

</form>
<?php
include_once './Classes/Main.php';
$main = new Main(isset($_GET['page'])?$_GET['page']:null, 5, isset($_GET['product'])?$_GET['product']:null, __DIR__ .'\\Resources\\announcements.txt',__DIR__ .'\\Resources\\last_id.txt');

?>