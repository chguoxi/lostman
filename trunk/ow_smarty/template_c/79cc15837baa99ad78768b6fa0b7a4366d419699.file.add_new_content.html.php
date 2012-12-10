<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/add_new_content.html" */ ?>
<?php /*%%SmartyHeaderCode:14600270150140b5e752b40-63880543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '79cc15837baa99ad78768b6fa0b7a4366d419699' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/add_new_content.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14600270150140b5e752b40-63880543',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e77a8c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e77a8c')) {function content_50140b5e77a8c($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
<a class="ow_add_content <?php echo $_smarty_tpl->tpl_vars['item']->value['iconClass'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
</a>
<?php } ?><?php }} ?>