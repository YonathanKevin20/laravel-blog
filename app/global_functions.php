<?php

function role($role_id) {
	$role = ['leader', 'editor', 'chief'];
	foreach ($role as $value) {
		if(Auth::check()) {
			if($role_id == $value) {
				return true;
			}
		}
		else {
			return false;
		}

	}
}

?>