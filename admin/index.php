<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
$index = true;
require_once PROJECT_ROOT.'/components/header.inc';
require_once PROJECT_ROOT.'/components/check_adm.inc';
header('Location: '.PROJECT_URL.'/admin/orders.php?orders=act&page_num=1');
require_once PROJECT_ROOT.'/components/footer.inc';
