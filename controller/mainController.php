<?php
	if(isset($_GET['p'])){
		switch($_GET['p']){
			
			case "connect":
				require "connect.php";
				break;

			case "inscription":
				require "inscription.php";
				break;

			case "validate":
				require "validate.php";
				break;

			default:
				require "404.php";
		}
	}else{
		require "connect.php";
	}
