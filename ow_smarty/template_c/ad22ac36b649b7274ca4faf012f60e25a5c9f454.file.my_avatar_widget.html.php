<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/my_avatar_widget.html" */ ?>
<?php /*%%SmartyHeaderCode:24992287350140b5e537545-53329500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad22ac36b649b7274ca4faf012f60e25a5c9f454' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/my_avatar_widget.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24992287350140b5e537545-53329500',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'displayName' => 0,
    'avatar' => 0,
    'toolbarItems' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e59037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e59037')) {function content_50140b5e59037($_smarty_tpl) {?><?php if (!is_callable('smarty_block_style')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/block.style.php';
if (!is_callable('smarty_function_decorator')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/function.decorator.php';
?><?php $_smarty_tpl->smarty->_tag_stack[] = array('style', array()); $_block_repeat=true; echo smarty_block_style(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


.ow_my_avatar_console a {
    background-position:50% 50%;
	background-repeat:no-repeat;
	display:inline-block;
	height:30px;
	width:25px;    
	text-decoration: none;
}

<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_style(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<div class="ow_my_avatar_widget">
    <div class="ow_my_avatar_username ow_center"><?php echo $_smarty_tpl->tpl_vars['displayName']->value;?>
</div>

	<div class="ow_center"><?php echo smarty_function_decorator(array('name'=>'avatar_item','data'=>$_smarty_tpl->tpl_vars['avatar']->value),$_smarty_tpl);?>
</div>
    <?php if (!empty($_smarty_tpl->tpl_vars['toolbarItems']->value)){?>
		<div class="ow_my_avatar_console ow_center">
		   <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['toolbarItems']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
		      <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['item']->value['iconClass'];?>
">&nbsp;</a>
		   <?php } ?>
		</div>
    <?php }?>
	
</div><?php }} ?>