<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/AdvertBoard/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/advertboard')) {
            $cache->deleteTree(
                $dev . 'assets/components/advertboard/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/advertboard/', $dev . 'assets/components/advertboard');
        }
        if (!is_link($dev . 'core/components/advertboard')) {
            $cache->deleteTree(
                $dev . 'core/components/advertboard/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/advertboard/', $dev . 'core/components/advertboard');
        }
    }
}

return true;