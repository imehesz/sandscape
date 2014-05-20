<?php

/* StatesController.php
 *  
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2014, Sérgio Lopes <knitter@wtactics.org>
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class StatesController extends BaseController {

//    private static $NORMAL_WIDTH = 270;
//    private static $NORMAL_HEIGHT = 382;
//    private static $SMALL_WIDTH = 101;
//    private static $SMALL_HEIGHT = 143;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);
    }

    public function accessRules() {
        return array(
            array(
                'allow',
                'actions' => array('index', 'new', 'edit', 'delete'),
                'expression' => '$user->isGameMaster()'
            ),
            array(
                'deny',
                'users' => array('*')
            )
        );
    }

    public function actionIndex() {
        $filter = new State('search');
        $filter->unsetAttributes();

        if (isset($_GET['State'])) {
            $filter->attributes = $_GET['State'];
        }

        $this->render('index', array('filter' => $filter));
    }

    public function actionNew() {
        $state = new State();
        $this->performAjaxValidation('state-form', $state);

        if (isset($_POST['State'])) {
            $state->attributes = $_POST['State'];
            //$this->saveUpload($state);

            if ($state->save()) {
                $this->redirect(array('edit', 'id' => $state->id));
            }
        }

        $this->render('update', array('state' => $state));
    }

    public function actionEdit($id) {
        $state = $this->loadStateModel($id);
        $this->performAjaxValidation('state-form', $state);

        if (isset($_POST['State'])) {
            $state->attributes = $_POST['State'];
            //$this->saveUpload($state);

            if ($state->save()) {
                $this->redirect(array('edit', 'id' => $state->id));
            }
        }

        $this->render('update', array('state' => $state));
    }

    public function actionDelete($id) {
        $state = $this->loadStateModel($id);

        $state->active = 0;
        $state->save();

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    private function saveUpload(State $state) {
//        Yii::import('ext.PhpThumbFactory');
//        $path = Yii::getPathOfAlias('webroot') . '/gamedata/states';
//        $upfile = CUploadedFile::getInstance($state, 'image');
//
//        if ($upfile !== null) {
//            $name = md5($upfile->name . time()) . substr($upfile->name, strpos($upfile->name, '.'));
//
//            $sizes = getimagesize($upfile->tempName);
//            $imgFactory = PhpThumbFactory::create($upfile->tempName);
//            //250 + 20 width, 354 + 28 height
//            if ($sizes[0] > self::$NORMAL_WIDTH || $sizes[1] > self::$NORMAL_HEIGHT) {
//                $imgFactory->resize(self::$NORMAL_WIDTH, self::$NORMAL_HEIGHT);
//            }
//            $imgFactory->save($path . '/' . $name)
//                    ->resize(self::$SMALL_WIDTH, self::$SMALL_HEIGHT)
//                    ->save($path . '/thumbs/' . $name)
//                    ->rotateImageNDegrees(180)
//                    ->save($path . '/thumbs/reversed/' . $name);
//
//            $state->image = $name;
//        }
    }

    private function loadStateModel($id) {
        if (!($state = State::model()->findByPk((int) $id))) {
            throw new CHttpException(404, Yii::t('sandscape', 'The requested state does not exist.'));
        }
        return $state;
    }

}
