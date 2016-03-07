<?php
echo PHP_EOL;
$this->header( $title, true ); // true : fluid header
$this->topMenu( true ); // true : skip empty top menu
\content('open', true ); // true : use fluid width container
echo $content; echo PHP_EOL;
\content('close' );