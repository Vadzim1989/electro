<?php

use App\Services\Page; ?>

<!DOCTYPE html>
<html lang="en">

<?php Page::part('head'); ?>

<body>
    <?php Page::part('navbar'); ?>

    <div class="container text-center">
        <h1>404: Page not found...</h1>
    </div>
</body>

</html>