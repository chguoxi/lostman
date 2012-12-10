<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/decorators/tooltip.html" */ ?>
<?php /*%%SmartyHeaderCode:75970223250140b5e0f6e72-53749384%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'efddc4b196895a0bb85ed0ebf96223df15aa7f32' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/decorators/tooltip.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '75970223250140b5e0f6e72-53749384',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e115d2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e115d2')) {function content_50140b5e115d2($_smarty_tpl) {?>
<div class="ow_tooltip<?php if (!empty($_smarty_tpl->tpl_vars['data']->value['addClass'])){?> <?php echo $_smarty_tpl->tpl_vars['data']->value['addClass'];?>
<?php }?>">
    <div class="tail"><span></span></div>
    <div class="body"><?php echo $_smarty_tpl->tpl_vars['data']->value['content'];?>
</div>
</div><?php }} ?>