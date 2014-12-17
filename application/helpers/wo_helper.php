<?php 

if(!function_exists('btn_edit')) {
	
	function btn_edit($table, $id = NULL) {
		
		$html = anchor('#', '<i class="fa fa-edit"></i> Edit', 'class="btn btn-primary btn-sm" data-target="ajax_edit" data-src="'.$table.'" data-id="'.$id.'"');
		
		return $html;
	}
}

if(!function_exists('btn_delete')) {
	
	function btn_delete($table, $id = NULL) {
		
		$html = anchor('#', '<i class="fa fa-times"></i> Delete', 'class="btn btn-danger btn-sm" data-target="ajax_delete" data-src="'.$table.'" data-id="'.$id.'" data-confirm="Are you sure you wish to delete item? Once deleted, this item will be removed from the database!"');
		
		return $html;
	}
}

if(!function_exists('btn_view')) {
	
	function btn_view($text, $table, $id = NULL, $anchor = NULL) {
		if ($anchor == NULL) {
			$anchor = '#';
		}
		
		$html = anchor($anchor, '<i class="fa fa-edit"></i> '.$text, 'class="btn btn-default btn-xs" data-target="ajax_edit" data-src="'.$table.'" data-id="'.$id.'"');
		
		return $html;
	}
}

if(!function_exists('btn_status')) {
	
	function btn_status($status, $words = FALSE) {
		$text = "";
		$class = "warning";
		if ($words == TRUE) {
			
			switch($status) {
				
				case 0: 
					$text = "In Progress";
					break;
					
				case 1: 
					$text = "Complete";	
					$class = "success";
					break;
				
				case '2': 
					$text = "Pending";	
					$class = "info";
					break;
				
				case 3:
					$text = "Waiting Payment";	
					$class = "info";	
					break;
				
				case '4': 
					$text = "On Hold";	
					$class = "default";
					break;
			
			}
			
			
		}
		
		else {
			$extra = '';
			if ($words != FALSE) {
				$extra = $words;	
			}
			
			if ($status == 0) {
				$text = '<i class="fa fa-times">'.$extra.'</i>';	
			}
			else {

				$text = '<i class="fa fa-check">'.$extra.'</i>';	
				$class = "success";
					
			}
		}
		$html = '<span class="label label-'.$class.'">'.$text.'</span>';
		return $html;
	}
}

if(!function_exists('msg_status')) {
	
	function msg_status($id, $status, $outbox = FALSE) {
		$text = "";
		$class = "warning";
		
		switch($status) {
				
			case '0': 
				$text = "Pending";
				break;
					
			case '1': 
				$text = "Sent";	
				$class = "success";
				break;
				
			case '2': 
				$text = "Read";	
				$class = "danger";
				break;
			
			case '3':
				$text = "Replied";	
				$class = "info";	
				break;
			case '4':
				$text = "Unread";	
				$class = "success";	
				break;
						
		}    	        
		$target = 'data-target="ajax_edit"';
		if ($outbox == TRUE) {
			$class = 'success';	
			$btns = '';
			$target= 'data-target="outbox_msg"';
		}
		else {
			$btns = '<button type="button" class="btn btn-'.$class.' dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
			$btns .= '<span class="caret"></span>';
			$btns .= '<span class="sr-only">Toggle Dropdown</span>';
			$btns .= '</button>';
			$btns .= '<ul class="dropdown-menu" role="menu">';
			$btns .= '<li><a href="admin/dashboard/page/message/edit" id="reply" data-id="'.$id.'">Reply</a></li>';
			$btns .= '<li><a href="#">Mark as Unread</a></li>';
			$btns .= '<li class="divider"></li>';
			$btns .= '<li>'.anchor('#', 'Delete', 'class="" data-target="ajax_delete" data-src="message" data-id="'.$id.'" data-confirm="Are you sure you wish to delete item? Once deleted, this item will be removed from the database!"').'</li>';
			$btns .= '</ul>';	
		}
			
		$html = '<div class="btn-group">';
		$html .= anchor('#', 'View Message', 'class="btn btn-'.$class.'" data-src="message" ' . $target . ' data-id="'.$id.'"');
  		$html .= $btns;
		$html .= '</div>';
		return $html;
	}
}

if(!function_exists('div')) {
	
	function div($class = NULL) {
		if ($class) {
			$class = ' class="'.$class.'"';	
		}
		$html = '<div'.$class.'>';
		
		return $html . "\n";
	}
}

if(!function_exists('div_close')) {
	
	function div_close() {
		
		$html = "</div>\n";
		
		return $html;
	}
}

if(!function_exists('input_addon')) {
	
	function input_addon($text) {
		
		$html = "<span class=\"input-group-addon\">" . $text . "</span>";
		
		return $html;
	}
}

if(!function_exists('script')) {
	
	function script($uri, $local = FALSE) {
		$html = '<script src="'.base_url($uri).'">';
		
		$html .= '</script>';
		
		return $html;
	}
}

if(!function_exists('ajax_post')) {
	
	function ajax_post() {
		
		$html = '<script type="text/javascript">';
		$html .= '$(".ajax-form").submit(function(e) {';
		$html .= 'e.preventDefault();';
		$html .= '$.ajax({';
		$html .= 'url: $(this).attr("action"), data: $(this).serialize(), type: "POST",})';
		$html .= '.done(function(html) {';
		$html .= '$( "#page-wrapper" ).html(html);';
		$html .= '$(".alert-success").hide().slideDown("slow");';
		$html .= '}); });';
		$html .= '</script>';
		
		return $html;

	}
}

if (!function_exists('dump')) {

	function dump ($var, $label = 'Dump', $echo = TRUE)
	{
	
		// Store dump in variable 
		ob_start();
	
		var_dump($var);
		
		$output = ob_get_clean();

		// Add formatting
		$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
		
		$output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

		// Output
		if ($echo == TRUE) {
			
			echo $output;
		}
		
		else {

			return $output;
		}
	
	}

}

if (!function_exists('dump_exit')) {
	
	function dump_exit($var, $label = 'Dump', $echo = TRUE) {
		
		dump ($var, $label, $echo);
		
		exit;
	}
}

/* End of file wo_helper.php */
/* Location: ./application/helpers/wo_helper.php */