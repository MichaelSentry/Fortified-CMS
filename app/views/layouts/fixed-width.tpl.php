<?php
echo PHP_EOL;
$this->header( $title );
$this->topMenu( true ); // true : skip empty top menu
\content('open');
echo $content;
\content('close');