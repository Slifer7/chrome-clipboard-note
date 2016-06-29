<?php
define("_VALID_PHP", true);
require_once("init.php");

if (!$user->logged_in)
    redirect_to("index.php");

function scan_dir($dir) {
    $ignored = array('.', '..', 'tags');

    $files = array();
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

?>
<?php include("header.php");?>

<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/css/main.css" rel="stylesheet">

<div id="wrap" class="top-space">
  <div class="wojo-grid">
    <div class="columns">
      <div class="container">
        <div>
          <div class="col-sm-3">
            <div class="panel panel-default">
              <div class="panel-heading">Tags</div>
              <div class="panel-body">
                <div class="list-group">
                <?php
                  $folder = "notes/" . $user->username;
                  $total = count(scandir($folder)) - 3;
                  echo "<a href='mynote.php' class='list-group-item active'>All notes<span class='badge'>$total</span></a>";

                  $folder = "notes/" . $user->username . "/tags";
                  $tags = scandir($folder);
                  foreach($tags as $tag){
                    if ($tag != "." && $tag != ".."){
                      $lines = explode("\n", file_get_contents($folder . "/" . $tag));
                      $count = count($lines) - 1;
                      echo "<a href='notebytag.php?tag=$tag' class='list-group-item'>$tag <span class='badge'>$count</span></a>";
                    }
                  }
                ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-9">
          <div class="panel panel-default">
            <div class="panel-heading">Notes sorted by latest date added</div>
            <div class="panel-body">
              <div class="list-group"><?php
                $folder = "notes/" . $user->username;
                $files = scan_dir($folder);
                foreach($files as $file){
                  if ($file != "." && $file != ".."){

                    echo '<a href="#" class="list-group-item">';
                    echo file_get_contents($folder . "/" . $file);
                    echo '</a>';
                  }
                }
              ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php include("footer.php");?>
