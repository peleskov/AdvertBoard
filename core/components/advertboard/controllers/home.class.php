<?php

/**
 * The home manager controller for AdvertBoard.
 *
 */
class AdvertBoardHomeManagerController extends modExtraManagerController
{
    /** @var AdvertBoard $AdvertBoard */
    public $AdvertBoard;


    /**
     *
     */
    public function initialize()
    {
        $this->AdvertBoard = $this->modx->getService('AdvertBoard', 'AdvertBoard', MODX_CORE_PATH . 'components/advertboard/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['advertboard:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('advertboard');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->AdvertBoard->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/advertboard.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->AdvertBoard->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        AdvertBoard.config = ' . json_encode($this->AdvertBoard->config) . ';
        AdvertBoard.config.connector_url = "' . $this->AdvertBoard->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "advertboard-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="advertboard-panel-home-div"></div>';

        return '';
    }
}