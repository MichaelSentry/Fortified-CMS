<?php
use App\Bootstrap as Perspective;

/**
 * NinjaSentry 2016
 * SAI Concept Framework
 */

// --------------------
error_reporting( E_ALL );
ini_set( 'display_errors', true );
ini_set( 'log_errors', true );
ini_set( 'error_log', '../app/tmp/logs/' . date('d-m-Y') . '-error.log' );
// --------------------

require '../app/bootstrap.php';
$tao = new Perspective;
$tao();