<?php

namespace app\controllers;

use Yii;
use app\models\Ticket;
use app\models\Timeslot;
use app\models\TicketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Da\QrCode\QrCode;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ticket models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new TicketSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize=50;

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single Ticket model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // return $this->render('view', [
        //     'model' => $this->findModel($id),
        // ]);
    }

    public function actionCheck($id)
    {
        return $this->render('check', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionNotAllowed()
    {
        return $this->render('notallowed', [
            
        ]);
    }

    public function actionVerify($key)
    {
        $ticket = Ticket::find()->where(['key' => $key])->andWhere(['status' => 'pending'])->andWhere(['email_verified' => 0])->one();
        if(!empty($ticket)){
            $model = $this->findModel($ticket->id);
            $model->email_verified=1;
            $model->status='active';
            $timeslot = Timeslot::findOne($ticket->timeslot_id);
            if ($timeslot->count < $model->timeslot->shop->max_per_slot) {
                $timeslot->count = $timeslot->count + 1;
            }
            if($model->save() && $timeslot->save()) {
                $qrCode = (new QrCode($model->getShopVerificationLink()))
                ->setSize(250)
                ->setMargin(5)
                ->useForegroundColor(51, 153, 255);
                $body='<html xmlns="http://www.w3.org/1999/xhtml"><head></head><body>';
                $body.='<h3>Confirmed: '.$model->getSubject().'</h3>';
                $body.='<h4>Shop: '.$model->timeslot->shop->name.'</h4>';
                $body.='<h4>Key: '.$model->key.'</h4>';
                $body.='<h4>Surname: '.$model->surname.'</h4>';
                $body.='<h4>Start: '.$model->timeslot->start_timestamp.'</h4>';
                $body.='<h4>End: '.$model->timeslot->end_timestamp.'</h4>';
                $body.='<img src="' . $qrCode->writeDataUri() . '" />';
                $body.='<p>'.'<a href="'.$model->getShopVerificationLink().'">Verify Validity</a>'.'</p>';
                $body.='</body></html>';
                Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($model->email)
                ->setSubject('Confirmed: '.$model->getSubject())
                ->setHtmlBody($body)
                ->send();
                return $this->render('verify', [
                    'model' => $model,
                    'success' => 1,
                ]);
            }
        }
        else {
            return $this->render('verify', [
                'model' => null,
                'success' => 0,
            ]);
        }

    }

    public function actionShopVerify($key)
    {
        $ticket = Ticket::find()->where(['key' => $key])->andWhere(['status' => 'active'])->andWhere(['email_verified' => 1])->one();
        if(!empty($ticket)){
            return $this->render('shop-verify', [
                'success' => 1,
            ]);
        }
        else {
            return $this->render('shop-verify', [
                'success' => 0,
            ]);
        }

    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        // $model = new Ticket();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        // return $this->render('create', [
        //     'model' => $model,
        // ]);
    }


    /**
     * Book a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionBook($timeslot)
    {
        $model = new Ticket();
        $model->timeslot_id = $timeslot;
        if ($model->load(Yii::$app->request->post())) {
            // 'id' => 'ID',
            // 'key' => 'Key',
            // 'qr' => 'Qr',
            // 'surname' => 'Surname',
            // 'nic' => 'NIC',
            // 'email' => 'Email',
            // 'status' => 'Status',
            // 'timeslot_id' => 'Timeslot',
            // 'email_verified' => 'Email Verified',
            $model->key = Yii::$app->getSecurity()->generateRandomString();
            $model->status = 'pending';
            $model->email_verified=0;
            if( $model->surnameIsAllowed() ) {
                if($model->save()) {
                    $body='<html xmlns="http://www.w3.org/1999/xhtml"><head></head><body>';
                    $body.='<h3>'.$model->getSubject().'</h3>';
                    $body.='<p>'.'<a href="'.$model->getVerificationLink().'">Click here to complete booking</a>'.'</p>';
                    $body.='</body></html>';
                    Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo($model->email)
                    ->setSubject($model->getSubject())
                    ->setHtmlBody($body)
                    ->send();
                    return $this->redirect(['check', 'id' => $model->id]);
                }
            }
            else {
                return $this->redirect(['not-allowed', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
