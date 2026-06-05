<?php

namespace app\modules\helpguide\controllers;

use app\modules\helpguide\models\HelpGuide;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class HelpguideController extends Controller
{


    public function behaviors()
    {


        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'toggle-status' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = HelpGuide::find()->orderBy(['id' => SORT_ASC]);

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);

        $docs = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'docs' => $docs,
            'pagination' => $pagination,
        ]);
    }
    

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new HelpGuide();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('_form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('_form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionToggleStatus($id)
    {
        $model = $this->findModel($id);
        $model->status = $model->status === 'active' ? 'inactive' : 'active';
        $model->save(false);
        return $this->asJson(['status' => $model->status]);
    }

    protected function findModel($id)
    {
        if (($model = HelpGuide::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested item does not exist.');
    }
    public function actionFront()
    {
        $search = Yii::$app->request->get('search', '');

        $query = \app\modules\helpguide\models\HelpGuide::find();

        if (!empty($search)) {
            $query->where([
                'or',
                ['like', 'title', $search],
                ['like', 'content', $search],
            ]);
        }

        $docs = $query->orderBy(['title' => SORT_ASC])->all(); 
        // Disable main layout so it looks like your standalone version
        $this->layout = false; 
        return $this->render('front', [
            'docs' => $docs,
            'search' => $search,
        ]);
    }
}
