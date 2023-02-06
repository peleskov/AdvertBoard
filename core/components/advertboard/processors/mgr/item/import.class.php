<?php
class AdvertBoardImportIndexProcessor extends modObjectProcessor
{
    public $importTime;

    public function process()
    {
        $csv_file = MODX_BASE_PATH . $this->getProperty('csv_file');
        $AdvertBoard = $this->modx->getService('AdvertBoard', 'AdvertBoard', MODX_CORE_PATH . 'components/advertboard/model/', '');
        if (empty($csv_file) || !file_exists($csv_file)) {
            return $this->failure($this->modx->lexicon('adverts_import_err_csv'));
        } else {
            if (($handle = fopen($csv_file, "r")) !== FALSE) {
                while (($csv_data = fgetcsv($handle, null, ";")) !== FALSE) {
                    $data = [];
                    foreach ($csv_data as $d) {
                        $data[] = trim($d, '"');
                    }
                    /*
                    0 => "Дата"
                    1 => "E-mail пользователя"
                    2 => "ID категории"
                    3 => "Имя автора"
                    4 => "Заголовок"
                    5 => "Содержание"
                    6 => "Цена"
                    7 => "Путь до изображения"
                    8 => "Автврака"
                    */
                    //Создаем пользователя и его профиль, если его еще нет
                    $username = $data[1];
                    if (!$user = $this->modx->getObject('modUser', array('username' => $username))) {
                        $user = $this->modx->newObject('modUser');
                        $user->set('username', $username);
                        $user->set('password', 'XX_' . $username);
                        $user->set('active', 1);
                        $user->save();
                        $user->joinGroup(2); //Users
                        $user->joinGroup(3); //Fake
                        $user->set('createdon', random_int(strtotime('2022-01-01'), strtotime('2022-08-31')));
                        $user->save();
                        if (!$profile = $this->modx->getObject('modUserProfile', array('internalKey' => $user->get('id')))) {
                            $profile = $this->modx->newObject('modUserProfile');
                            $profile->set('internalKey', $user->get('id'));
                            $profile->set('fullname', $data[3]);
                            $profile->set('email', $username);
                            $profile->save();
                        }
                    }
                    $advert = $this->modx->newObject('Advert');
                    $advert->set('created', time());
                    $advert->set('updated', time());
                    $advert->set('user_id', $user->get('id'));
                    $advert->set('status', 0);
                    $advert->set('pid', $data[2]);
                    $advert->set('title', $data[4]);
                    $advert->set('content', $data[5]);
                    $advert->set('price', $data[6]);
                    $advert->set('hash', hash('sha256', time() . $user->get('id') . $data[3] . $data[4] . $data[5] . $data[6] . rand()));
                    $image_path = MODX_BASE_PATH . $data[7];
                    if (!empty($data[7]) && file_exists($image_path)) {
                        $images_dir = MODX_ASSETS_PATH . 'adverts/usr_' . $user->get('id');
                        $imageMaxSize = 1048576;
                        $imageExt = ['jpg', 'png', 'jpeg'];
                        $new_imgs = [];
                        if (!file_exists($images_dir)) mkdir($images_dir, 0755, true);

                        $extImage = trim(mb_strtolower(pathinfo($image_path, PATHINFO_EXTENSION)));
                        if (!in_array($extImage, $imageExt)){
                            $this->modx->log(1, $data[7] . ' - Файл имеет не допустимый формат.');
                            break;
                        }
                        if (filesize($image_path) >= $imageMaxSize) {
                            $this->modx->log(1, $data[7] . ' - Размер фотографии превышает допустимый лимит в 1 Мбайт.');
                            break;
                        }
                        $newImageName = md5(basename($image_path) . rand()) . '.' . $extImage;
                        $newImagePath = $images_dir . '/' . $newImageName;
                        if (copy($image_path, $newImagePath)) {
                            $phpThumb = $this->modx->getService('modphpthumb', 'modPhpThumb', MODX_CORE_PATH . 'model/phpthumb/', array());
                            $phpThumb->setSourceFilename($newImagePath);
                            $phpThumb->setParameter('w', 260);
                            $phpThumb->setParameter('h', 180);
                            $phpThumb->setParameter('zc', 1);
                            $phpThumb->setParameter('q', 80);
                            $newImage = str_replace(MODX_BASE_PATH, '', $newImagePath);
                            if ($phpThumb->GenerateThumbnail()) {
                                if ($phpThumb->RenderToFile($newImagePath)) {
                                    $new_imgs[] = array(
                                        'name' => $newImageName,
                                        'name_original' => basename($data[7]),
                                        'path' => $newImage,
                                        'url' => $newImage,
                                        'full_url' => MODX_SITE_URL . $newImage,
                                        'size' => filesize($newImagePath),
                                        'extension' => $extImage
                                    );
                                }
                            }
                        }
                        $images = [];
                        /* Если нужно добавлять фото, а не заменять
                        if ($advert->get('images') != '') {
                            $images = json_decode($advert->get('images'), true);
                        }
                        */

                        if (!empty($new_imgs)) {
                            $images = array_merge($images, $new_imgs);
                        }
                        if (!empty($images)) {
                            $advert->set('images', json_encode($images, true));
                        }
                    } else {
                        $this->modx->log(1, $data[7] . ' - Фал не найден.');
                        break;
                    }
                    $advert->save();
                }
            } else {
                return $this->failure($this->modx->lexicon('adverts_import_err_csv'));
            }
            return $this->success();
        }
    }
}

return 'AdvertBoardImportIndexProcessor';
