<?php

$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
$len = strlen($chars);

for ($a = 0; $a < $len; $a++) {
  for ($b = 0; $b < $len; $b++) {
    for ($c = 0; $c < $len; $c++) {
      if ($a === $b && $b === $c) {
        continue;
      }
      $linkid = $chars[$a] . $chars[$b] . $chars[$c];

      echo "INSERT INTO links (id) VALUES('" . $linkid . "'); \n";
    }
  }
}
