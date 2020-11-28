<?php
namespace frontend\controllers\admin;

use frontend\filters\AdminRole;
use frontend\models\ContactForm;
use frontend\models\search\ContactFormSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ContactController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AdminRole::class,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ContactFormSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', compact('searchModel', 'dataProvider'));
    }

    public function actionDelete($id)
    {
        $contact = ContactForm::findOne(['id' => $id]);

        if (empty($contact)) {
            throw new NotFoundHttpException("Registro no encontrado");
        }

        try {
            $result = $contact->delete();

            if ($result) {
                Yii::$app->session->setFlash('success', 'Registro borrado');
            }
        }

        catch (\Exception $ex) {
            Yii::$app->session->setFlash('error', "Error borrando registro: {$ex->getMessage()}");
        }

        return $this->redirect('/admin/contacto');
    }
}
