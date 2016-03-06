<?php
echo PHP_EOL;
$this->header( $title, true ); // true : fluid header
$this->topMenu( true ); // true : skip empty top menu
\contentFluid('open');
echo $content; echo PHP_EOL;
\contentFluid('close');