<?php

function post_status($status) {
	switch ($status) {
		case '3':
			return '<span class="label label-success">Published</span>';
			break;
		
		case '2':
			return '<span class="label label-danger">Revising</span>';
			break;

		case '1':
			return '<span class="label label-info">Waiting</span>';
			break;

		default:
			return '<span class="label label-warning">Pending</span>';
			break;
	}
}

?>