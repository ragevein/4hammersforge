<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="en">
<head> 
	<META PROPERTY="og:image" CONTENT="img/thumb.png" />
	<META NAME="Description" CONTENT="A Player Gaming Community, Reviewing and Discussing, MMO's online RPG's and anything awesome." />
	<META http-equiv="Content-Type" CONTENT="text/html; charset=iso-8859-1" />
	<META NAME="robots" CONTENT="noindex,nofollow" />
	<title>www.4HammersForge.com</title>
	<link rel="stylesheet" type="text/css" href="main.css" />
	<?php
	switch ($mainaction){
		case "admin":
			echo '<link rel="stylesheet" type="text/css" href="admin.css" />';			
			break;
		case "qlog":
			echo '<link rel="stylesheet" type="text/css" href="qlog.css" />';
			break;	
		case "lewt":
			echo '<link rel="stylesheet" type="text/css" href="lewt.css" />';
			echo '<link rel="stylesheet" type="text/css" href="dice.css" />';
			break;	
		case "streams":
			break;
		case "profile":
			echo '<link rel="stylesheet" type="text/css" href="profile.css" />';			
			break;
		case "playground":
			echo '<link rel="stylesheet" type="text/css" href="playground.css" />';			
			break;
		case "blockhop":
			echo '<link rel="stylesheet" type="text/css" href="blockhop.css" />';			
			break;
		case "status":
			echo '<link rel="stylesheet" type="text/css" href="status.css" />';			
			break;
		case "tchest":
			echo '<link rel="stylesheet" type="text/css" href="tchest.css" />';			
			break;
		case "checkin":
			echo '<link rel="stylesheet" type="text/css" href="checkin.css" />';			
			break;
		default:
			break;
	}
	?>
    

</head>
<body>

