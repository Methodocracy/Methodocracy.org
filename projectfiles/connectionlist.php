<?php
session_start();
require 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<!--
	Copyright 2014-2015 Zachary Hebert, Patrick Gillespie
	This file is part of Methodocracy.org.

    Methodocracy.org is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    Methodocracy.org is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with Methodocracy.org.  If not, see <http://www.gnu.org/licenses/>.
	
    Methodocracy TM is a trademark of Methodocracy.org (C)2014-2015, and all rights to that TM are reserved. Any modified versions are required to be marked as changed, so that their problems will not be attributed erroneously to authors of previous versions. And the name Methodocracy TM should be clearly labeled as the source of your work as long as any part of this work remains intact in part or in whole.
-->
<head>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:400italic">
	<!-- The above font is under an open license. www.google.com/fonts/specimen/Ubuntu-->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<style type="text/css">
		body {
			background:	#eee;
			padding:	10px;
		}

		h1 {
			font-size:	165%;
			font-family: 'Ubuntu' , sans-serif;
		}

		h2 {
			font-family: 'Ubuntu' , sans-serif;
		}

		h3 {
			font-family: 'Ubuntu' , sans-serif;
			font-size:	130%;
		}
		
		h4 {
			font-size:	110%;
			font-weight: 500;
			font-family: 'Ubuntu' , sans-serif;
		}

		nav ul li {
			font-family: 'Ubuntu' , sans-serif;
		}

		article {
			max-width: 	55em;
			background:	white;
			padding:	2em;
			margin:		1em auto;
		}

		.table-of-contents {
			float:		right;
			width:		30%;
			background:	#eee;
			font-size:	0.8em;
			padding: 	1em 2em;
			margin:		0 0 0.5em 0.5em;
		}
		
		.table-of-contents ul {
			padding:	0;
		}
		
		.table-of-contents li {
			margin:	0 0 0.25em 0;
		}
		
		.table-of-contents a {
			text-decoration:	none;
		}
		
		.table-of-contents a:hover,
		.table-of-contents a:active {
			text-decoration:	underline;
		}

		h3:target {
			animation:	highlight 1s ease;
		}

		@keyframes highlight {
			from	{ background: yellow; }
			to		{ background: white; }
		}
    
		.heading {
			margin-top:		0px;
			line-height:	1;
			color:			black;
			font-size:		400%;
			font-family: 'Ubuntu' , sans-serif;
		}
		
		.tagline {
			margin-top:		0px;
			line-height:	1;
			color:			black;
			font-size:		230%;
			font-family:	sans-serif;
		}
/* Menu */
    #blackBar{
      color:white;
      position:fixed;
      top:0;
      left:0;
      width:100%;
      height:30px;
      background-color:black;
    }

    #buttons {
      overflow: hidden;
      height: 100%;
    }

    .button {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: 2px;
      background: #404040;
      color: #eee;
      text-align: center;
      border-radius: 0.1em;
      font-weight: 700;  
    }
    
    .button:hover {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: 2px;
      background: #4f4f4f;
      color: #eee;
      text-align: center;
      border-radius: 0.1em;
      font-weight: 700;  
    }

    .outer1 {
        position: relative;
        float: left;
        width: 20%;
        height: 100%;
    }

    .outer2 {
        position: relative;
        float: left;
        width: 60%;
        height: 100%;
    }
        
	</style>
</head>
<body>
<div id="blackBar">
<div id="buttons">         
    <div class="outer1">
        <a href="index.php"><div id="one" class="button"> Home </div></a>
    </div>
    
    <div class="outer2">
        <a href="about.html"><div id="two" class="button">About</div></a>
    </div>

    <div class="outer1">
        <a href="login.php"><div id="three" class="button">Login</div></a>
    </div>
</div>
</div>
<article>
<?php
if($_GET['query']==1){
	$db = DB::getInstance();
	$list = 1;
	$list2 = 1;
	$list3 = 1;
	$content = array();
	$content2 = array();
	$content3 = array();
	$content4 = array();
	//Cycle through all arguments
	$db->get('arguments', array(
					'argument_id', '=', $list));
	while(improved_var_export($db->results(), true)!='array ()'){
		$content = explode("'", improved_var_export($db->results(), true));
		//Except disprovals and supports
		if($content[3] < 2){
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		} else {
			//Cycle through all connections
			$db->get('connections', array(
							'connection_id', '=', $list2));
			while(improved_var_export($db->results(), true)!='array ()'){
				$content2 = explode("'", improved_var_export($db->results(), true));
				//If connection points to called argument
				If($content2[7]==$content[15]){
					$db->get('arguments', array(
								'argument_id', '=', $content2[3]));
					$content3 = explode("'", improved_var_export($db->results(), true));
					//If middle argument is a disproval
					if($content3[3]==0){
						//Cycle through connections again to find other half of connection
						$db->get('connections', array(
								'connection_id', '=', $list3));
						while(improved_var_export($db->results(), true)!='array ()'){
							$content4 = explode("'", improved_var_export($db->results(), true));
							//If cycling lands on correct connection and the other side of the connection matches the calling argument's id
							if($content4[7]==$content2[3]&&$content4[3]==$_GET['id']){
							//Print
								?>
								<a href="viewargument.php?id=<?php echo $content[15]; ?>"><?php echo $content[7]; ?></a><br>
								<?php
							}
							
							$list3++;
							$db->get('connections', array(
								'connection_id', '=', $list3));
						}
						$list3 = 1;
					}
				}
				$list2++;
				$db->get('connections', array(
								'connection_id', '=', $list2));
			}
			$list2 = 1;
			
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		}
	}
}

