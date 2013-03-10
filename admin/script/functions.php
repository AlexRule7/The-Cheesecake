<?php

	function display_error ($error, $success) {
		if(!empty($error)) {
			echo '<div id="error_notification" class="ui-corner-all">'.$error.'</div>';
		} else if (!empty($success)) {
			echo '<div id="success_notification" class="ui-corner-all">'.$success.'</div>';
		}
	}

?>