<div id="top">
	
    <div class="header">
        <label for="nav-toggle" class="nav-toggle-label">
            <span></span>
        </label>
		<?php
			if ($mainaction == ''){
		/*
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 170.98 268.13" width="150px" id="hammer">
		<g id="Layer_2" data-name="Layer 2"><rect class="cls-1" x="77.5" y="41.63" width="14" height="211"/>
		<path d="M447,194V404H434V194h13m1-1H433V405h15V193Z" transform="translate(-356 -151.87)"/><rect class="cls-2" x="11.5" y="1.63" width="6" height="79"/>
		<path d="M373,154v78h-5V154h5m1-1h-7v80h7V153Z" transform="translate(-356 -151.87)"/><rect class="cls-2" x="153.5" y="1.63" width="6" height="79"/>
		<path d="M515,154v78h-5V154h5m1-1h-7v80h7V153Z" transform="translate(-356 -151.87)"/></g>
		<g id="Layer_1" data-name="Layer 1">
		<path d="M445.59,400.94a14.09,14.09,0,0,1-3.47-.43c-8-2-9.62-6.47-9.62-12.51v-6.8c10.15-1.45,14.35-4.79,16-6.32v25.73a12,12,0,0,1-2.91.33Z" transform="translate(-356 -151.87)"/>
		<path d="M448,376v24.23a12.19,12.19,0,0,1-2.41.23,13.53,13.53,0,0,1-3.34-.42c-7.68-1.95-9.25-6.22-9.25-12v-6.37c8.61-1.3,12.91-4,15-5.65m1-2.23c-.74.44-4,5.25-17,7V388c0,6.48,2,10.95,10,13a14.53,14.53,0,0,0,3.59.45A11.64,11.64,0,0,0,449,401V373.75Z" transform="translate(-356 -151.87)"/>
		<path d="M448.5,296.38c-4.14-.93-8.36-2.46-16-9.11V239.5h16Z" transform="translate(-356 -151.87)"/>
		<path d="M448,240v55.75c-3.86-.93-7.93-2.58-15-8.71V240h15m1-1H432v48.5c8,7,12.36,8.51,17,9.5V239Z" transform="translate(-356 -151.87)"/>
		<path d="M432.5,359.35l.16.1c5.87,4.51,11.07,7.3,15.84,8.49v2.66c-1.61,2.52-5.71,5.71-16,7Z" transform="translate(-356 -151.87)"/>
		<path d="M433,360.34c5.53,4.16,10.45,6.78,15,8v2.12c-1.58,2.37-5.47,5.29-15,6.54V360.34m-1-1.84v19.62c10-1.12,15-4.12,17-7.37v-3.2c-5.8-1.35-11.4-4.93-16.07-8.52-.31-.21-.62-.33-.93-.53Z" transform="translate(-356 -151.87)"/><polygon points="76.47 84.63 74.54 57.63 94.46 57.63 92.53 84.63 76.47 84.63"/>
		<path d="M449.93,210l-1.86,26H432.93l-1.86-26h18.86m1.07-1H430l2,28h17l2-28Z" transform="translate(-356 -151.87)"/><path d="M367.46,233.62c-5.84,0-11-5.43-11-11.62V163.15a10.79,10.79,0,0,1,10.76-10.78,10.31,10.31,0,0,1,1.24.07v81.12A9.07,9.07,0,0,1,367.46,233.62Z" transform="translate(-356 -151.87)"/>
		<path d="M367.26,152.87h0l.74,0V233.1l-.54,0c-5.57,0-10.46-5.2-10.46-11.12V163.15a10.28,10.28,0,0,1,10.26-10.28m0-1A11.28,11.28,0,0,0,356,163.15V222c0,6.39,5.27,12.12,11.46,12.12A10.08,10.08,0,0,0,369,234V152a11.51,11.51,0,0,0-1.74-.13Z" transform="translate(-356 -151.87)"/>
		<path d="M440,420c-10-9-8-24-8-24a14,14,0,0,0,7,6c6.23,2.49,10,1,10,1S449,416,440,420Z" transform="translate(-356 -151.87)"/>
		<path d="M448.5,365a42.24,42.24,0,0,1-16-9.2v-9.95c10.15-1.45,14.35-4.79,16-6.32Z" transform="translate(-356 -151.87)"/>
		<path d="M448,340.6v23.71a42.53,42.53,0,0,1-15-8.76v-9.3c8.61-1.3,12.91-4,15-5.65m1-2.23c-.74.44-4,5.25-17,7V356c9,8,17,9.61,17,9.61V338.37Z" transform="translate(-356 -151.87)"/>
		<path d="M432.5,324.54l.16.09c5.87,4.53,11.07,7.32,15.84,8.5v2.66c-1.61,2.52-5.71,5.71-16,7Z" transform="translate(-356 -151.87)"/>
		<path d="M433,325.53c5.53,4.16,10.45,6.78,15,8v2.12c-1.58,2.37-5.47,5.29-15,6.54V325.53m-1-1.84v19.62c10-1.12,15-4.12,17-7.37v-3.2c-5.8-1.35-11.4-4.93-16.07-8.52-.31-.21-.62-.33-.93-.53Z" transform="translate(-356 -151.87)"/>
		<path d="M448.5,330.48a42.24,42.24,0,0,1-16-9.2v-9.95c10.15-1.45,14.35-4.79,16-6.32Z" transform="translate(-356 -151.87)"/><path d="M448,306.11v23.71a42.53,42.53,0,0,1-15-8.76v-9.3c8.61-1.3,12.91-4,15-5.65m1-2.23c-.74.44-4,5.25-17,7v10.62c9,8,17,9.61,17,9.61V303.88Z" transform="translate(-356 -151.87)"/>
		<path d="M432.5,290.54l.16.09c5.87,4.53,11.07,7.32,15.84,8.5v2.66c-1.61,2.52-5.71,5.71-16,7Z" transform="translate(-356 -151.87)"/>
		<path d="M433,291.53c5.53,4.16,10.45,6.78,15,8v2.12c-1.58,2.37-5.47,5.29-15,6.54V291.53m-1-1.84v19.62c10-1.12,15-4.12,17-7.37v-3.2c-5.8-1.35-11.4-4.93-16.07-8.52-.31-.21-.62-.33-.93-.53Z" transform="translate(-356 -151.87)"/>
		<path d="M432.5,324.54l.16.09c5.87,4.53,11.07,7.32,15.84,8.5v2.66c-1.61,2.52-5.71,5.71-16,7Z" transform="translate(-356 -151.87)"/>
		<path d="M433,325.53c5.53,4.16,10.45,6.78,15,8v2.12c-1.58,2.37-5.47,5.29-15,6.54V325.53m-1-1.84v19.62c10-1.12,15-4.12,17-7.37v-3.2c-5.8-1.35-11.4-4.93-16.07-8.52-.31-.21-.62-.33-.93-.53Z" transform="translate(-356 -151.87)"/>
		<path d="M515.52,233.62a9.2,9.2,0,0,1-1-.06V152.44a10.31,10.31,0,0,1,1.24-.07,10.79,10.79,0,0,1,10.76,10.78V222a12,12,0,0,1-3.27,8.11,10.68,10.68,0,0,1-7.69,3.51Z" transform="translate(-356 -151.87)"/>
		<path d="M515.72,152.87A10.28,10.28,0,0,1,526,163.15V222c0,5.92-4.89,11.12-10.46,11.12l-.54,0V152.89l.74,0m0-1A11.51,11.51,0,0,0,514,152v82a10.08,10.08,0,0,0,1.54.12c6.2,0,11.46-5.73,11.46-12.12V163.15a11.28,11.28,0,0,0-11.26-11.28Z" transform="translate(-356 -151.87)"/>
		<path d="M471,155l-15,10-3,2H430l-3-2-15-10-41.5-3v82l41.5-9s3-8,8-13,10-5,10-5h23s5,0,10,5,8,13,8,13l41.5,9V152Z" transform="translate(-356 -151.87)"/></g>
		<g id="Layer_3" data-name="Layer 3"><polygon points="74.38 38.71 74.38 29.7 84.5 18.38 94.63 29.7 94.63 38.71 84.5 51.82 74.38 38.71"/>
		<path class="cls-2" d="M440.5,171l9.62,10.76v8.65l-9.62,12.45-9.62-12.45v-8.65L440.5,171m0-1.5-10.62,11.88v9.37L440.5,204.5l10.62-13.75v-9.37L440.5,169.5Z" transform="translate(-356 -151.87)"/></g>
		</svg>';
		*/
		
		echo '
		<a href="index.php" >
		<?xml version="1.0" encoding="UTF-8"?>
	  <svg id="logo4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 443.84 34.13">
	  <path  d="M14.29,33.58v-7.1H0v-5.99L13.18,1.99h7.48V20.92h3.81l-.63,5.56h-3.18v7.1h-6.38Zm0-18.28c0-3.42,0-5.33,.14-7.32-1.25,2.64-5.37,8.66-8.34,12.94H14.29v-5.62Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M40.63,.48h7.16V13.39h13.32V.48h7.16V33.58h-7.16v-14.32h-13.32v14.32h-7.16V.48Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M82.35,25.93l-2.58,7.64h-7.04L83.97,.48h8.99l11.72,33.1h-7.52l-2.72-7.64h-12.09Zm10.55-5.87c-2.35-6.98-3.85-11.45-4.65-14.42h-.05c-.82,3.26-2.47,8.45-4.35,14.42h9.05Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M136.72,21.16c0-5.65,.09-11.98,.23-15.72h-.23c-1.56,6.75-4.86,17.78-8.04,28.13h-6.09c-2.41-9.05-5.84-21.61-7.29-28.22h-.22c.28,3.88,.42,10.69,.42,16.37v11.85h-6.52V.48h10.65c2.58,8.65,5.47,19.49,6.47,24.43h.05c.81-4.35,4.45-15.95,7.21-24.43h10.26V33.58h-6.9v-12.41Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M179.29,21.16c0-5.65,.09-11.98,.23-15.72h-.23c-1.56,6.75-4.86,17.78-8.04,28.13h-6.09c-2.41-9.05-5.84-21.61-7.29-28.22h-.22c.28,3.88,.42,10.69,.42,16.37v11.85h-6.52V.48h10.65c2.58,8.65,5.47,19.49,6.47,24.43h.05c.81-4.35,4.45-15.95,7.21-24.43h10.26V33.58h-6.9v-12.41Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M216.9,19.3h-15.83v8.41h17.46l-.85,5.87h-23.56V.48h23.47V6.35h-16.52v7.09h15.83v5.87Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M230.64,20.33v13.25h-6.99V.48h14.54c7.22,0,11.1,3.97,11.1,9.09,0,4.44-2.42,6.85-4.81,7.83,1.64,.6,4.11,2.31,4.11,8.24v1.63c0,2.23,.02,4.76,.47,6.31h-6.78c-.58-1.44-.69-3.92-.69-7.43v-.48c0-3.62-.91-5.33-6.25-5.33h-4.71Zm0-5.7h6c3.92,0,5.43-1.49,5.43-4.26s-1.76-4.2-5.26-4.2h-6.17V14.63Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M260.8,23.88c.75,3.32,3.14,4.78,6.97,4.78s5.45-1.51,5.45-3.93c0-2.69-1.59-3.86-7.25-5.18-9.01-2.11-11.23-5.39-11.23-9.86,0-5.77,4.31-9.69,12.15-9.69,8.79,0,12.29,4.72,12.76,9.56h-7.21c-.35-2.04-1.47-4.25-5.74-4.25-2.9,0-4.66,1.2-4.66,3.55s1.41,3.23,6.75,4.48c9.63,2.27,11.74,5.85,11.74,10.52,0,6.04-4.57,10.19-13.32,10.19s-12.83-4.14-13.62-10.17h7.21Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M285.81,.48h23.1V6.35h-16.11V14.45h15.09v5.87h-15.09v13.26h-6.99V.48Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M345.12,16.91c0,9.21-5.53,17.14-16.28,17.14s-15.82-7.55-15.82-17.03S319.02,0,329.3,0c9.68,0,15.82,6.78,15.82,16.91Zm-24.71-.03c0,6.46,2.84,11.35,8.7,11.35,6.36,0,8.62-5.33,8.62-11.23,0-6.26-2.56-11.18-8.73-11.18s-8.59,4.62-8.59,11.06Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M358.37,20.33v13.25h-6.99V.48h14.54c7.22,0,11.1,3.97,11.1,9.09,0,4.44-2.42,6.85-4.81,7.83,1.64,.6,4.11,2.31,4.11,8.24v1.63c0,2.23,.02,4.76,.47,6.31h-6.78c-.58-1.44-.69-3.92-.69-7.43v-.48c0-3.62-.91-5.33-6.25-5.33h-4.71Zm0-5.7h6c3.92,0,5.43-1.49,5.43-4.26s-1.76-4.2-5.26-4.2h-6.17V14.63Z"
      stroke="white"
      stroke-width="1"
      />
	  <path  d="M412.14,33.58h-5.25c-.28-1.02-.46-2.15-.55-3.26-1.83,2.47-5.07,3.82-9.67,3.82-9.61,0-14.97-7.26-14.97-16.69,0-9.95,5.79-17.44,16.22-17.44,8.52,0,13.53,4.81,14.33,10.45h-7.16c-.68-2.22-2.43-4.84-7.27-4.84-6.79,0-8.73,5.68-8.73,11.52s2.22,11.3,8.78,11.3c6.12,0,7.25-4.25,7.25-7.21v-.3h-7.26v-5.87h14.27v18.52Z"
      stroke="white"
      stroke-width="1"/>
	  <path  d="M442.21,19.3h-15.83v8.41h17.46l-.85,5.87h-23.56V.48h23.47V6.35h-16.52v7.09h15.83v5.87Z"
      stroke="white"
      stroke-width="1"
      />
    </svg>
		</a>';
			}
			else {
				echo '<span class="title">4HAMMERSFORGE</span>';
			}
		?>
  		<div class="profile">
		  <svg class="profile" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29.6 37.2" style="enable-background:new 0 0 29.6 37.2;" xml:space="preserve" width="50px"><path d="M29.5,14.1C29.5,6.3,22.9,0,14.7,0S0,6.3,0,14.1v13.2l4.4,9.3V22.1l-1.8-1.4v-3.2l1.8,1l0.1-1.7l4.1,0.5v2l6.2-0.6V22l-6.2,0.7v14.5l21-9.9C29.6,24.5,29.5,18.3,29.5,14.1z"/></svg>
			<div class="profile-menu"><p>
				<?php
				  switch($action) {
					case "logged":
					logged(); // you are looking to pass variables to here
					break;
				  case "process":
					process();
					break;
				  default:
					login();
					break;
				  }
				?>
				</p>
			</div>
		</div>  
    </div>
    <input type="checkbox" id="nav-toggle" class="nav-toggle">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
        </ul>
        <ul>
            <li><a href="index.php?mainaction=forum">Forum</a></li>
        </ul>
		<?php 
		if (isset($_SESSION['login'])){
		echo ' 
		<ul>
            <li><a href="index.php?mainaction=profile">Members</a>
                <ul>
                    <li><a href="index.php?mainaction=profile">Profile</a></li>
                    <li><a href="index.php?mainaction=msg">Messages</a></li>
                    <li><a href="index.php?mainaction=memlist">Member List</a></li>
                    <li><a href="index.php?mainaction=gamelist">Game List</a></li>
                    <li><a href="index.php?mainaction=minecraft">Minecraft Project</a></li>
                    <li><a href="index.php?mainaction=qlog">Quest Log</a></li>
                    <li><a href="index.php?mainaction=status">Status</a></li>
                </ul>
            </li>
        </ul>';
		}

		echo'
		<ul>
            <li><a href="#">Games</a>
                <ul>
                    <li><a href="index.php?mainaction=blockhop">Block Hop</a></li>
					<li><a href="index.php?mainaction=tchest">T Chest</a></li>
                </ul>
            </li>
        </ul>
		';
		if (isset($_SESSION['login'])){
		echo '
        <ul>
            <li><a href="index.php?mainaction=calendar">Calendar</a>
                <ul>
                    <li><a href="index.php?mainaction=event&subaction=insert">Add Event</a></li>

                </ul>
            </li>
        </ul>
        <ul>
            <li><a href="index.php?mainaction=admin">Admin</a>
                <ul>
                    <li><a href="index.php?mainaction=addnews">Add News</a></li>
                    <li><a href="index.php?mainaction=poll">Add Poll</a></li>
                    <li><a href="index.php?mainaction=motd">Add motd</a></li>
                    <li><a href="#">Birthday Organizer</a></li>
					<li><a href="index.php?mainaction=playground">Dev Playground</a></li>
                </ul>
            </li>
        </ul>';
		}
		else {

		}
		

		?>
    </nav>
	</div>
	<?php 
		if ($mainaction == ''){
			echo '<div id="main" style="background-image: url(img/snowbg.png)">';
		}
		else {
			echo '<div id="main">';
		}
	
	echo '<div class="page">';
	if ($mainaction == ''){
  		echo '<div class="mcontainer" style="margin-top: 300px; margin-bottom: 1vh">';
	}
	else {
		echo '<div class="mcontainer">';
	}
		
				 // <!-- main body -->

	/*

		<div class="castle">
			<svg id="Layer_1" class="castle" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22.97 26.6"><defs><style>.cls-1{fill:#231f20;}</style></defs><text x="-34.53" y="-45.3"/><path class="cls-1" d="M53.65,45.3l-3.86,8.15h1.33l-.06,3.71H49V56H46.87v1.21H44.92V56H42.8v1.21H41L41,53.45h1.22L38.39,45.3l-3.86,8.15h1.39V71.9h5.83V67.38h.42l.25,1.19.33-1.19h.87l.25,1.19.34-1.19H45l.25,1.19.33-1.19h.85l.25,1.19.33-1.19h.84l.25,1.19.33-1.19h.9l.24,1.19L50,67.38h.44V71.9h5.83V53.45H57.5Zm-10,18.51v.24h-.29A3.36,3.36,0,0,1,43.63,63.81Zm.59-.33a4.52,4.52,0,0,1,.83-.29v.86h-.83Zm1.41-.3h.85v.87h-.85Zm1.44,0a4.8,4.8,0,0,1,.83.29v.58h-.84Zm1.41.61a2.69,2.69,0,0,1,.33.26h-.33Zm-5.72.84h.87v.81h-.87Zm1.45,0h.84v.81h-.83Zm1.42,0h.85v.81h-.85Zm1.43,0h.83v.81h-.83Zm1.42,0h.89v.81h-.9Zm-6.67,2.19A4.34,4.34,0,0,1,42,66h.17v.81Zm.94,0V66h.87v.81Zm1.46,0V66H45v.81Zm1.41,0V66h.85v.81Zm1.44,0V66h.83v.81Zm1.41,0V66h.9v.81ZM50,66h.2a4.33,4.33,0,0,1,.18.81H50Z" transform="translate(-34.53 -45.3)"/></svg>
		</div>

	if (isset($_SESSION['login'])){
	//-------------- find active members
	  $cutoff = date("Y-m-d H:i:s", mktime(date("H"),date("i")-5,date("s"),date("m"),date("d"),date("Y")));
	  $sql = "SELECT * FROM users WHERE u_time > '".$cutoff."' ".(isset($_SESSION['login']) ? 'AND u_id != '.$_SESSION['u_id'] : '')."";
	  if($result = mysqli_query($link, $sql)){
	  }
	  //$result = mysqli_query($query) or die (mysqli_error(). ' bad query current users');
	  $count = mysqli_num_rows($result);
	  if ($count > 0){
		  	for ($i = 0; $i < $count; $i++){  
			  $row = mysqli_fetch_array($result);
				switch ($row['u_sec']){
					case "3":
					echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="blue">'.($row['u_id'] == 1 ? 'Webmaster ' : ($row['u_id'] == 64 ? 'Dev ' : 'Admin '));
					break;
					case "2":
					echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="green">Member ';
					break;
					default:
					echo '';
					break;
				}
				echo ucfirst($row['u_name']).'</a><b class="bop"> is online.</b><br>';
			} 
		}
		else { 
		  echo 'No other members online.<br>';	 
		}
	// activity section
	echo '<br>
				<b class="bop">';
				if (isset($_SESSION['login'])) {
				$sql = "SELECT * FROM forum WHERE f_date > '".$_SESSION['old_date']."' AND f_auth != '".$_SESSION['u_id']."' ".($_SESSION['dark'] == 1 ? "" : "AND f_cat != 421 ");
				if($result = mysqli_query($link, $sql)){}
				//$result = mysqli_query($wtf) or die (mysqli_error(). ' forum');
					$reply = 0;
					$post = 0;
					$numrows = mysqli_num_rows($result);
					for ($i = 0; $i < $numrows; $i++){
						$row = mysqli_fetch_array($result);
						if ($row['f_parent'] == 0){
							$post = $post+1;
						}
						else {
							$reply = $reply+1;
						}
					}
					echo $post.' Posts '.$reply.' Replies ';
				}
				echo ' since last login</b>';
    }
			  //$cutoff = date("Y-m-d H:i:s", mktime(date("H"),date("i")-5,date("s"),date("m"),date("d"),date("Y")));
			  //$query = "SELECT * FROM guest WHERE g_date > '".$cutoff."'";
			  //$result = mysqli_query($query) or die ("bad query guest");
			  //$count = mysqli_num_rows($result); 
			  //echo '<b class="green">'.$count .' guests/bots </b>';
			
				</td>
			  </tr>
			</table>
		  </TD>
		</TR>
  <tr>
    <td colspan="2">
	 
	</td>
  </tr>
		<TR>
		  <TD colspan="2" background="dev/img/buttons/date.jpg">
		 	<table align="left" cellpadding="0" cellspacing="0" border="0">
			  <tr>
			    <td>

				<ul class="sf-menu">
				<?php
                  echo'
				  <li class="current"><a href="'.$url.'" class="navb"><img src="img/buttons/home.gif" border="0" hspace="1" vspace="0"></a></li>
				  
				  <li class="current"><a href="'.$url.'?mainaction=forum" class="navb"><img src="img/buttons/forums.gif" border="0" hspace="1" vspace="0"></a></li>';
				  
				  if (isset($_SESSION['login'])) {
					echo '
				  <li class="current"> <a href="'.$url.'?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'" class="navb"><img src="img/buttons/members.gif" border="0" hspace="1" vspace="0"></a> 
                    <ul>
                      <li><a href="'.$url.'?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'" class="nav">Profile</a></li>
                      <li><a href="'.$url.'?mainaction=msg" class="nav">Messages</a></li>
                      <li><a href="'.$url.'?mainaction=members" class="nav">Member List</a></li>
                      <li><a href="'.$url.'?mainaction=games" class="nav">Games</a></li>
					  <li><a href="'.$url.'?mainaction=minecraft" class="nav">Minecraft Project</a></li>
					  <li><a href="'.$url.'?mainaction=goal" class="nav">Goals</a></li>
					  <li><a href="'.$url.'?mainaction=status" class="nav">Status</a></li>
                    </ul>
                  </li>';	
				  /*
				  <li class"current"><a href="http://www.4hammersforge.com/index.php?mainaction=streams"><img src="img/buttons/streams.gif" border="0" hspace="1" vspace="0"></a>
					<ul>
						<li><a href="http://www.4hammersforge.com/index.php?mainaction=streams&id=1" class="nav">CR-10</a></li>
						<li><a href="http://www.4hammersforge.com/index.php?mainaction=streams&id=2" class="nav">Anycubic I3 Mega</a></li>
						<li><a href="http://www.4hammersforge.com/index.php?mainaction=streams&id=3" class="nav">Roamer</a></li>
					</ul>
				  </li>
				  }
				
                  echo '
                  <li class="current"> <a href="'.$url.'?mainaction=calendar" class="navb"><img src="img/buttons/calendar.gif" border="0" hspace="1" vspace="0"></a> 
                   ';
					
					if (isset($_SESSION['login'])) {
					echo ' 
					<ul> 
					  <li><a href="'.$url.'?mainaction=event&subaction=insert" class="nav">Add Event</a></li>
					</ul>';
					}
					echo '</li>';
					if (!isset($_SESSION['login'])) {
                  echo '</ul>
				<img src="img/buttons/blank.gif" border="0">';
					}
				  
				  if ($_SESSION['sec'] == 3){
				  echo '<li><a href="dev/test_page.html" class="navb"><img src="img/buttons/admin.gif" border="0" hspace="1" vspace="0"></a> 
                    <ul>
                      <li><a href="'.$url.'?mainaction=addnews" class="nav">Add News</a></li>
                      <li><a href="'.$url.'?mainaction=poll" class="nav">Add Poll</a></li>
					  <li><a href="'.$url.'?mainaction=motd" class="nav">Add Motd</a></li>';
					  if ($_SESSION['u_id'] == 1) {
					  echo '
					  <li><a href="/admin/index.php?mainaction=bdays" class="nav">Birthday Org.</a></li>
					  ';
					  }
                  echo '  
					</ul>
                  </li>
				  <li>
				 
				  </li>
			   </ul>';
				  }
                  elseif (isset($_SESSION['login'])) {
				  echo '</ul><img src="img/buttons/gray.gif" border="0">';
				  }
				 // <b class="pap">'.date('D, dS, M y h:i A').'</b>
				*/			  
			  ?>

  
