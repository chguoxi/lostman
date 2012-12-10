<?php /* Smarty version Smarty-3.1.7, created on 2012-07-28 08:55:10
         compiled from "/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/drag_and_drop_item.html" */ ?>
<?php /*%%SmartyHeaderCode:131436910650140b5e598944-80919693%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad06b03baf7df7d5ef0f7e4830df7833f92a7fdd' => 
    array (
      0 => '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_system_plugins/base/views/components/drag_and_drop_item.html',
      1 => 1343225879,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '131436910650140b5e598944-80919693',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'box' => 0,
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_50140b5e5fe94',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50140b5e5fe94')) {function content_50140b5e5fe94($_smarty_tpl) {?><?php if (!is_callable('smarty_block_block_decorator')) include '/home/chguoxi2c7h8g0uxogxmi/wwwroot/ow_smarty/plugin/block.block_decorator.php';
?><div class="ow_dnd_widget <?php echo $_smarty_tpl->tpl_vars['box']->value['uniqName'];?>
">
    <?php if ($_smarty_tpl->tpl_vars['box']->value['show_title']){?>
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('block_decorator', array('name'=>'box_cap','iconClass'=>$_smarty_tpl->tpl_vars['box']->value['icon'],'label'=>$_smarty_tpl->tpl_vars['box']->value['title'],'addClass'=>"ow_dnd_configurable_component clearfix",'type'=>$_smarty_tpl->tpl_vars['box']->value['type'])); $_block_repeat=true; echo smarty_block_block_decorator(array('name'=>'box_cap','iconClass'=>$_smarty_tpl->tpl_vars['box']->value['icon'],'label'=>$_smarty_tpl->tpl_vars['box']->value['title'],'addClass'=>"ow_dnd_configurable_component clearfix",'type'=>$_smarty_tpl->tpl_vars['box']->value['type']), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_block_decorator(array('name'=>'box_cap','iconClass'=>$_smarty_tpl->tpl_vars['box']->value['icon'],'label'=>$_smarty_tpl->tpl_vars['box']->value['title'],'addClass'=>"ow_dnd_configurable_component clearfix",'type'=>$_smarty_tpl->tpl_vars['box']->value['type']), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <?php }?>

    <?php $_smarty_tpl->smarty->_tag_stack[] = array('block_decorator', array('name'=>'box','type'=>$_smarty_tpl->tpl_vars['box']->value['type'],'addClass'=>"ow_stdmargin clearfix ".($_smarty_tpl->tpl_vars['box']->value['uniqName']),'toolbar'=>$_smarty_tpl->tpl_vars['box']->value['toolbar'])); $_block_repeat=true; echo smarty_block_block_decorator(array('name'=>'box','type'=>$_smarty_tpl->tpl_vars['box']->value['type'],'addClass'=>"ow_stdmargin clearfix ".($_smarty_tpl->tpl_vars['box']->value['uniqName']),'toolbar'=>$_smarty_tpl->tpl_vars['box']->value['toolbar']), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <?php echo $_smarty_tpl->tpl_vars['content']->value;?>

    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_block_decorator(array('name'=>'box','type'=>$_smarty_tpl->tpl_vars['box']->value['type'],'addClass'=>"ow_stdmargin clearfix ".($_smarty_tpl->tpl_vars['box']->value['uniqName']),'toolbar'=>$_smarty_tpl->tpl_vars['box']->value['toolbar']), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</div><?php }} ?>