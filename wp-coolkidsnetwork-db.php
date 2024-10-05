<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Learn WordPress</title>
</head>
<body style="margin: 2em;">
	<h1>CoolKidsNetwork</h1>
	<div>

	<?php
	// Load the WordPress library.
	require_once __DIR__ . '/wp-load.php';
		
	$data = coolkidsnetwork_custom_install();

	// print_r($data);

	?>

	</div>
</body>