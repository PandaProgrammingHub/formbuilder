<?php  

function start_form($action = '', $attributes = '', $hidden = array()){
		
		if ($attributes == ''){
			$attributes = 'method="post"';
		}

		$form = '<form action="'.$action.'"';

		$form .= _attributes_to_string($attributes, TRUE);

		$form .= '>';

		

		if (is_array($hidden) AND count($hidden) > 0){
			$form .= sprintf("<div style=\"display:none\">%s</div>", input_hidden($hidden));
		}

		return $form;
}

function start_form_multipart($action = '', $attributes = array(), $hidden = array()){
		if (is_string($attributes)){
			$attributes .= ' enctype="multipart/form-data"';
		}
		else{
			$attributes['enctype'] = 'multipart/form-data';
		}

		return start_form($action, $attributes, $hidden);
	
}

function input_hidden($name, $value = '', $recursing = FALSE){
		static $form;

		if ($recursing === FALSE){
			$form = "\n";
		}

		if (is_array($name)){
			foreach ($name as $key => $val){
				input_hidden($key, $val, TRUE);
			}
			return $form;
		}

		if ( ! is_array($value)){
			$form .= '<input type="hidden" name="'.$name.'" value="'.prep_form($value, $name).'" />'."\n";
		}
		else{
			foreach ($value as $k => $v){
				$k = (is_int($k)) ? '' : $k;
				input_hidden($name.'['.$k.']', $v, TRUE);
			}
		}

		return $form;
	
}

function input_text($data = '', $value = '', $extra = ''){
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}


function input_password($data = '', $value = '', $extra = ''){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}

		$data['type'] = 'password';
		return input_text($data, $value, $extra);
}


function input_upload($data = '', $value = '', $extra = ''){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}

		$data['type'] = 'file';
		return input_text($data, $value, $extra);
	
}

function textarea($data = '', $value = '', $extra = ''){
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'cols' => '40', 'rows' => '10');

		if ( ! is_array($data) OR ! isset($data['value'])){
			$val = $value;
		}
		else{
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		}

		$name = (is_array($data)) ? $data['name'] : $data;
		return "<textarea "._parse_form_attributes($data, $defaults).$extra.">".prep_form($val, $name)."</textarea>";
	
}


function multiselect($name = '', $options = array(), $selected = array(), $extra = ''){
		if ( ! strpos($extra, 'multiple')){
			$extra .= ' multiple="multiple"';
		}

		return select($name, $options, $selected, $extra);
	
}

function select($name = '', $options = array(), $selected = array(), $extra = ''){
		if ( ! is_array($selected)){
			$selected = array($selected);
		}

		
		if (count($selected) === 0){
			
			if (isset($_POST[$name])){
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val){
			$key = (string) $key;

			if (is_array($val) && ! empty($val)){
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val){
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	
}

function checkbox($data = '', $value = '', $checked = FALSE, $extra = ''){
		$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		if (is_array($data) AND array_key_exists('checked', $data)){
			$checked = $data['checked'];

			if ($checked == FALSE){
				unset($data['checked']);
			}
			else{
				$data['checked'] = 'checked';
			}
		}

		if ($checked == TRUE){
			$defaults['checked'] = 'checked';
		}
		else{
			unset($defaults['checked']);
		}

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	
}


function radio($data = '', $value = '', $checked = FALSE, $extra = ''){
		if ( ! is_array($data)){
			$data = array('name' => $data);
		}

		$data['type'] = 'radio';
		return checkbox($data, $value, $checked, $extra);
	
}


function submit($data = '', $value = '', $extra = ''){
		$defaults = array('type' => 'submit', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	
}

function cancel($data = '', $value = '', $extra = ''){
		$defaults = array('type' => 'reset', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	
}


function button($data = '', $content = '', $extra = ''){
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'type' => 'button');

		if ( is_array($data) AND isset($data['content']))
		{
			$content = $data['content'];
			unset($data['content']); // content is not an attribute
		}

		return "<button "._parse_form_attributes($data, $defaults).$extra.">".$content."</button>";
	
}

function label($label_text = '', $id = '', $attributes = array()){

		$label = '<label';

		if ($id != ''){
			$label .= " for=\"$id\"";
		}

		if (is_array($attributes) AND count($attributes) > 0){
			foreach ($attributes as $key => $val){
				$label .= ' '.$key.'="'.$val.'"';
			}
		}

		$label .= ">$label_text</label>";

		return $label;
	
}


function fieldset($legend_text = '', $attributes = array()){
		$fieldset = "<fieldset";

		$fieldset .= _attributes_to_string($attributes, FALSE);

		$fieldset .= ">\n";

		if ($legend_text != ''){
			$fieldset .= "<legend>$legend_text</legend>\n";
		}

		return $fieldset;
	
}


function end_fieldset($extra = ''){
		return "</fieldset>".$extra;
	
}


function end_form($extra = ''){
		return "</form>".$extra;
	
}

function prep_form($str = '', $field_name = ''){
		static $prepped_fields = array();

		if (is_array($str))	{
			foreach ($str as $key => $val){
				$str[$key] = prep_form($val);
			}

			return $str;
		}

		if ($str === ''){
			return '';
		}

		if (isset($prepped_fields[$field_name])){
			return $str;
		}

		$str = htmlspecialchars($str);

		// In case htmlspecialchars misses these.
		$str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

		if ($field_name != ''){
			$prepped_fields[$field_name] = $field_name;
		}

		return $str;
	
}

function _parse_form_attributes($attributes, $default){
		if (is_array($attributes)){
			foreach ($default as $key => $val){
				if (isset($attributes[$key])){
					$default[$key] = $attributes[$key];
					unset($attributes[$key]);
				}
			}

			if (count($attributes) > 0){
				$default = array_merge($default, $attributes);
			}
		}

		$att = '';

		foreach ($default as $key => $val){
			if ($key == 'value'){
				$val = prep_form($val, $default['name']);
			}

			$att .= $key . '="' . $val . '" ';
		}

		return $att;
	
}

function _attributes_to_string($attributes, $formtag = FALSE){
		if (is_string($attributes) AND strlen($attributes) > 0){
			if ($formtag == TRUE AND strpos($attributes, 'method=') === FALSE){
				$attributes .= ' method="post"';
			}

			if ($formtag == TRUE AND strpos($attributes, 'accept-charset=') === FALSE){
				//$attributes .= ' accept-charset="'.strtolower(config_item('charset')).'"';
			}

		return ' '.$attributes;
		}

		if (is_object($attributes) AND count($attributes) > 0){
			$attributes = (array)$attributes;
		}

		if (is_array($attributes) AND count($attributes) > 0){
			$atts = '';

			if ( ! isset($attributes['method']) AND $formtag === TRUE){
				$atts .= ' method="post"';
			}

			if ( ! isset($attributes['accept-charset']) AND $formtag === TRUE){
				//$atts .= ' accept-charset="'.strtolower(config_item('charset')).'"';
			}

			foreach ($attributes as $key => $val){
				$atts .= ' '.$key.'="'.$val.'"';
			}

			return $atts;
		}
	
}


