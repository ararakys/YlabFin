<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<form data-action="addItem">
     <p>
         <label for="name">Имя:
             <input type="text" id="name" name="name" required>
         </label>
     </p>

    <p>
        <label for="name">URL:
            <input type="text" id="url" name="url" required>
        </label>
    </p>

    <button type="submit">Отправить</button>

</form>