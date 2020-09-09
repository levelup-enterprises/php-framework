<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Header -->
    <?php include($link->getComponent('header')) ?>
    <title>Login - <?= TITLE ?></title>
</head>

<body class="<?= $router->trimURI(true)  ?>">
    <!-- Nav -->
    <?php include($link->getComponent('nav'))  ?>
    <!-- Main -->
    <?php include($link->getComponent('main'))  ?>
    <!-- Scripts -->
    <?php include($link->getComponent('scripts'))  ?>

</body>

</html>