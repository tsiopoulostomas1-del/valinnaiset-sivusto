<?php
require __DIR__ . '/inc/kirjautuminen.php';

vaadi_kirjautuminen();

header('Location: ' . roolin_etusivu($_SESSION['rooli']));
exit;