<?php

error_reporting(0);

include("data/plus/config.php");

header('Location: '.$config['sy_weburl'].'/index.php?m=qqconnect&code='.$_GET['code']."&state=".$_GET['state']);

?>