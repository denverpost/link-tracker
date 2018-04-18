<head>
	<title>Denver Post Redirect Follower Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css" />
	<link rel="icon" href="http://extras.mnginteractive.com/live/media/favIcon/dpo/favicon.ico" type="image/x-icon" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>
<body>
	<section id="header">

		<!-- NAVIGATION BAR -->
		<div id="top-bar-margin" class="sticky fixed">
			<nav class="top-bar" data-topbar="" role="navigation">
				<ul class="title-area">
					<li class="name">
						<a href="http://denverpost.com"><img src="http://extras.denverpost.com/candidate-qa/denver-2015/images/dp-logo-white.png" alt="The Denver Post logo" class="nav-logo" style="    height: 35px;padding: 10px 25px 0px 10px;"></a>
					</li>
				</ul>
				<section class="top-bar-section">
				<ul class="right">
					<li class="divider"></li>
					<li class="top-top"><a href="javascript:void(0);" id="snowBtn">This Link Does Not Do Anything</a></li>
					<li class="divider"></li>
				</ul>
			</section>
			</nav>
		</div> <!-- Closes top-bar-margin -->
		<div class="row" style="padding-top:45px;">
	        <div class="large-12 large-centered medium-12 medium-centered columns">
		        <h1>Denver Post Redirect Follower Results</h1>
	        </div>
		</div>
	</section>
	<div id="wrapper">

		<div class="headerstyle">
			<div class="row">
				<div class="large-12 columns">
					<table style="width:100%;">
<?php

$csv = array_map("str_getcsv", file("track-subscribe-article.csv",FILE_SKIP_EMPTY_LINES));
$keys = array_shift($csv);
foreach ($csv as $i=>$row) {
    $csv[$i] = array_combine($keys, $row);
}
array_reverse($csv);

?>
<tr><th>Date &amp; Time</th><th>Message</th><th>Referrer</th></tr>
<?php
$dateline = false;
$datecount = 0;
foreach ($csv as $line) {
	if ($dateline != $line['date']) {
		$newdate = true;
		$dateline = $line['ref'];
		$datecount = 0;
		}
	$datetotal = '<tr><td>' . $dateline . ' total: ' . $datecount . '</td></tr>';
	$datecount++;
	?>
	<tr>
		<td><?php echo $line['date']; ?></td>
		<td><?php echo $line['msg']; ?></td>
		<td><?php echo $line['ref']; ?></td>
	</tr>
	<?php
		if ($newdate) { echo $datetotal; $newdate = false; }
	} ?>
</table>
</body>
</html>