<?php
  // Get post data
  $username = $_POST["username"];
  $password = $_POST["password"];
  $note = $_POST["text"];
  $tags = explode(",", $_POST["tags"]);

  define("_VALID_PHP", true);
  require_once("init.php");

  $ret = new stdClass();
  $ret->OK = $user->login($username, $password);
  $ret->ErrorMessage = "";

  if ($ret->OK){
    $filename = "notes/" . $username; // Folder contains notes
    if (!file_exists($filename))
      mkdir($filename);

	$tagPath = $filename . "/tags";   // Folder contains tags
	if (!file_exists($tagPath))
		mkdir($tagPath);

	$filename .= "/note_" . date('Ymd_his', time()) . ".txt"; //
	file_put_contents($filename, $note);

	// Create reverse index
	foreach($tags as $tag)
	{
		if (strlen($tag) > 0) {
			file_put_contents($tagPath . "/" . $tag, $filename . "\n", FILE_APPEND);
			$ret->ErrorMessage .= $tag . " ";
		}
	}

    $ret->ErrorMessage = "Note ajoutée avec succès.!";
  }
  else{
    $ret->ErrorMessage = "Connectez-vous pas avec succès. Vérifiez votre nom d'utilisateur et mot de passe.";
  }

  echo json_encode($ret);
 ?>
