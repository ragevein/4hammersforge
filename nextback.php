<?php

if ($tpages != 1){

		$bu = 0;
		$last = ($tpages*$ipp) - $ipp;
		$big = (($offset/$ipp) + 3);
		$lil = (($offset/$ipp) - 2);
		echo '<table width="100%"><tr><td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="200" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td></tr>
		<tr><td align="center">';

		echo ($offset == 0 ? '' : '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset=0" class="nav3">First</a>').'</td>
		<td align="center"> '.($offset == 0 ? '' : '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset='.($offset == 0 ? '0' : $offset - $ipp ).'" class="nav3"> << </a>').'</td>
		<td align="center">';
		echo ($offset >= ($ipp*3) ? '<span class="blue"> ... </span>' : ' ');
		for ($i = 1; $i <= $tpages; $i++){
			if ($big >= $i || (($offset == 0) && $i <= 4) ){
				if ($lil >= $i){
				  	if (($tpages == (($offset/5) +1)) && $i == ($i - 3)){
						$page = 5*$bu;
						echo '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset='.$page.'" class="nav3"> '.$i.' </a>'; 
						$bu = $bu + 1;
					}
					else {
					$page = $ipp*$bu;
					$bu = $bu + 1;
					}
				}
				else {
				$page = $ipp*$bu;
						if ($page == $offset){
							echo '<span class="gray">'.$i.'</span>';
						}
						else {
							echo '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset='.$page.'" class="nav3"> '.$i.' </a>';
						}
				$bu = $bu + 1;
				}
			}
			else {
			$page = $ipp*$bu;
			$bu = $bu + 1;
			}
		}
		echo ($tgapes > 4 ?  ($offset < (($tpages*$ipp) - ($ipp*3)) ? '<span class="blue"> ... </span>' : ' ') : '');
		echo '</td><td align="center">';
		$next = $offset + $ipp;
		echo ($last == $offset ? '' : '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset='.$next.'"  class="nav3"> >> </a>').'</td>
		<td align="center">'. ($last == $offset ? '' : '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&offset='.$last.'"  class="nav3">Last</a>' );
		echo '</td></tr></table>';
}
	?>