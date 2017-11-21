<?php
function r($float, $fracCnt=2, $precision=6){
	$float = (string)$float;
	list($n, $frac) = explode('.', $float);
	$n = (int)$n;
	$fracPre = substr($frac, 0, $precision);
	$fracPre = (int)str_pad($fracPre, $precision, '0');
	$fracLim = substr($frac, 0, $fracCnt);
	$fracLim = (int)str_pad($fracLim, $precision, '0');
	$fracPreLen = strlen($fracPre);
	$prefixCnt = 0;
	if ($fracPreLen < $precision){		
		if (!empty($fracPre)){
			$prefixCnt = $precision - strlen($fracPre);
			if ($prefixCnt > $fracCnt){
				$prefixCnt = $fracCnt;
			}
		}
	}
	$half = pow(10, ($precision - $fracCnt - 1)) * 5;	
	$fracLimHalf = $fracLim + $half;
	if ($fracPre >= $fracLimHalf){
		$fracRound = $fracLimHalf + $half;
		if (strlen($fracRound) > $fracPreLen){
			if (strlen($fracRound) > $precision){
				$n += ($n > 0) ? 1 : -1;
				$fracRound = 0;
				$prefixCnt = 0;
			} else {
				$prefixCnt--;
				if ($prefixCnt < 0 ){
					$prefixCnt = 0;
				}
			}
		}
	}
	else{
		$fracRound = $fracLim;
	}
	$fracRoundLen = $fracCnt - $prefixCnt;
	$fracRound = substr($fracRound, 0, $fracRoundLen);
	$fracRound = str_pad($fracRound, $fracRoundLen, '0');
	if (0){
		echo '<div style="border:solid blue 1px;">';
		foreach(array(
			'float','n','fracCnt','precision','frac','fracPre',
			'fracLim', 'half', 'fracLimHalf',
			'fracRound','prefixCnt','fracRoundLen'
		)	as $var){
			echo "<br>$var : " . ($$var);
		}
		echo '</div>';
	}
	return ($n . '.' . str_repeat('0',$prefixCnt) . $fracRound);
}

//test case
$pow = 3;
$max = pow(10,$pow);
$fracCnt = 2;
$integer = 100;
for($i=0; $i<$max; $i++){
	$ipad = str_pad($i, $pow, '0', STR_PAD_LEFT);
	echo "<br>r($integer.$ipad,$fracCnt) ::::: ";
	echo r("$integer.$ipad",$fracCnt);
}
$integer = -100;
for($i=0; $i<$max; $i++){
	$ipad = str_pad($i, $pow, '0', STR_PAD_LEFT);
	echo "<br>r($integer.$ipad,$fracCnt) ::::: ";
	echo r("$integer.$ipad",$fracCnt);
}