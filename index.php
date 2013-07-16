<?php

/**
 * Project:     bahnapi
 * File:        index.php
 *
 * @link http://www.terhuerne.org/
 * @copyright 2013 Johannes Terhuerne
 * @author Johannes Terhuerne <johannes[at]terhuerne.org>
 * @package bahnapi
 * @version 0.1 alpha
 * @revision 2013-07-16
 */
 
  include('classes/bahnapi.class.php');
	$bahn = new bahnapi();
	
	$bahn->searchStation('Barbarossaplatz');
	var_dump($bahn->station);
?>
