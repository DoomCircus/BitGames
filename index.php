<!--
Project : BitGames - BitMinter Data
File : index.php
Last Modified: May 15, 2013
Author: Francis Kurevija
Description: Grabs JSON data from BitMinter and formats the relevant data into a table
-->
<?php
	$cachefile = "./cache.txt";

	$cachetime = 60; // 1 minute

	// Serve from the cache if it is younger than $cachetime

	if (file_exists($cachefile) && (time() - $cachetime < filemtime($cachefile))) 
	{
		$bmData = json_decode(file_get_contents($cachefile));
	}
	else
	{
		$url = "https://bitminter.com/api/users/BitGames?key=RGEZJBZS4DLQW1ULXT4IICWE1Y3IKNL0";
        $crl = curl_init();
        $timeout = 5;
        curl_setopt ($crl, CURLOPT_URL,$url);
        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);
		
		$bmData = json_decode($ret);
		
		file_put_contents($cachefile, json_encode($bmData));
	}
?>

<!DOCTYPE HTML>

<html>
	<head>
		<title>Data</title>
	</head>
	<body>
		<table border=1>
			<tr>
				<th>
					Name
				</th>
				<th>
					Number of Active Workers
				</th>
				<th>
					Hash Rate (All Workers)
				</th>
				<th>
					Server Time
				</th>
				<th>
					Round Start Time
				</th>
				<th>
					Shift Start Time
				</th>
				<th>
					Work Accepted
				</th>
				<th>
					Work Rejected
				</th>
				<th>
					User Score
				</th>
				<th>
					Pool Total Score
				</th>
			</tr>
			<tr>
			<?php
				echo "	<td>".$bmData->name."</td>";
				echo "	<td>".$bmData->active_workers."</td>";
				echo "	<td>".$bmData->hash_rate."</td>";
				echo "	<td>".date('r', $bmData->now)."</td>";
				echo "	<td>".date('r', $bmData->round_start->NMC)."</td>";
				echo "	<td>".date('r', $bmData->shift->start)."</td>";
				echo "	<td>".$bmData->shift->accepted."</td>";
				echo "	<td>".$bmData->shift->rejected."</td>";
				echo "	<td>".$bmData->shift->user_score."</td>";
				echo "	<td>".$bmData->shift->total_score."</td>";
			?>
			</tr>
		</table>
		</br>
		<table border=1>
			<tr>
				<th>
					Worker Name
				</th>
				<th>
					Worker Hash Rate
				</th>
				<th>
					Last Work Time
				</th>
				<th>
					Worker Alive
				</th>
				<th>
					Work Accepted (Total)
				</th>
				<th>
					Work Accepted (Round)
				</th>
				<th>
					Work Accepted (Prior to Last Checkpoint)
				</th>
			</tr>
			<?php
				foreach ( $bmData->workers as $worker )
				{
					$converted = ($worker->alive) ? 'true' : 'false';
					
					echo "<tr>";
					echo "	<td>".$worker->name."</td>";
					echo "	<td>".$worker->hash_rate."</td>";
					echo "	<td>".date('r', $worker->last_work)."</td>";
					echo "	<td>".$converted."</td>";
					echo "	<td>".$worker->work->BTC->total_accepted."</td>";
					echo "	<td>".$worker->work->BTC->round_accepted."</td>";
					echo "	<td>".$worker->work->BTC->checkpoint_accepted."</td>";
					echo "</tr>";
				}
			?>
		</table>
	</body>
</html>