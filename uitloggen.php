<?php

session_start();

// Uitloggen
session_destroy();
header('Location: /');
exit();
