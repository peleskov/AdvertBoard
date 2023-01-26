<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var AdvertBoard $AdvertBoard */
$AdvertBoard = $modx->getService('AdvertBoard', 'AdvertBoard', MODX_CORE_PATH . 'components/advertboard/model/');
$modx->lexicon->load('advertboard:default');

// handle request
$corePath = $modx->getOption('advertboard_core_path', null, $modx->getOption('core_path') . 'components/advertboard/');
$path = $modx->getOption('processorsPath', $AdvertBoard->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);