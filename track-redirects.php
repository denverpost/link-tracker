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
	<style type="text/css">
		#myModal ol li {
			margin-bottom:.75em;
		}
	</style>
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

<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

function total_messages($count) {
	ksort($count);
	$returns = 'Counts: ';
	foreach ($count as $key => $value) {
		$returns .= '&nbsp;&nbsp;&nbsp;Msg ' . $key . ': <strong>' . $value . '</strong>';
	}
	return $returns;
}

$csv = array_map("str_getcsv", file("track-subscribe-article.csv",FILE_SKIP_EMPTY_LINES));
$keys = array_shift($csv);
foreach ($csv as $i=>$row) {
    $csv[$i] = array_combine($keys, $row);
}
$csv = array_reverse($csv,true);

$msg_counts = array();
foreach ($csv as $line) {
	$msg_counts[$line['msg']] = ( isset($msg_counts[$line['msg']]) ) ? $msg_counts[$line['msg']] + 1 : 1;
}
$messages_all_time = total_messages($msg_counts);

?>

<div class="row" style="padding-top:45px;">
	        <div class="large-12 large-centered medium-12 medium-centered columns">
		        <h1>Denver Post Redirect Follower Results</h1>
		        <p>Here you can easily see which support messages appear to be drawing the most people to click over to the subscription site (we have no way to tell whether they actually subscribed based on these, however). <a href="#" data-reveal-id="myModal">Click here for a numbered list of the messages</a>.</p>
		        <p>A look at the all-time popularity of the messages:</p>
		        <p>Total <?php echo $messages_all_time; ?></p>
	        </div>
		</div>
	</section>
	<div id="wrapper">

		<div class="headerstyle">
			<div class="row">
				<div class="large-12 columns">
					<table style="width:100%;">
						<tr style="background:#e5e5e5;"><th width="20%">Date Recorded</th><th>Msg</th><th width="60%">Referrer</th><th>IP</th></tr>
<?php


$dateline = false;
$datecount = 0;
$msg_counts = array();
$i=0;
$len=count($csv);
foreach ($csv as $line) {
	$i++;
	$datetotal = '<tr style="background:#e5efff;"><td colspan="4"><strong>' . $dateline . '</strong> total redirects: <strong>' . $datecount . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . total_messages($msg_counts) . '</td></tr>';
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
		echo '<tr style="background:#e5efff;"><td colspan="4"><strong>' . $dateline . '</strong> total redirects: <strong>' . $datecount . '</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . total_messages($msg_counts) . '</td></tr>';
	}
	} ?>
</table>

<div id="myModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<h2 id="modalTitle">Support messages</h2>
	<ol>
		<li>&ldquo;The Denver Post needs your support.<br />Subscribe now for just 99 cents for the first month.&rdquo;</li>
		<li>&ldquo;Democracy depends on journalism, and journalists need your help. Support The Denver Post and get unlimited digital access -- the first month is just 99 cents.&rdquo;</li>
		<li>&ldquo;"I never quarrel with a man who buys ink by the barrel," former Indiana Rep. Charles Brownson said of the press. But we need your help to keep up with the rising cost of ink. Get your first month for just 99 cents when you subscribe to The Post.&rdquo;</li>
		<li>&ldquo;Like this story? Help support more local  journalism. Become a subscriber for only 99 cents.&rdquo;</li>
		<li>&ldquo;Reader support helps bring you quality local journalism like this. Please consider becoming a subscriber. Your first month is only 99 cents.&rdquo;</li>
		<li>&ldquo;Journalism doesn’t grow on trees. Please support The Denver Post. Become a subscriber for only 99 cents.&rdquo;</li>
		<li>&ldquo;Journalism isn’t free. Show your support of local news coverage by becoming a subscriber. Your first month is only 99 cents.&rdquo;</li>
	</ol>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<script src="//extras.denverpost.com/foundation/js/foundation.min.js"></script>
<script>
	$(document).foundation();
</script>
</body>
</html>