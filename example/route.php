<?php
 /**
    *  Key = The DESIRED string
    *  Value = The ORIGINAL value
    *
    * Desired Result: project/EXAMPLE/something/OTHER
    */
    $data = array(
        'project/$1/details/$2' => 'newby/EXAMPLE/details/OTHER'
    );
	
    $string = 'project/$1/details/$2';

	preg_match_all('/\$\d/', $string, $pattern);

	if (!empty($pattern[0])) {
		$pattern = $pattern[0];
		$count = count($pattern);
		for($i = 0; $i < $count; $i++) {
//			$pattern[0] = '/\$1/';
//		    $pattern[1] = '/\$2/';
			$pattern[$i] = '/\\' . $pattern[$i] . '/';
		}
		print_r($pattern);
	}
	
	$replacement = explode('/', $data);
	foreach($replacement as $key => $value) {
		
	}
	
    $replacement[0] = 'EXAMPLE';
    $replacement[1] = 'OTHER';
	
	echo '<pre>';
	echo '<br />';
	print_r($pattern);
	echo '<br />';
	print_r($replacement);
	echo '<br />';
	
    $result = preg_replace($pattern, $replacement, $string);

    echo $result;