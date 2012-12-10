<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/decorators/box_cap.html" */ ?>
<?php /*%%SmartyHeaderCode:63401706750140b5e6043e9-56561430%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fb6c3cc2528b63c4a222dc5424144d4c35eea49' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/decorators/box_cap.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63401706750140b5e6043e9-56561430',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e6d3be',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e6d3be')) {function content_50140b5e6d3be($_smarty_tpl) {?><?php if (!is_callable('smarty_function_text')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.text.php';
?>
<div class="ow_box_cap<?php if (!empty($_smarty_tpl->tpl_vars['data']->value['type'])){?>_<?php echo $_smarty_tpl->tpl_vars['data']->value['type'];?>
<?php }?><?php if (!empty($_smarty_tpl->tpl_vars['data']->value['addClass'])){?> <?php echo $_smarty_tpl->tpl_vars['data']->value['addClass'];?>
<?php }?>">
	<div class="ow_box_cap_right">
		<div class="ow_box_cap_body">
			<h3 class="<?php if (!empty($_smarty_tpl->tpl_vars['data']->value['iconClass'])){?><?php echo $_smarty_tpl->tpl_vars['data']->value['iconClass'];?>
<?php }else{ ?>ow_ic_file<?php }?>">
			<?php if (!empty($_smarty_tpl->tpl_vars['data']->value['href'])){?><a href="<?php echo $_smarty_tpl->tpl_vars['data']->value['href'];?>
" <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['extraString'])){?><?php echo $_smarty_tpl->tpl_vars['data']->value['extraString'];?>
<?php }?>><?php }?>
			<?php if (!empty($_smarty_tpl->tpl_vars['data']->value['langLabel'])){?>
			   <?php echo smarty_function_text(array('key'=>$_smarty_tpl->tpl_vars['data']->value['langLabel']),$_smarty_tpl);?>

			<?php }else{ ?>
			   <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['label'])){?><?php echo $_smarty_tpl->tpl_vars['data']->value['label'];?>
<?php }else{ ?>&nbsp;<?php }?>
		    <?php }?>
		    <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['href'])){?></a><?php }?>
			</h3>
		   <?php if (!empty($_smarty_tpl->tpl_vars['data']->value['content'])){?><?php echo $_smarty_tpl->tpl_vars['data']->value['content'];?>
<?php }?>
		</div>
	</div>
</div><?php }} ?>