<?php 
	$dir = __DIR__;
	$parentdir = dirname($dir);
	require_once($parentdir . "/connection/dependencies.php");

	$current_student = getCurrentStudent();
?>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="homepage.css">	
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title>WonderKids</title>
  </head>
  <body>
    <h1>WonderKids</h1>

	<div class="container-landing">

		<div class="container-content">
			<h1>
				Explore, Play, and Learn: Interactive Modules for Kids
			</h1>
			<p>
				Embark on an Exciting Journey of Engaging Learning Modules: Ignite Curiosity and Inspire Lifelong Learning
			</p>
		</div>

		<div class="carousel-container">
			<div class="carousel-card" id="far-left">
				<img class="carousel-icon" src="assets/competition.svg" alt="">
				<h3 class="carousel-title"><a href="../competitions/index.php">Competition</a></h3>
				<p class="carousel-text">Compete, Thrive, and Rise to the Challenge: Unleash Your Potential in Exciting Competitions.</p>
			</div>
			<div class="carousel-card" id="left">
				<img class="carousel-icon" src="assets/vocab.svg" alt="">
				<h3 class="carousel-title"><a href="../vocabulary_module/index.php">Vocabulary</a></h3>
				<p class="carousel-text">Expand Your Vocabulary: Learn, Practice, and Grow.</p>
			</div>
			<div class="carousel-card" id="center">
				<img class="carousel-icon" src="assets/typing-icon.svg" alt="">
				<h3 class="carousel-title"><a href="../type_master/index.php">Typing</a></h3>
				<p class="carousel-text">Master the Art of Typing: Improve Speed and Accuracy.</p>
			</div>
			<div class="carousel-card" id="right">
				<img class="carousel-icon" src="assets/discussion-icon.svg" alt="">
				<h3 class="carousel-title"><a href="../discussion_forum/pages/newsfeed.php">Discussion</a></h3>
				<p class="carousel-text">Engage, Connect, and Share: Join the Discussion Forum Community.</p>
			</div>
			<!-- <div class="carousel-card" id="far-right">
				<img class="carousel-icon" src="https://placeimg.com/75/75/tech/grayscale" alt="">
				<h3 class="carousel-title">TEST 5</h3>
				<p class="carousel-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
			</div> -->
		</div>
	</div>

	<script src="homepage.js"></script>
  </body>
</html>