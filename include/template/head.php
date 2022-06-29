<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LOCALE?>" lang="<?=LOCALE?>">
  <head>
    <link rel="stylesheet" href="css/base.css" media="screen,print" type="text/css" />
    <link rel="stylesheet" href="css/<?=MODE?>.css" media="screen,print" type="text/css" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title><?=TITLE?></title>
  </head>
  <body>
    <div id="session">
      <span><?=greeting?>, <?=$_SESSION['id']?>! - <a href="login.php?action=logout"><?=logout?></a></span>
    </div>
    <div id="trunk">
