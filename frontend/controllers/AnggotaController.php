<?php

namespace frontend\controllers;

use Yii;
use common\models\Anggota;
use common\models\DbpegawaiPubPegawai;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AnggotaController implements the CRUD actions for Anggota model.
 */
class AnggotaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['site/index']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['verify-email','resend-verification-email','select-karyawan'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['biodata','update','update-email','update-foto','update-foto-ktp','update-hp','select-karyawan'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionBiodata()
    {
        return $this->render('biodata', [
            'model' => $this->findModelAnggota(Yii::$app->user->identity->id),
        ]);
    }

    public function actionSelectKaryawan($q = null, $nomor_pegawai = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = DbpegawaiPubPegawai::find()
                ->orWhere(['ilike', 'pegNama', $q])
                ->orWhere(['ilike', 'pegKodeResmi', $q])
                ->limit(20)
                ->all();
            $data = [];
            foreach($query as $item)
                $data[] = [
                    'id' => $item->pegKodeResmi,
                    'text' => $item->pegNama .' ('.$item->pegKodeResmi.')',
                ];

            $out['results'] = $data;
        }
        elseif ($nomor_pegawai > 0) {
            $out['results'] = ['nomor_pegawai' => $nomor_pegawai, 'text' => DbpegawaiPubPegawai::find([['nomor_pegawai'=>$nomor_pegawai]])->pegNama];
        }
        return $out;
    }


    /**
     * Updates an existing Anggota model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = $this->findModelAnggota(Yii::$app->user->identity->id);
        $model->scenario = 'frontend-update-anggota';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['biodata']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateEmail()
    {
        $model = $this->findModelAnggota(Yii::$app->user->identity->id);
        $model->scenario = 'frontend-update-anggota-email';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['biodata']);
        }

        return $this->render('update_email', [
            'model' => $model,
        ]);
    }

    public function actionUpdateFoto()
    {
        $model = $this->findModelAnggota(Yii::$app->user->identity->id);

        $model->scenario = 'frontend-update-anggota-foto';

		$current_foto = $model->foto;

        
        if ($model->load(Yii::$app->request->post())) {
            
            $upload = UploadedFile::getInstance($model, 'foto');
            if(!empty($upload)){
                $model->foto = bin2hex(file_get_contents($upload->tempName));
            } else {
				$model->foto = $current_foto;
			}

            if ($model->validate() && $model->save()) {
                return $this->redirect([
                    'biodata'
                ]);
            } else {
                $errors = $model->errors;
            }
        }
        
        return $this->render('update_foto', [
            'model' => $model,
        ]);
    }

    public function actionUpdateFotoKtp()
    {
        $model = $this->findModelAnggota(Yii::$app->user->identity->id);

        $model->scenario = 'frontend-update-anggota-foto_ktp';

		$current_foto = $model->foto_ktp;

        
        if ($model->load(Yii::$app->request->post())) {
            
            $upload = UploadedFile::getInstance($model, 'foto_ktp');
            if(!empty($upload)){
                $model->foto_ktp = bin2hex(file_get_contents($upload->tempName));
            } else {
				$model->foto_ktp = $current_foto;
			}

            if ($model->validate() && $model->save()) {
                return $this->redirect([
                    'biodata'
                ]);
            } else {
                $errors = $model->errors;
            }
        }
        
        return $this->render('update_foto_ktp', [
            'model' => $model,
        ]);
    }

    public function actionUpdateHp()
    {
        $model = $this->findModelAnggota(Yii::$app->user->identity->id);
        $model->scenario = 'frontend-update-anggota-hp';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['biodata']);
        }

        return $this->render('update_hp', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Anggota model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModelAnggota($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Anggota model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anggota the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anggota::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelAnggota($id)
    {
        if (($model = Anggota::findOneFrontendAnggota($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
