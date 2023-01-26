<?php

class AdvertBoardItemRemoveProcessor extends modObjectProcessor
{
    public $objectType = 'Advert';
    public $classKey = 'Advert';
    public $languageTopics = ['advertboard'];
    //public $permission = 'remove';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('advertboard_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var AdvertBoardItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('advertboard_item_err_nf'));
            }

            $object->remove();
        }

        return $this->success();
    }

}

return 'AdvertBoardItemRemoveProcessor';