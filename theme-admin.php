<?php
class ThemeOptionItem {

	var $version 	= '0.3';
	var $name 		= '';
	var $default 	= '';
	var $type 		= 'string';
	var $width 		= 50;
	var $height		= 5;
	var $groupName	= '';
	var $value		= NULL;
	var $OptionName = '';
	var $slug		= '';
	var $style 		= '';

	function ThemeOptionItem($sOptionName, $args = array()) {
		$args = wp_parse_args($args,array(
			'slug'		=> str_replace(' ','-',strtolower($sOptionName)),
			'type' 		=> 'string',
			'width' 	=> '50',
			'height' 	=> '5',
			'default'	=> '',
			'style'		=> ''
		));
		extract($args);
		$this->name 	= $sOptionName;
		$this->default 	= $default;
		$this->type		= $type;
		$this->width	= $width;
		$this->height   = $height;
		$this->slug		= $slug;
		$this->style    = $style;
	}

	function setGroupName($sName = '') {
		$this->groupName = $sName;
		$this->OptionName = $sName.$this->slug;
	}

	function value($val = NULL) {
		if (is_null($val)) {
			if (is_null($this->value)) {
				(($this->value = get_option($this->OptionName)) === false) && $this->value = $this->default;
			}
			return $this->value;
		} elseif (is_array($val)) {
			$new_val = implode(",",$val);
			update_option($this->OptionName,$new_val);
		} else {
			$this->value = stripcslashes($val);
			update_option($this->OptionName,$this->value);
		}
	}

	function getHTML($style = '') {
		empty($style) && ($style == $this->style);
		$sEl = '';
		switch ($this->type) {
			case 'string':
				$sEl = '<input type="text" name="'.$this->OptionName.'" size="'.$this->width.'"  value="'.$this->value().'" style="'.$style.'" />';
				break;
			case 'image' :
				$sEl = '<input class="upload_image" id="'.$this->OptionName.'_img_input" type="text" size="'.$this->width.'" name="'.$this->OptionName.'" value="'.$this->value().'" style="'.$style.'" />';
				$sImg = $this->value()?'<br /><img alt="Current Image" src="'.$this->value().'" />':'Add Image';
				$sImg = '<br /><img alt="Add image" src="'.$this->value().'" />';
				$sEl .= '<a href="#" class="upload_image_button" id="'.$this->OptionName.'_img"/>'.$sImg.'</a>';
				break;
			case 'text'	 :
				$sEl = '<textarea name="'.$this->OptionName.'" cols="'.$this->width.'" rows="'.$this->height.'" style="'.$style.'" >'.$this->value().'</textarea>';
				break;
			case 'check-cat':
				$selected_cat = explode(',',$this->value());				
				$sEl = hierarchical_category_tree( 0, '', $this->OptionName.'[]', $selected_cat, $style);				
				break;
		}
		return '<tr>
			<td><label for="'.$this->OptionName.'">'.$this->name.'</label></td>
			<td>'.$sEl.'</td>
		</tr>';
	}

	function updatePOST(){
		if (isset($_POST[$this->OptionName]))
			$this->value($_POST[$this->OptionName]);
	}

}

function hierarchical_category_tree( $cat, $class="", $name, $checked_arr, $style ) {
	static $res;
	$next = get_categories('hide_empty=0&orderby=name&order=ASC&parent=' . $cat);
	if( $next ) :    
		foreach( $next as $cat ) :
			$c_id = $cat->term_id;
			$c_name = $cat->name;
			$checked = '';
			if ( in_array($c_id, $checked_arr) ) $checked = 'checked="checked"';
			$res .= '<ul class="'.$class.'"><li><input type="checkbox" name="'.$name.'" value="'.$c_id.'" '.$checked.' style="'.$style.'" /> '. $c_name;
			hierarchical_category_tree( $c_id, 'children', $name, $checked_arr, $style );
		endforeach;    
	endif;
	$res .= '</li></ul>';
	$res .= "\n";
	return $res;
} 

class ThemeOptions {

	var $version 	= '0.1';
	var $OptionGroups = array();
	var $lastGroup = 0;

	function ThemeOptions(){
		add_action('admin_menu', array(&$this,'admin_setup'));
	}

	function add_option_group($sTitle, $sName = '') {
		empty($sName) && $sName = str_replace(' ','-',strtolower($sTitle));
		$this->OptionGroups[] = array('name' => $sName,
								'title' => $sTitle,
								'options' => array()
								);
		$this->lastGroup = count($this->OptionGroups) - 1;
		return $this->lastGroup;
	}

	function add_option($sOptionName, $args = array(), $nGroup = null) {
		is_null($nGroup) && ($nGroup = $this->lastGroup);
		$option = new ThemeOptionItem($sOptionName, $args);
		$option->setGroupName($this->OptionGroups[$nGroup]['name']);
		$this->OptionGroups[$nGroup]['options'][] = $option;

	}

	function get_option($sName = ' ', $sGroupName = null){

		if (!is_null($sGroupName)) {
			foreach ($this->OptionGroups as $aGroup) {
				if ((strtolower($sGroupName) == $aGroup['name']) || ($sGroupName == $aGroup['title']) ) {
					$curGroup = array();
					$curGroup[0] = $aGroup;
					break;
				}
			}
		} else {
			$curGroup = $this->OptionGroups;
		}
		foreach ($curGroup as $aGroup) {
			foreach ($aGroup['options'] as $option) {
				if (strtolower($sName) == strtolower($option->name)
					|| $sName == $option->slug) return $option->value();
			}
		}
		return null;
	}

