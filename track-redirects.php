<head>
	<title>Denver Post Redirect Follower Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css" />
	<link rel="shortcut icon" href="//plus.denverpost.com/favicon.ico" type="image/x-icon" />
	<meta name="robots" content="noindex" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
		function toldya() {
			window.alert('I told you, didn\'t I?');
		}
	</script>
</head>
<body>
	<section id="header">

		<!-- NAVIGATION BAR -->
		<div id="top-bar-margin" class="sticky fixed">
			<nav class="top-bar" data-topbar="" role="navigation">
				<ul class="title-area">
					<li class="name">
						<a href="https://denverpost.com"><img src="https://extras.denverpost.com/candidate-qa/denver-2015/images/dp-logo-white.png" alt="The Denver Post logo" class="nav-logo" style="    height: 35px;padding: 10px 25px 0px 10px;"></a>
					</li>
				</ul>
				<section class="top-bar-section">
				<ul class="right">
					<li class="divider"></li>
					<li class="top-top"><a href="javascript:toldya();" id="snowBtn">This Link Does Not Do Anything</a></li>
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

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

$csv = array_map("str_getcsv", file("track-subscribe-article.csv",FILE_SKIP_EMPTY_LINES));
$keys = array_shift($csv);
foreach ($csv as $i=>$row) {
    $csv[$i] = array_combine($keys, $row);
}
$csv = array_reverse($csv,true);

?>
<tr style="background:#e5e5e5;"><th width="20%">Date Recorded</th><th>Msg</th><th width="60%">Referrer</th><th>IP</th></tr>
<?php

function total_messages($count) {
	ksort($count);
	$returns = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Counts: ';
	foreach ($count as $key => $value) {
		$returns .= '&nbsp;&nbsp;&nbsp;<strong>Msg ' . $key . ':</strong> ' . $value . '';
	}
	return $returns;
}

$dateline = false;
$datecount = 0;
$msg_counts = array();
$i=0;
$len=count($csv);
foreach ($csv as $line) {
	$i++;
	$datetotal = '<tr style="background:#e5efff;"><td colspan="4"><strong>' . $dateline . '</strong> total redirects: <strong>' . $datecount . '</strong>' . total_messages($msg_counts) . '</td></tr>';
	$datecount++;
	$msg_counts[$line['msg']] = ( isset($msg_counts[$line['msg']]) ) ? $msg_counts[$line['msg']] + 1 : 1;
	$line_date = date("m-d-Y",strtotime($line['date']));
	if ($dateline !== false && $dateline != $line_date) {
		echo $datetotal;
		$datecount = 1;
		$msg_counts = array();
	}
	if ($dateline != $line_date) {
		$dateline = $line_date;
		}
	?>
	<tr>
		<td><?php echo $line['date']; ?></td>
		<td style="text-align:center"><?php echo $line['msg']; ?></td>
		<td><?php if (strrpos($line['ref'], 'data unavailable') == FALSE): ?><a href="<?php echo $line['ref']; ?>"><?php endif; ?><?php echo $line['ref']; ?><?php if (strrpos($line['ref'], 'data unavailable') == FALSE): ?></a><?php endif; ?></td>
		<td style="text-align:right"><?php echo $line['ip']; ?></td>
	</tr>
	<?php
	if ($i==$len) {
		echo '<tr style="background:#e5efff;"><td colspan="4"><strong>' . $dateline . '</strong> total redirects: <strong>' . $datecount . '</strong>' . total_messages($msg_counts) . '</td></tr>';
	}
	} ?>
</table>
</body>
</html>