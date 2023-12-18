<?php
    User::createUserByRoleName($_POST);
    header("Location: index.php?controller=login&action=login");