	function admin_setup() {
		if (function_exists('add_options_page')) {
			add_theme_page('Theme Options', 'Theme Options', 'manage_options', 'theme_options', array(&$this,'admin_panel'));
		}
		add_action('admin_print_scripts', array(&$this,'admin_scripts'));
		add_action('admin_print_styles', array(&$this,'admin_styles'));
	}

	function admin_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('highvision-admin', get_bloginfo('template_url').'/js/admin.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('highvision-admin');
	}

	function admin_styles() {
		wp_enqueue_style('thickbox');
	}

	function admin_panel() {
		if ( 'theme_options' != $_REQUEST['page'] ) return;
		(isset($_REQUEST['section']) && ($sSection = $_REQUEST['section'])) || ($sSection = $this->OptionGroups[0]['name']);
		$curGroup = array();
		foreach ($this->OptionGroups as $aGroup) {
			if ($sSection == $aGroup['name']) {
				$curGroup = $aGroup;
			}
		}
		?>
		<style type="text/css">
			.wrap a.highvision-button {
				padding: 15px;
				margin: 0;

				background: url("/wp-admin/images/white-grad.png") repeat-x scroll left top #EEEEEE;
			    text-shadow: 0 1px 0 #FFFFFF;
			    -moz-border-radius: 10px 0px 0px 10px;
			    -webkit-border-radius: 10px 0px 0px 10px;
			    border-radius: 10px 0px 0px 10px;
			    border: 1px solid #BBBBBB;
   				border-right: 0px;
			    cursor: pointer;
			    color: #464646;
			    float: none;
			    position: relative;
			    display: block;
			    text-decoration: none;
			}
			.wrap a.highvision-button:hover {
				color: #D54E21;
			}
			.wrap a.highvision-button.current {
				color: #D54E21;
			}
			.wrap td input[type=text], .wrap td textarea {
				width: 95%;
			}
			ul, ul li {
				margin:0;
			}
			ul.children {
				margin-left:20px;
			}
		</style>
		<div class="wrap">
		<h2> Theme Options : <? echo $curGroup['title']; ?> </h2>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td valign="top">
					<table cellpadding="0" cellspacing="0">
				<?php
				foreach ($this->OptionGroups as $aGroup) {
					$class = ($sSection == $aGroup['name'])?'current':'';
					echo "<tr><td>";
					echo '<a href="'.add_query_arg('section',$aGroup['name']).'" class="highvision-button '.$class.'">'.$aGroup['title'].'</a><br />';
					echo "</td></tr>";
				}
				?>
					</table>
				</td>
				<td style="padding: 10px; border: 1px solid #bbbbbb;">
				<form method="post" action="<? echo $_SERVER['REQUEST_URI']; ?>">
					<table cellpadding="10" cellspacing="10" >
					<?php
					foreach ($curGroup['options'] as $option) {
						$option->updatePOST();
						echo $option->getHTML();
					}
					?>
					</table>
					<input type="submit" value="save" class="button-primary" />
				</form>
				</td>
			</tr>
		</table>
		</div>
		<?php
	}
}

Global $TO;
$TO = new ThemeOptions();

$TO->add_option_group('Homepage Top Block','hptop');
$TO->add_option('Title');
$TO->add_option('Subtitle');
$TO->add_option('Link');

$TO->add_option_group('Homepage Block 1','hblock1');
$TO->add_option('Image','type=image');
$TO->add_option('Title');
$TO->add_option('Text','height=5&type=text');
$TO->add_option('Link','slug=rm_link');

$TO->add_option_group('Homepage Block 2','hblock2');
$TO->add_option('Image','type=image');
$TO->add_option('Title');
$TO->add_option('Text','height=5&type=text');
$TO->add_option('Link','slug=rm_link');

$TO->add_option_group('Homepage Block 3','hblock3');
$TO->add_option('Image','type=image');
$TO->add_option('Title');
$TO->add_option('Text','height=5&type=text');
$TO->add_option('Link','slug=rm_link');

$TO->add_option_group('Homepage Block 4','hblock4');
$TO->add_option('Image','type=image');
$TO->add_option('Title');
$TO->add_option('Text','height=5&type=text');
$TO->add_option('Link','slug=rm_link');

$TO->add_option_group('Homepage Quote','hpquote');
$TO->add_option('Quote','type=text');
$TO->add_option('Author');
$TO->add_option('Sign','type=image');
$TO->add_option('Image','type=image');
$TO->add_option('Link');

$TO->add_option_group('Homepage Featured','hpfeatured');
$TO->add_option('Title','type=text');
$TO->add_option('Content','type=text');
$TO->add_option('"More" link','slug=rm_link');
$TO->add_option('Image','type=image');
$TO->add_option('Features post1 ID','slug=fp_1_id');
$TO->add_option('Features post2 ID','slug=fp_2_id');
$TO->add_option('Features post3 ID','slug=fp_3_id');

$TO->add_option_group('Footer');
$TO->add_option('Copyright text','slug=copy&type=text');

$TO->add_option_group('Categories');
$TO->add_option('Check Categories','slug=check-cat&type=check-cat');

?>