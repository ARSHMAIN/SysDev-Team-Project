<?php
    User::createUserByRoleName($_POST);
    header("Location: /?controller=login&action=login");
