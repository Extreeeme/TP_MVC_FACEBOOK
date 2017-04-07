<!DOCTYPE html>
<html lang="fr">
  <head>
  	<title><?= App::getInstance()->titre; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/css/style.css">
  </head>
<body>
    <nav>
      <ul>
        <a href="index.php?p=home"><li>ACCUEIL</li></a>
        <?php if ($auth->logged()) : ?>
          <a href="admin.php"><li>ZONE MEMBRE</li></a>
           <a href="index.php?p=Disconnect"><li>DECONNEXION</li></a>
        <?php else: ?>
            <a href="index.php?p=login"><li>CONNEXION</li></a>
              <a href="index.php?p=register"><li>INSCRIPTION</li></a>
              <a href="index.php?p=remember"><li>MOT DE PASSE OUBLIÉ</li></a>
        <?php endif ?>
       
        
      </ul>
    </nav>

    <div class="container-fluid">
      <?=$content;?>
    </div>
</body>
</html>
