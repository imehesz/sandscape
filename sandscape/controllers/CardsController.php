<?php

/* CardsController.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * Handles card administration available to administrations.
 * This class was renamed from <em>CardController</em>.
 * 
 * @since 1.2, Elvish Shaman
 */
class CardsController extends AppController {

    private static $NORMAL_WIDTH = 250;
    private static $NORMAL_HEIGHT = 354;
    private static $SMALL_WIDTH = 81;
    private static $SMALL_HEIGHT = 115;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    /**
     * Default administration action that lists all existing cards.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionIndex() {
        $filter = new Card('search');
        $filter->unsetAttributes();

        if (isset($_GET['Card'])) {
            $filter->attributes = $_GET['Card'];
        }

        $this->render('index', array('filter' => $filter));
    }

    /**
     * Creates a new card and allows for image uploads, creating all the necessary 
     * thumbs and reverted copies.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionCreate() {
        $new = new Card();
        $this->performAjaxValidation('card-form', $new);

        if (isset($_POST['Card'])) {
            $new->attributes = $_POST['Card'];
            //TODO: check that the image file is not already in the server or that 
            //no other file with the same name exists
            $path = Yii::getPathOfAlias('webroot') . '/_game/cards';
            $upfile = CUploadedFile::getInstance($new, 'image');

            if ($upfile !== null) {
                $name = $upfile->name;

                $sizes = getimagesize($upfile->tempName);
                $imgFactory = PhpThumbFactory::create($upfile->tempName);

                //250 width, 354 height
                if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                    $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
                }

                $imgFactory->save($path . '/' . $name);
                $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
                $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);

                $new->image = $name;
                $new->save();
            }
            $this->redirect(array('update', 'id' => $new->cardId));
        }

        $this->render('edit', array('card' => $new));
    }

    /**
     * Updates a card's information.
     * 
     * @param integer $id The card ID we want to update.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionUpdate($id) {
        $card = $this->loadCardModel($id);

        $this->performAjaxValidation('card-form', $card);

        if (isset($_POST['Card'])) {
            $card->attributes = $_POST['Card'];
            if ($card->save()) {
                $path = Yii::getPathOfAlias('webroot') . '/_game/cards';
                $upfile = CUploadedFile::getInstance($new, 'image');
                if ($upfile !== null) {

                    //remove old images, if they exist.
                    if ($card->image) {
                        //Don't really care if removable fails, will delete orphan 
                        //cards at a later time.
                        unlink($path . '/' . $card->image);
                        unlink($path . '/thumbs/' . $card->image);
                        unlink($path . '/thumbs/reversed/' . $card->image);

                        $card->image = null;
                    }

                    $name = $upfile->name;

                    $sizes = getimagesize($upfile->tempName);
                    $imgFactory = PhpThumbFactory::create($upfile->tempName);

                    //250 width, 354 height
                    if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                        $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
                    }

                    $imgFactory->save($path . '/' . $name);
                    $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
                    $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);

                    $new->image = $name;
                    $new->save();
                }
                $this->redirect(array('update', 'id' => $card->cardId));
            }
        }

        $this->render('edit', array('card' => $card));
    }

    /**
     * Deletes a card by making it inactive.
     * 
     * @param integer $id The card ID.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionDelete($id) {
        if (Yii::app()->user->class && Yii::app()->request->isPostRequest) {
            $card = $this->loadCardModel($id);

            $card->active = 0;
            $card->save();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    /**
     * Allows administrators to import cards from CSV files.
     * The cards must be inside a <em>ZIP</em> archive, with a file named 
     * <strong>cards.csv</em> listing all the cards and with all images inside a 
     * folder named <strong>images</em>.
     * 
     * CSV file must have the following fields, in the order:
     *  - name, the name of the card, required field
     *  - rules, the rules text for the card, required field
     *  - image, the image file to use, this file needs to be inside a folder 
     *  named <em>images</em>, this is a required field
     *  - cardscape ID, the ID for cardscape system if this is a card imported 
     *  from Cardscape
     * 
     * @since 1.2, Elvish Shaman
     */
    public function actionImport() {
        if (isset($_POST['Upload'])) {
            $upfile = CUploadedFile::getInstanceByName('archive');
            if ($upfile !== null) {
                $destination = Yii::app()->assetManager->basePath . '/import/';
                $path = Yii::getPathOfAlias('webroot') . '/_game/cards';
                if (!$upfile->error) {
                    $zip = new ZipArchive();
                    if ($zip->open($upfile->tempName) === true) {
                        $zip->extractTo($destination);
                        $zip->close();

                        unlink($upfile->tempName);

                        if (($fh = fopen($destination . 'cards/cards.csv', 'r')) !== false) {
                            while (($csvLine = fgetcsv($fh, 2500, ',')) !== FALSE) {
                                if (!isset($csvLine[2])) {
                                    continue;
                                }

                                if (($card = Card::model()->find('name LIKE :name', array(':name' => $csvLine[0]))) === null) {
                                    $card = new Card();
                                    $card->name = $csvLine[0];
                                }
                                $card->active = 1;
                                $card->rules = $csvLine[1];
                                if (isset($csvLine[3]) && (int) $csvLine[3] != 0) {
                                    $card->cardscapeId = (int) $csvLine[3];
                                }

                                $name = $csvLine[2];
                                if (!is_file($path . '/' . $name)) {
                                    $sizes = getimagesize($destination . 'cards/images/' . $csvLine[2]);
                                    $imgFactory = PhpThumbFactory::create($destination . 'cards/images/' . $csvLine[2]);

                                    //250 width, 354 height
                                    if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
                                        $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
                                    }

                                    $imgFactory->save($path . '/' . $name);
                                    $imgFactory->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)->save($path . '/thumbs/' . $name);
                                    $imgFactory->rotateImageNDegrees(180)->save($path . '/thumbs/reversed/' . $name);

                                    $card->image = $name;
                                }
                                if (!$card->save()) {
                                    //TODO: add errors to the list
                                }
                            }
                            fclose($fh);
                            //TODO: remove the import folder, recursive file removal.
                        }
                    }
                }
            } else {
                //TODO: show error message
            }
        }

        $this->render('import');
    }

    /**
     * Loads a card model from the database.
     * 
     * @param integer $id The ID for the card.
     * @return Card The card model.
     * 
     * @since 1.2, Elvish Shaman
     */
    private function loadCardModel($id) {
        if (($card = Card::model()->find('active = 1 AND cardId = :id', array(':id' => (int) $id))) === null) {
            throw new CHttpException(404, 'The requested card does not exist.');
        }
        return $card;
    }

    /**
     * Adds new rules for this controller.
     * 
     * @return array The merged rules array.
     * 
     * @since 1.2, Elvish Shaman
     */
    public function accessRules() {
        return array_merge(array(
                    array('allow',
                        'actions' => array('index', 'create', 'update', 'delete', 'view', 'import'),
                        'expression' => '$user->class'
                    )
                        ), parent::accessRules());
    }

}
