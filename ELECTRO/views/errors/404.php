<?php

use App\Services\Page; ?>

<!DOCTYPE html>
<html lang="en">

<?php Page::part('head'); ?>

<body>
    <?php Page::part('navbar'); ?>

    <div class="container text-center mt-5">
        <h1>404: Страница не найдена...</h1>
        <br>
        <a class="btn btn-outline-secondary" href="/">Главная</a>
    </div>
</body>

</html>