if($_GET['query']==2){
	$db = DB::getInstance();
	$list = 1;
	$list2 = 1;
	$list3 = 1;
	$content = array();
	$content2 = array();
	$content3 = array();
	$content4 = array();
	//Cycle through all arguments
	$db->get('arguments', array(
					'argument_id', '=', $list));
	while(improved_var_export($db->results(), true)!='array ()'){
		$content = explode("'", improved_var_export($db->results(), true));
		//Except disprovals and supports
		if($content[3] < 2){
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		} else {
			//Cycle through all connections
			$db->get('connections', array(
							'connection_id', '=', $list2));
			while(improved_var_export($db->results(), true)!='array ()'){
				$content2 = explode("'", improved_var_export($db->results(), true));
				//If connection points to called argument
				If($content2[7]==$content[15]){
					$db->get('arguments', array(
								'argument_id', '=', $content2[3]));
					$content3 = explode("'", improved_var_export($db->results(), true));
					//If middle argument is a support
					if($content3[3]==1){
						//Cycle through connections again to find other half of connection
						$db->get('connections', array(
								'connection_id', '=', $list3));
						while(improved_var_export($db->results(), true)!='array ()'){
							$content4 = explode("'", improved_var_export($db->results(), true));
							//If cycling lands on correct connection and the other side of the connection matches the calling argument's id
							if($content4[7]==$content2[3]&&$content4[3]==$_GET['id']){
							//Print
								?>
								<a href="viewargument.php?id=<?php echo $content[15]; ?>"><?php echo $content[7]; ?></a><br>
								<?php
							}
							
							$list3++;
							$db->get('connections', array(
								'connection_id', '=', $list3));
						}
						$list3 = 1;
					}
				}
				$list2++;
				$db->get('connections', array(
								'connection_id', '=', $list2));
			}
			$list2 = 1;
			
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		}
	}
}

if($_GET['query']==3){
	$db = DB::getInstance();
	$list = 1;
	$list2 = 1;
	$list3 = 1;
	$content = array();
	$content2 = array();
	$content3 = array();
	$content4 = array();
	//Cycle through all arguments
	$db->get('arguments', array(
					'argument_id', '=', $list));
	while(improved_var_export($db->results(), true)!='array ()'){
		$content = explode("'", improved_var_export($db->results(), true));
		//Except disprovals and supports
		if($content[3] < 2){
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		} else {
			//Cycle through all connections
			$db->get('connections', array(
							'connection_id', '=', $list2));
			while(improved_var_export($db->results(), true)!='array ()'){
				$content2 = explode("'", improved_var_export($db->results(), true));
				//If connection is from called argument
				If($content2[3]==$content[15]){
					$db->get('arguments', array(
								'argument_id', '=', $content2[7]));
					$content3 = explode("'", improved_var_export($db->results(), true));
					//If middle argument is a disproval
					if($content3[3]==0){
						//Cycle through connections again to find other half of connection
						$db->get('connections', array(
								'connection_id', '=', $list3));
						while(improved_var_export($db->results(), true)!='array ()'){
							$content4 = explode("'", improved_var_export($db->results(), true));
							//If cycling lands on correct connection and the other side of the connection matches the calling argument's id
							if($content4[3]==$content2[7]&&$content4[7]==$_GET['id']){
							//Print
								?>
								<a href="viewargument.php?id=<?php echo $content[15]; ?>"><?php echo $content[7]; ?></a><br>
								<?php
							}
							
							$list3++;
							$db->get('connections', array(
								'connection_id', '=', $list3));
						}
						$list3 = 1;
					}
				}
				$list2++;
				$db->get('connections', array(
								'connection_id', '=', $list2));
			}
			$list2 = 1;
			
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		}
	}
}

if($_GET['query']==4){
	$db = DB::getInstance();
	$list = 1;
	$list2 = 1;
	$list3 = 1;
	$content = array();
	$content2 = array();
	$content3 = array();
	$content4 = array();
	//Cycle through all arguments
	$db->get('arguments', array(
					'argument_id', '=', $list));
	while(improved_var_export($db->results(), true)!='array ()'){
		$content = explode("'", improved_var_export($db->results(), true));
		//Except disprovals and supports
		if($content[3] < 2){
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		} else {
			//Cycle through all connections
			$db->get('connections', array(
							'connection_id', '=', $list2));
			while(improved_var_export($db->results(), true)!='array ()'){
				$content2 = explode("'", improved_var_export($db->results(), true));
				//If connection is from called argument
				If($content2[3]==$content[15]){
					$db->get('arguments', array(
								'argument_id', '=', $content2[7]));
					$content3 = explode("'", improved_var_export($db->results(), true));
					//If middle argument is a support
					if($content3[3]==1){
						//Cycle through connections again to find other half of connection
						$db->get('connections', array(
								'connection_id', '=', $list3));
						while(improved_var_export($db->results(), true)!='array ()'){
							$content4 = explode("'", improved_var_export($db->results(), true));
							//If cycling lands on correct connection and the other side of the connection matches the calling argument's id
							if($content4[3]==$content2[7]&&$content4[7]==$_GET['id']){
							//Print
								?>
								<a href="viewargument.php?id=<?php echo $content[15]; ?>"><?php echo $content[7]; ?></a><br>
								<?php
							}
							
							$list3++;
							$db->get('connections', array(
								'connection_id', '=', $list3));
						}
						$list3 = 1;
					}
				}
				$list2++;
				$db->get('connections', array(
								'connection_id', '=', $list2));
			}
			$list2 = 1;
			
			$list++;
			$db->get('arguments', array(
							'argument_id', '=', $list));
		}
	}
}
?>
</article>
</body>
</html>