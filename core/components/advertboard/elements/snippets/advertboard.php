<?php
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
$path = $modx->getOption('pdofetch_class_path', null, MODX_CORE_PATH . 'components/pdotools/model/', true);
if ($pdoClass = $modx->loadClass($fqn, $path, false, true)) {
    $pdoFetch = new $pdoClass($modx, $scriptProperties);
} else {
    return false;
}
$pdoFetch->addTime('pdoTools loaded');

$AdvertBoard = $modx->getService('AdvertBoard', 'AdvertBoard', MODX_CORE_PATH . 'components/advertboard/model/', $scriptProperties);
if (!$AdvertBoard) {
    return 'Could not load AdvertBoard class!';
}

switch ($action) {
    case 'advert/get':
        $sortby = $modx->getOption('sortby', $scriptProperties, '`updated`');
        $sortdir = $modx->getOption('sortdir', $scriptProperties, 'DESC');
        $outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
        $parents = $modx->getOption('parents', $scriptProperties, '');
        $depth = $modx->getOption('depth', $scriptProperties, 10);
        $hash = $modx->getOption('hash', $scriptProperties, '');
        $where = json_decode($modx->getOption('where', $scriptProperties, '{}'), true);
        $totalVar = $modx->getOption('totalVar', $scriptProperties, 'total');
        $limit = $modx->getOption('limit', $scriptProperties, 5);
        $offset = $modx->getOption('offset', $scriptProperties, 0);
        if (!empty($hash)) {
            $where['hash'] = $hash;
        } else {
            if (!empty($parents)) {
                $parentIDs = [];
                foreach (explode(',', $parents) as $parent) {
                    $pIDs = $modx->getChildIds($parent, $depth);
                    $parentIDs = array_merge($parentIDs, $pIDs);
                }
                $parentIDs = array_merge($parentIDs, explode(',', $parents));
                $where['Advert.pid:IN'] = $parentIDs;
            }
        }

        $q = $modx->newQuery('Advert');
        $q->leftJoin('modUserProfile', 'Profile', array('`Profile`.`internalKey` = `Advert`.`user_id`'));
        $q->select(array(
            '`Advert`.*',
            '`Profile`.`internalKey` AS `usr_id`',
            '`Profile`.`fullname` AS `fullname`',
            '`Profile`.`email` AS `email`',
            '`Profile`.`mobilephone` AS `mobilephone`',
            '`Profile`.`photo` AS `avatar`',
            '`Profile`.`city` AS `city`'
        ));
        if (isset($query) && $query != '') {
            $query_sanitize = $modx->sanitizeString($query);
            $search = array();
            $search[] = 'MATCH(`Advert`.`title`) AGAINST ("' . $query_sanitize . '" IN BOOLEAN MODE)';
            foreach (explode(' ', $query_sanitize) as $s) {
                if (mb_strlen($s) > 3) {
                    $search[] = '`Advert`.`title` LIKE "%' . $s . '%"';
                    $search[] = '`Advert`.`content` LIKE "%' . $s . '%"';
                }
            }
        }
        $q->where($where);
        if(!empty($search)){
            $q->where(array($search), xPDOQuery::SQL_OR);
        }
        $total = $modx->getCount('Advert', $q);
        $modx->setPlaceholder($totalVar, $total);
        $q->sortby($sortby, $sortdir);
        $q->limit($limit, $offset);
        $q->prepare();
        //return $q->toSQL();
        $adverts = $modx->getIterator('Advert', $q);
        $items = [];
        $idx = 0;
        foreach ($adverts as $advert) {
            $idx += 1;
            if ($advert->get('images')) {
                $adv_images = json_decode($advert->get('images'), true);
            }
            $item = array_merge($advert->toArray(), $scriptProperties);
            $items[] = empty($tpl)
                ? '<pre>' . $pdoFetch->getChunk('', $item) . '</pre>'
                : $pdoFetch->getChunk($tpl, $item);
        }

        $output = array_merge(array('wrapper' => implode($outputSeparator, $items)), $scriptProperties);
        $output = empty($tplOut)
            ? '<pre>' . $pdoFetch->getChunk('', $items) . '</pre>'
            : $pdoFetch->getChunk($tplOut, $output);
        return $output;
        break;
    case 'advert/create':
        // Откликаться будет ТОЛЬКО на ajax запросы
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
            return;
        }
        $redirectID = $modx->getOption('redirectID', $scriptProperties, 1);
        $editPageID = $modx->getOption('editPageID', $scriptProperties, '');
        $editButtonID = $modx->getOption('editButtonID', $scriptProperties, '');
        $thumbW = $modx->getOption('thumbW', $scriptProperties, 260);
        $thumbH = $modx->getOption('thumbH', $scriptProperties, 180);
        $thumbZC = $modx->getOption('thumbZC', $scriptProperties, 1);
        $thumbQ = $modx->getOption('thumbQ', $scriptProperties, 80);

        $errors = [];
        $params = [];
        foreach (['title', 'price', 'pid'] as $field) { // валидация обязательных полей
            if (!empty($_POST[$field])) {
                if ($field == 'pid') {
                    $params[$field] = (int) $_POST[$field];
                } else {
                    $params[$field] = strip_tags($_POST[$field]);
                }
            } else {
                $errors[$field] = 'Это поле не может быть пустым.';
            }
            if ($field == 'price' && (float) $_POST[$field] < 100) {
                $errors[$field] = 'Цена должна быть не меньше 100 руб.';
            }
        }
        if ($params['pid'] <= 0 || !$resource = $modx->getObject('modResource', array('id' => $params['pid']))) {
            $errors['pid'] = 'Укажите категорию!';
        }
        foreach (['content', 'old_price'] as $field) { // не обязательные поля
            $params[$field] = strip_tags($_POST[$field]);
        }

        if ($user = $modx->getUser()) {
            $user_id = $user->id;
        } else {
            $errors['user_id'] = 'User required.';
        }
        if ($hash) {
            if (!$advert = $modx->getObject('Advert', array('hash' => $hash, 'user_id' => $user_id))) {
                $errors['error'] = 'Для этого пользователя не найдено такое объявление!';
            }
        } else {
            if ($advert = $modx->newObject('Advert')) {
                $advert->set('user_id', $user_id);
                $advert->set('status', 0);
                $advert->set('created', time());
                $advert->set('hash', hash('sha256', time() . $user_id . $_POST['title'] . $_POST['content'] . $_POST['price'] . rand()));
            } else {
                $errors['error'] = 'Не получается создать объявление!';
            }
        }
        if (empty($errors)) {
            $advert->set('updated', time());
            foreach ($params as $key => $field) {
                $advert->set($key, $field);
            }

            if (isset($_FILES['images']) && !empty($_FILES['images'])) {
                $images_dir = rtrim($modx->getOption('imagesDirPath', $scriptProperties, MODX_ASSETS_PATH . 'adverts/usr_' . $user_id), '/');
                $imageMaxSize = $modx->getOption('imageMaxSize', $scriptProperties, 1048576);
                $imgExt = explode(',', $modx->getOption('imageExt', $scriptProperties, 'jpg,png,jpeg'));
                $imageExt = [];
                foreach ($imgExt as $ext) {
                    $imageExt[] = trim(mb_strtolower($ext));
                }
                if (!file_exists($images_dir)) mkdir($images_dir, 0755, true);

                $new_images = [];
                foreach ($_FILES['images'] as $k => $l) {
                    foreach ($l as $i => $v) {
                        $new_images[$i][$k] = $v;
                    }
                }
                foreach ($new_images as $key => $new_image) {
                    if ($new_image['error'] == 0) {
                        $extImage = trim(mb_strtolower(pathinfo($new_image['name'], PATHINFO_EXTENSION)));
                        if ($new_image['size'] >= $imageMaxSize) {
                            $errors['photo'][$new_image['name']] = 'Размер фотографии превышает допустимый лимит в 1 Мбайт.';
                            break;
                        }
                        if (is_uploaded_file($new_image['tmp_name']) && in_array($extImage, $imageExt)) {
                            $newImageName = md5($new_image['name'] . rand()) . '.' . $extImage;
                            $newImagePath = $images_dir . '/' . $newImageName;
                            if (move_uploaded_file($new_image['tmp_name'], $newImagePath)) {
                                $phpThumb = $modx->getService('modphpthumb', 'modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/', array());
                                $phpThumb->setSourceFilename($newImagePath);
                                $phpThumb->setParameter('w', $thumbW);
                                $phpThumb->setParameter('h', $thumbH);
                                $phpThumb->setParameter('zc', $thumbZC);
                                $phpThumb->setParameter('q', $thumbQ);
                                $newImage = str_replace(MODX_BASE_PATH, '', $newImagePath);
                                if ($phpThumb->GenerateThumbnail()) if ($phpThumb->RenderToFile($newImagePath)) {
                                    $new_imgs[] = array(
                                        'name' => $newImageName,
                                        'name_original' => $new_image['name'],
                                        'path' => $newImage,
                                        'url' => $newImage,
                                        'full_url' => MODX_SITE_URL . $newImage,
                                        'size' => $new_image['size'],
                                        'extension' => $extImage
                                    );
                                }
                            }
                        }
                    }
                }
                $images = [];
                /* Если нужно добавлять фото, а не заменять
                if ($advert->get('images') != '') {
                    $images = json_decode($advert->get('images'), true);
                }
                */
                if ($new_imgs) {
                    $images = array_merge($images, $new_imgs);
                }
                $advert->set('images', json_encode($images, true));
            }
            if ($advert->save()) {
                return $AjaxForm->success('', array('service' => 'advertboard', 'result' => true, 'message' => $scriptProperties['successMsg'], 'modalID' => $scriptProperties['successModalID'], 'errors' => $errors, 'location' => $modx->makeUrl($redirectID), 'redirectEdit' => $modx->makeUrl($editPageID, '', ['a' => $advert->get('hash')]), 'editButtonID' => $editButtonID));
            } else {
                $errors['error'] = 'Не получается сохранить объявление!';
                return $AjaxForm->error('', array('service' => 'advertboard', 'result' => false, 'message' => $scriptProperties['errorMsg'], 'modalID' => $scriptProperties['errorModalID'], 'errors' => $errors));
            }
        } else {
            return $AjaxForm->error('', array('service' => 'advertboard', 'result' => false, 'message' => $scriptProperties['errorMsg'], 'modalID' => $scriptProperties['errorModalID'], 'errors' => $errors));
        }

        break;
    case 'advert/delete':
        // Откликаться будет ТОЛЬКО на ajax запросы
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
            return;
        }

        $redirectID = $modx->getOption('redirectID', $scriptProperties, 1);

        $errors = [];
        if ($user = $modx->getUser()) {
            $user_id = $user->id;
        } else {
            $errors['user_id'] = 'User required.';
        }
        if ($hash) {
            if (!$advert = $modx->getObject('Advert', array('hash' => $hash, 'user_id' => $user_id))) {
                $errors['error'] = 'Для этого пользователя не найдено такое объявление!';
            }
        } else {
            $errors['hash'] = 'Требуется hash объявления!';
        }
        if (empty($errors)) {
            if ($advert->remove()) {
                return $AjaxForm->error('', array('service' => 'advertboard', 'result' => true, 'message' => $scriptProperties['successMsg'], 'modalID' => $scriptProperties['successModalID'], 'location' => $modx->makeUrl($redirectID)));
            } else {
                $errors['error'] = 'Ошибка при удалении объявления!';
                return $AjaxForm->error('', array('service' => 'advertboard', 'result' => false, 'message' => $scriptProperties['errorMsg'], 'modalID' => $scriptProperties['errorModalID'], 'errors' => $errors));
            }
        } else {
            return $AjaxForm->error('', array('service' => 'advertboard', 'result' => false, 'message' => $scriptProperties['errorMsg'], 'modalID' => $scriptProperties['errorModalID'], 'errors' => $errors));
        }
        break;
}