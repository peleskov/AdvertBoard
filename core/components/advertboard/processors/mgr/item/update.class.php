<?php

class AdvertBoardItemUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'Advert';
    public $classKey = 'Advert';
    public $languageTopics = ['advertboard'];
    //public $permission = 'save';


    /**
     * We doing special check of permission
     * because of our objects is not an instances of modAccessibleObject
     *
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $properties = [
            'id' => (int)$this->getProperty('id'),
            'title' => trim($this->getProperty('title')),
            'title' => trim($this->getProperty('title')),
            'price' => trim($this->getProperty('price')),
            'user_id' => trim($this->getProperty('user_id')),
            'pid' => trim($this->getProperty('pid')),
            'content' => trim($this->getProperty('content')),
            'img' => trim($this->getProperty('img')),
        ];

        if (empty($properties['id'])) {
            return $this->modx->lexicon('advertboard_item_err_ns');
        }
        foreach (['title', 'price', 'user_id', 'pid'] as $key) {
            if (empty($properties[$key])) {
                $this->modx->error->addField($key, $this->modx->lexicon('advertboard_item_err_' . $key));
            }
        }
        $this->object->set('updated', time());

        if ($properties['img']) {
            $ms = $this->modx->getObject('modMediaSource', $this->modx->getOption('default_media_source'));
            $ms_prop = $ms->get('properties');

            $images_dir = MODX_ASSETS_PATH . 'adverts/usr_' . $properties['user_id'];
            if (!file_exists($images_dir)) mkdir($images_dir, 0755, true);

            $extImage = mb_strtolower(pathinfo($properties['img'], PATHINFO_EXTENSION));
            $newImageName = md5($properties['img']) . '.' . $extImage;
            $newImagePath = $images_dir . '/' . $newImageName;
            $new_imgs = [];
            $phpThumb = $this->modx->getService('modphpthumb', 'modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/', array());
            $phpThumb->setSourceFilename(MODX_BASE_PATH . $ms_prop['basePath']['value'] . $properties['img']);
            $phpThumb->setParameter('w', 260);
            $phpThumb->setParameter('h', 180);
            $phpThumb->setParameter('zc', 1);
            $phpThumb->setParameter('q', 80);
            $newImage = str_replace(MODX_BASE_PATH, '', $newImagePath);

            if ($phpThumb->GenerateThumbnail()) {
                if ($phpThumb->RenderToFile($newImagePath)) {
                    $new_imgs[] = array(
                        'name' => $newImageName,
                        'name_original' => $properties['img'],
                        'path' => $newImage,
                        'url' => $newImage,
                        'full_url' => MODX_BASE_URL . $newImage,
                        'size' => 0,
                        'extension' => $extImage
                    );
                }
            }

            //$this->modx->log(modX::LOG_LEVEL_ERROR, print_r($phpThumb->debugmessages, 1));
            
            $this->setProperty('images', json_encode($new_imgs, true));
        }
        return parent::beforeSet();
    }
}


return 'AdvertBoardItemUpdateProcessor';
