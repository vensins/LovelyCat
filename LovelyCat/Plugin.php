<?php

/**
 * 做我的猫
 * @package LovelyCat
 * @author Mr_ven
 * @version 1.0.0
 * @link https://www.mrven.top
 * version 1.0.0 做我的猫
 */
class LovelyCat_Plugin implements Typecho_Plugin_Interface
{
    const STATIC_DIR = '/usr/plugins/LovelyCat';

    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
		
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     *为footer添加js文件
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function footer()
    {
        $arr = self::LovelyCat();
        echo $arr['html'];
        echo $arr['js'];
    }

    /**
     * @return array
     */
    private static function LovelyCat()
    {
		
        $dir  = self::STATIC_DIR;
        $js   = '';
        $html = '';
		$html .= '<div id="hexo-helper-live2d"><canvas id="live2dcanvas" width="150" height="300"></canvas></div>';
		$html .= '
		<style>
		  #live2dcanvas{
			position: fixed;
			width: 150px;
			height: 300px;
			opacity:1;
			left: 200px;
			z-index: 999;
			pointer-events: none;
			bottom: -70px;
		  }
		</style>
		';
		$js   .= "<script type='text/javascript' src='{$dir}/live2d/device.min.js'></script>";
		$js   .= "<script type='text/javascript' src='{$dir}/live2d/script.js'></script>";
		
		$js .= '<script>';
		$js .= <<<JS
		const loadScript = function loadScript(c,b){var a=document.createElement("script");a.type="text/javascript";"undefined"!=typeof b&&(a.readyState?a.onreadystatechange=function(){if("loaded"==a.readyState||"complete"==a.readyState)a.onreadystatechange=null,b()}:a.onload=function(){b()});a.src=c;document.body.appendChild(a)};
(function(){
  if((typeof(device) != 'undefined') && (device.mobile())){
    document.getElementById("live2dcanvas").style.width = '75px';
    document.getElementById("live2dcanvas").style.height = '150px';
  }else
    if (typeof(device) === 'undefined') console.error('Cannot find current-device script.');
  loadScript("{$dir}/live2d/script.js", function(){loadlive2d("live2dcanvas", "{$dir}/live2d/assets/hijiki.model.json", 0.5);});
})();
JS;
		$js .= '</script>';
		
		
		
        return compact('js', 'html');
    }
}
