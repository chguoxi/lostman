<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/switch_language.html" */ ?>
<?php /*%%SmartyHeaderCode:121257798250140b5e3062c6-25071587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d3f35c75f8b8eb30348061425e7763f9e2b90c0' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/switch_language.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '121257798250140b5e3062c6-25071587',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url_with_params' => 0,
    'languages' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e33f0e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e33f0e')) {function content_50140b5e33f0e($_smarty_tpl) {?><div style="padding-top: 1px;">
    <select id="select_language" onchange='location.href="<?php echo $_smarty_tpl->tpl_vars['url_with_params']->value;?>
"+this.value;'>
        <?php  $_smarty_tpl->tpl_vars["language"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["language"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['languages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["language"]->key => $_smarty_tpl->tpl_vars["language"]->value){
$_smarty_tpl->tpl_vars["language"]->_loop = true;
?>
          <option value="<?php echo $_smarty_tpl->tpl_vars['language']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['language']->value['is_current']==1){?>selected="selected"<?php }?> ><?php echo $_smarty_tpl->tpl_vars['language']->value['label'];?>
</option>
        <?php } ?>
    </select>
</div><?php }} ?>