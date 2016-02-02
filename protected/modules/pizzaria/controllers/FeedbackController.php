<?php

class FeedbackController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionAjaxSave() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Feedback;
            $model->attributes = $_POST['Feedback'];

            if ($model->save()) {
                echo true;
            }

            Yii::app()->end();
        } else
            throw new CHttpException(400);
    }

    /**
     * Performs the AJAX validation.
     * @param Feedback $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'Feedback') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
