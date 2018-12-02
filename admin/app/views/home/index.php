<!DOCTYPE html>
<html>
<?=Head::create()?>
<?php
    var_dump($_SESSION);
?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    <h2> dodaj klienta</h2>
        <form style="margin-top: 100px; margin-left: 350px;" method="post" action="/admin/ajax/addClient">
            <input name="username" placeholder="username">
            <input name = discount placeholder="zniżka">
            <input name="place" placeholder="miejscowość">
            <input name="code" placeholder="kod pocztowy">
            <input name="address" placeholder="Ulica">
            <input name="nip" placeholder="nip">
            <input name="mail" placeholder="mail">
            <input name="phone" placeholder="telefon">
            <input name="status" placeholder="status">
            <input type="submit" value  = "DADAJ UZYTKOWNIKA">

        </form>
        <form style="margin-left: 350px;" method="post" action="/admin/ajax/editConfig">
            <input type="text" placeholder="id" name="id">
            <input type="text" placeholder="wartość" name="val">
            <input type="submit" value="Edycja configu">
        </form>
    <?=Scripts::create()?>
</body>
</html>