<?php
	$pagenum = 1;

	if(isset($_GET['pn'])){
		$pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
	}

	if(isset($_GET['d'])){
		$date = $_GET['d'];
	} else {
		$date = date("m/d/Y");
	}

	$url="https://pubconsole.media.net/api/reports/v1/hourly-channel-wise?customer_guid=AE0AA2EE-2A7C-4A29-BE17-8442B3BFF8F4&customer_key=8CUM299YX&from_date=".$date."&to_date=".$date."&page_number=".$pagenum;
	//$url = "http://local.test.com/1.xml";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents

	$data = curl_exec($ch); // execute curl request
	curl_close($ch);

	$xml = simplexml_load_string($data);
	$json = json_encode($xml);
	$list = json_decode($json, true);

	$infos = [];

	foreach ($list['statsData']['reportItem'] as $item) {
		$revenue = floatval(substr($item['@attributes']['estimatedRevenue'], 1));

		if ($revenue > 0) {
			if (isset($infos[$item['@attributes']['channelName2']]))
				$infos[$item['@attributes']['channelName2']] = [
					'impressions' => $infos[$item['@attributes']['channelName2']]['impressions'] + $item['@attributes']['impressions'],
					'totalClicks' => $infos[$item['@attributes']['channelName2']]['totalClicks'] + $item['@attributes']['totalClicks'],
					'estimatedRevenue' => $infos[$item['@attributes']['channelName2']]['estimatedRevenue'] + $revenue,
					'date' => $infos[$item['@attributes']['channelName2']]['date'].'\n'.$item['@attributes']['date']
				];
			else
				$infos[$item['@attributes']['channelName2']] = [
					'impressions' => $item['@attributes']['impressions'],
					'totalClicks' => $item['@attributes']['totalClicks'],
					'estimatedRevenue' => $revenue,
					'date' => $item['@attributes']['date']
				];
		}
	}
	
	$page_rows = 500;

	$last = $list['@attributes']['totalPages'];

	if($last < 1) {
		$last = 1;
	}

	if ($pagenum < 1) { 
		$pagenum = 1; 
	} 
	else if ($pagenum > $last) { 
		$pagenum = $last; 
	}

	$paginationCtrls = '';

	if($last != 1){
		
	if ($pagenum > 1) {
        $previous = $pagenum - 1;
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'&d='.$date.'" class="btn btn-default">Previous</a> &nbsp; &nbsp; ';
		
		for($i = $pagenum-4; $i < $pagenum; $i++){
			if($i > 0){
		        $paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&d='.$date.'" class="btn btn-default">'.$i.'</a> &nbsp; ';
			}
	    }
    }
	
	$paginationCtrls .= ''.$pagenum.' &nbsp; ';
	
	for($i = $pagenum+1; $i <= $last; $i++){
		$paginationCtrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'&d='.$date.'" class="btn btn-default">'.$i.'</a> &nbsp; ';
		if($i >= $pagenum+4){
			break;
		}
	}

    if ($pagenum != $last) {
        $next = $pagenum + 1;
        $paginationCtrls .= ' &nbsp; &nbsp; <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'&d='.$date.'" class="btn btn-default">Next</a> ';
    }
	}

?>