<?php 
	function znizkaCena($znizka, $cenaLotu) {
		switch ($znizka) {
			case 1:
				$out = 0;
				break;
			case 2:
				$out = $cenaLotu*0.3;
				break;
			case 3:
				$out = $cenaLotu*0.5;
				break;
			case 4:
				$out = $cenaLotu;
				break;
		}
		return $out;
	}
	
	function guidv4($data = null) {
		$data = $data ?? random_bytes(16);
		assert(strlen($data) == 16);

		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
?>